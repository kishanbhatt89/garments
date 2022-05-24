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

        $client_management_create = Permission::create(['name' => 'client_management-create']);
        $client_management_read = Permission::create(['name' => 'client_management-read']);
        $client_management_update = Permission::create(['name' => 'client_management-update']);
        $client_management_delete = Permission::create(['name' => 'client_management-delete']);

        $client_management_create->assignRole('admin');
        $client_management_read->assignRole('admin');
        $client_management_update->assignRole('admin');
        $client_management_delete->assignRole('admin');

        $state_management_create = Permission::create(['name' => 'state_management-create']);
        $state_management_read = Permission::create(['name' => 'state_management-read']);
        $state_management_update = Permission::create(['name' => 'state_management-update']);
        $state_management_delete = Permission::create(['name' => 'state_management-delete']);

        $state_management_create->assignRole('admin');
        $state_management_read->assignRole('admin');
        $state_management_update->assignRole('admin');
        $state_management_delete->assignRole('admin');

        $city_management_create = Permission::create(['name' => 'city_management-create']);
        $city_management_read = Permission::create(['name' => 'city_management-read']);
        $city_management_update = Permission::create(['name' => 'city_management-update']);
        $city_management_delete = Permission::create(['name' => 'city_management-delete']);

        $city_management_create->assignRole('admin');
        $city_management_read->assignRole('admin');
        $city_management_update->assignRole('admin');
        $city_management_delete->assignRole('admin');

        $designation_management_create = Permission::create(['name' => 'designation_management-create']);
        $designation_management_read = Permission::create(['name' => 'designation_management-read']);
        $designation_management_update = Permission::create(['name' => 'designation_management-update']);
        $designation_management_delete = Permission::create(['name' => 'designation_management-delete']);

        $designation_management_create->assignRole('admin');
        $designation_management_read->assignRole('admin');
        $designation_management_update->assignRole('admin');
        $designation_management_delete->assignRole('admin');

        $gst_profile_management_create = Permission::create(['name' => 'gst_profile_management-create']);
        $gst_profile_management_read = Permission::create(['name' => 'gst_profile_management-read']);
        $gst_profile_management_update = Permission::create(['name' => 'gst_profile_management-update']);
        $gst_profile_management_delete = Permission::create(['name' => 'gst_profile_management-delete']);

        $gst_profile_management_create->assignRole('admin');
        $gst_profile_management_read->assignRole('admin');
        $gst_profile_management_update->assignRole('admin');
        $gst_profile_management_delete->assignRole('admin');

        $setting_management_create = Permission::create(['name' => 'setting_management-create']);
        $setting_management_read = Permission::create(['name' => 'setting_management-read']);
        $setting_management_update = Permission::create(['name' => 'setting_management-update']);
        $setting_management_delete = Permission::create(['name' => 'setting_management-delete']);

        $setting_management_create->assignRole('admin');
        $setting_management_read->assignRole('admin');
        $setting_management_update->assignRole('admin');
        $setting_management_delete->assignRole('admin');
    }
}
