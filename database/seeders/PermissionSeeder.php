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
        $employee_management_create = Permission::create(['name' => 'employee_management-create']);
        $employee_management_read = Permission::create(['name' => 'employee_management-read']);
        $employee_management_update = Permission::create(['name' => 'employee_management-update']);
        $employee_management_delete = Permission::create(['name' => 'employee_management-delete']);

        $employee_management_create->assignRole('admin');
        $employee_management_read->assignRole('admin');
        $employee_management_update->assignRole('admin');
        $employee_management_delete->assignRole('admin');

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
