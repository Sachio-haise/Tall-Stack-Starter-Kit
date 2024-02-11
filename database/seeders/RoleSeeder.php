<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'root', 'guard_name' => 'web']);

        $permissions = config('roles.permissions');
        foreach ($permissions as $resource => $actions) {
            foreach ($actions as $action => $name) {
                Permission::create([
                    'name' => $name,
                    'guard_name' => 'web',
                ]);
            }
        }

        $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $permissionIds = Permission::pluck('id')->toArray();
        $role->syncPermissions($permissionIds);
    }
}
