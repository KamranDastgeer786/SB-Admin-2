<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DefaultRoleSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {

        // Create a default role
        $role = Role::create(['name' => 'defaultuser']);

        // Specify the permission IDs to assign
        $permissionIds = [5, 6, 7, 8, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52];

        // Retrieve permissions by the specified IDs
        $permissions = Permission::whereIn('id', $permissionIds)->pluck('id');

        // Assign specified permissions to the role
        $role->syncPermissions($permissions);
        // Create a default role
        // $role = Role::create(['name' => 'defaultuser']);

        // Specify the permission IDs to assign
        // $permissionIds = [5,6,7, 8, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50,51,52];

        // Retrieve permissions by the specified IDs
        // $permissions = Permission::whereIn('id', $permissionIds)->pluck('id');

        // Assign specified permissions to the role
        // $role->syncPermissions($permissions);
    }
}
