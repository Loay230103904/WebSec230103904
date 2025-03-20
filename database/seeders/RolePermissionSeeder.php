<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // إنشاء الأدوار
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $employee = Role::firstOrCreate(['name' => 'employee']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // إنشاء الصلاحيات
        $permissions = ['view_users', 'edit_users', 'delete_users', 'change_password', 'edit_profile'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // إعطاء الصلاحيات للأدوار
        $admin->givePermissionTo(['view_users', 'edit_users', 'delete_users', 'change_password']);
        $employee->givePermissionTo(['edit_profile']);
        $user->givePermissionTo(['edit_profile']);
    }
}
