<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_management_create = Permission::create(['name' => 'user_management-create']);
        $user_management_read = Permission::create(['name' => 'user_management-read']);
        $user_management_update = Permission::create(['name' => 'user_management-update']);
        $user_management_delete = Permission::create(['name' => 'user_management-delete']);

        $user_management_create->assignRole('admin');
        $user_management_read->assignRole('admin');
        $user_management_update->assignRole('admin');
        $user_management_delete->assignRole('admin');

        $role_management_create = Permission::create(['name' => 'role_management-create']);
        $role_management_read = Permission::create(['name' => 'role_management-read']);
        $role_management_update = Permission::create(['name' => 'role_management-update']);
        $role_management_delete = Permission::create(['name' => 'role_management-delete']);

        $role_management_create->assignRole('admin');
        $role_management_read->assignRole('admin');
        $role_management_update->assignRole('admin');
        $role_management_delete->assignRole('admin');

        $permission_management_create = Permission::create(['name' => 'permission_management-create']);
        $permission_management_read = Permission::create(['name' => 'permission_management-read']);
        $permission_management_update = Permission::create(['name' => 'permission_management-update']);
        $permission_management_delete = Permission::create(['name' => 'permission_management-delete']);

        $permission_management_create->assignRole('admin');
        $permission_management_read->assignRole('admin');
        $permission_management_update->assignRole('admin');
        $permission_management_delete->assignRole('admin');
    }
}
