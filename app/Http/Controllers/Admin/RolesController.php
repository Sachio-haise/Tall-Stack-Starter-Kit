<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use Exception;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public $field,
        $search,
        $permission,
        $_setpermission = 'roles',
        $paginate = 20;

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
        // permission check
        $this->checkPermission($this->permission['create']);
        // prepare the query fields
        $filter = Helper::getArrayMerge($this->field);
        // Not include deleted
        $filter = array_values(array_diff($filter, ['deleted_at']));

        // prepare for table and pagination
        $roles = $this->getSearchData(null, $filter);
        $respond = [
            'allow_permissions' => $this->permission,
            'search' => $this->search,
            'paginate' => $roles,
        ];
        return view('roles.index', compact('respond'));
    }

    public function search(Request $request)
    {
        // permission check
        $this->checkPermission($this->permission['create']);
        // request search data
        $this->search = [
            'search' => $request->search,
            'include_deleted' => $request->include_deleted,
        ];
        // prepare the query fields
        $filter = Helper::getArrayMerge($this->field);
        // Not include deleted
        $filter = array_values(array_diff($filter, ['deleted_at']));
        // prepare for table, pagination and append search data
        $roles = $this->getSearchData($request, $filter);
        $roles->appends($this->search);

        $respond = [
            'allow_permissions' => $this->permission,
            'search' => $this->search,
            'paginate' => $roles,
        ];
        return view('roles.index', compact('respond'));
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

    private function getSearchData($request = null, array $field)
    {
        $status = $this->getStatus();
        $query = Role::select($field);
        if ($status) {
            // Not include createdBy and updatedBy
            // $query = Role::select($field)->with('createdBy', 'updatedBy');
            $query = Role::select($field);
        }

        if ($request) {
            if ($request->include_deleted == 1) {
                // $query->withTrashed();
            }

            if ($request->search) {
                $query->where('name', 'LIKE', "%$request->search%");
            }
        }

        return $query->orderBy('id', 'desc')->paginate($this->paginate);
    }

    private function checkPermission($permission, $data = null)
    {
        return $this->authorize($permission, $data);
    }

    private function setPermission($permission)
    {
        $this->permission = config('roles.permissions')[$permission];
    }

    private function getStatus(): bool
    {
        return auth()
            ->user()
            ->hasPermissionTo($this->permission['status']) ||
            auth()
            ->user()
            ->hasRole('super-admin');
    }
}

