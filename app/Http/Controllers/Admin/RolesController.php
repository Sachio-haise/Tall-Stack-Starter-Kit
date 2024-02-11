<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\FormHelper;
use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use Exception;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RolesController extends Controller
{
    public $field,
        $search,
        $paginate = 20;

    public $permission,
        $live_permission = 'roles_',
        $_setpermission = 'roles';

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
        $title = 'Role';
        $total = Role::count();
        return view('roles.index', compact('permission', 'breadcrumbs', 'title', 'total', 'livePermission'));

    }

    public function create()
    {
        $this->checkPermission($this->permission['create']);
        $permissions = config('roles.permissions');
        return view('roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->checkPermission($this->permission['create']);
        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            $permissionNames = $request->permission;
            $permissions = [];

            foreach ($permissionNames as $permissionName) {
                if ($permissionName) {
                    $permission = Permission::where('name', $permissionName)->first();
                    if (!$permission) {
                        $permission = Permission::create([
                            'name' => $permissionName,
                            'guard_name' => 'web',
                        ]);
                    }
                    $permissions[] = $permission;
                }
            }
            $role->syncPermissions($permissions);
            $permission->assignRole($role);
            return redirect()
                ->route('roles.index')
                ->with([
                    'message' => 'Role created successfully.',
                    'style' => 'success',
                ]);
        } catch (Exception $e) {
            return redirect()
                ->route('roles.index')
                ->with([
                    'message' => $e,
                    'style' => 'danger',
                ]);
        }
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $this->checkPermission($this->permission['edit'], $role);
        $role->permissions;
        $permissions = config('roles.permissions');
        return view('roles.edit', [
            'roles' => $role,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $role = Role::findOrFail($id);
            $this->checkPermission($this->permission['edit'], $role);
            $permissionNames = $request->permission;
            $role->name = $request->name;
            $role->save();
            $permissions = [];

            foreach ($permissionNames as $permissionName) {
                if ($permissionName) {
                    $permission = Permission::where('name', $permissionName)->first();
                    if (!$permission) {
                        $permission = Permission::create([
                            'name' => $permissionName,
                            'guard_name' => 'web',
                        ]);
                    }
                    $permissions[] = $permission;
                }
            }
            $role->syncPermissions($permissions);
            $permission->assignRole($role);
            return redirect()
                ->route('roles.index')
                ->with([
                    'message' => 'Role ID ' . $id . ' updated successfully.',
                    'style' => 'success',
                ]);
        } catch (Exception $e) {
            return redirect()
                ->route('roles.index')
                ->with([
                    'message' => $e,
                    'style' => 'danger',
                ]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            $this->checkPermission($this->permission['delete'], $role);
            $role->delete();
            $role->permissions()->delete();
            return redirect()
                ->route('roles.index')
                ->with([
                    'message' => 'Role ID ' . $id . ' deleted successfully.',
                    'style' => 'success',
                ]);
        } catch (Exception $e) {
            return redirect()
                ->route('roles.index')
                ->with([
                    'message' => $e,
                    'style' => 'danger',
                ]);
        }
    }

    public function restore(string $id)
    {
        $role = Role::withTrashed()->findOrFail($id);
        $this->checkPermission($this->permission['restore'], $role);
        $role->restore();
        return redirect()
            ->route('roles.index')
            ->with([
                'message' => 'Role ID ' . $id . ' restored successfully.',
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

    private function getLivePermission($role)
    {
        return auth()->user()->getAllPermissions()
        ->pluck('name')
        ->filter(fn ($permission) => Str::startsWith($permission, $role))->toArray() ?? [];
    }
}

