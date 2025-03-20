<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // إنشاء الأدوار
        Role::insert([
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'user', 'guard_name' => 'web'],
            ['name' => 'employee', 'guard_name' => 'web'],
        ]);

        // إنشاء يوزرات وإعطائهم الأدوار
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole('user');

        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => bcrypt('password123'),
        ]);
        $employee->assignRole('employee');
    }
}
