<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\FormHelper;
use App\Http\Helpers\Helper;
use App\Http\Media\Storage;
use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use Exception;
use Illuminate\Database\QueryException;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public $field,
        $search,
        $paginate = 20;

    public $permission,
        $live_permission = 'items_',
        $_setpermission = 'items';

    public function __construct()
    {
        $this->field = ['id', 'name', 'guard_name'];
        $this->search = [
            'search' => '',
            'include_deleted' => '',
        ];
        $this->setPermission($this->_setpermission);
        $this->paginate = request()->get('paginate') ?: $this->paginate;
    }

    public function index()
    {
        $this->checkPermission($this->permission['list']);
        $permission = $this->permission;
        $livePermission = $this->getLivePermission($this->live_permission);
        $breadcrumbs = FormHelper::getBreadcrumb();
        $title = 'Item';
        $total = Item::count();
        return view('items.index', compact('permission', 'breadcrumbs', 'title', 'total', 'livePermission'));
    }

    public function create()
    {
        $this->checkPermission($this->permission['create']);
        $permission = $this->permission;
        $breadcrumbs = FormHelper::getBreadcrumb();
        return view('items.create', compact('permission', 'breadcrumbs'));
    }

    public function store(ItemRequest $request)
    {
        $this->checkPermission($this->permission['create']);
        try {
            $media_id = null;
            if ($request->hasFile('image_id')) {
                $response = Storage::upload($request->image_id, Item::class, null, $request->name);
                $media_id = $response['data']['id'] ?? null;
            }
            $item = Item::create([
                'name' => $request->name,
                'description' => $request->description,
                'image_id' => $media_id,
                'created_by' => auth()->user()->id,
            ]);
            return Helper::getHandleData('Item created successfully.', 'items.index', null, null);
        } catch (QueryException $e) {
            return Helper::getHandleData("Item can\'t be created.", 'items.create', null, $e);
        } catch (Exception $e) {
            return Helper::getHandleData("Item can\'t be created.", 'items.create', null, $e);
        }
    }

    public function edit(string $id)
    {
        $item = Item::with('ImageFile')->findOrFail($id);
        $permission = $this->permission;
        $breadcrumbs = FormHelper::getBreadcrumb();
        $this->checkPermission($this->permission['edit'], $item);
        return view('items.edit', compact('item', 'permission', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, string $id)
    {
        try {
            $item = Item::findOrFail($id);
            $this->checkPermission($this->permission['edit'], $item);

            if ($request->hasFile('image_id')) {
                $response = Storage::upload($request->image_id, Item::class, $item->image_id, $request->name);
                if ($response['status'] === 1) {
                    $media_id = $response['data']['id'] ?? null;
                    $item->image_id = $media_id;
                } else {
                    throw new Exception($response['message']);
                }
            }

            $item->name = $request->name;
            $item->description = $request->description;
            $item->updated_by = auth()->user()->id;
            $item->save();

            return Helper::getHandleData("Item ID {$id} updated successfully.", 'items.edit', $id, null);
        } catch (QueryException $e) {
            return Helper::getHandleData("Item can't be updated.", 'items.edit', $id, $e);
        } catch (Exception $e) {
            return Helper::getHandleData("Item can't be updated.", 'items.edit', $id, $e);
        }
    }

    public function destroy(string $id)
    {
        try {
            $item = Item::withTrashed()->findOrFail($id);
            $this->checkPermission($this->permission['delete'], $item);
            if ($item->trashed()) {
                $item->forceDelete();
                $return = Storage::delete($item->photo_url);
            } else {
                $item->delete();
            }
            return Helper::getHandleData("Item ID {$id} deleted successfully.", 'items.index', null, null);
        } catch (QueryException $e) {
            return Helper::getHandleData("Item can't be deleted.", 'items.index', null, $e);
        } catch (Exception $e) {
            return Helper::getHandleData("Item can't be deleted.", 'items.index', null, $e);
        }
    }

    public function restore($id)
    {
        $item = Item::withTrashed()->findOrFail($id);
        $this->checkPermission($this->permission['restore'], $item);
        $item->restore();
        return redirect()
            ->route('items.index')
            ->with([
                'message' => 'Item ID ' . $id . ' restored successfully.',
                'style' => 'success',
            ]);
    }

    private function checkPermission($permission, $data = null)
    {
        return $this->authorize($permission, $data);
    }

    private function setPermission($permission)
    {
        $this->permission = config('roles.permissions')[$permission];
    }

    private function getLivePermission($item)
    {
        return auth()->user()->getAllPermissions()
            ->pluck('name')
            ->filter(fn ($permission) => Str::startsWith($permission, $item))->toArray() ?? [];
    }
}
