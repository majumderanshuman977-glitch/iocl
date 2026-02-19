<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
       public function run(): void
    {
        // Create roles
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin'],
            ['guard_name' => 'web']
        );

        $subAdminRole = Role::firstOrCreate(
            ['name' => 'sub_admin'],
            ['guard_name' => 'web']
        );

       
        $allPermissions = Permission::pluck('name')->toArray();
        $superAdminRole->syncPermissions($allPermissions);


        $user = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345678'),
                'mobile' => '1234567890',
                'role_name' => 'super_admin',
                'status' => 'active',
            ]
        );


        $user->syncRoles([$superAdminRole]);


        $user->syncPermissions($allPermissions);
    }
}
