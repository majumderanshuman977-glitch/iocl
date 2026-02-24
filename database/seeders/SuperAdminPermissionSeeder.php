<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
       public function run(): void
    {
        // $role = Role::firstOrCreate(['name' => 'super_admin']);


        // $permissions = Permission::all();
     $allPermissions = Permission::pluck('name')->toArray();

        // $role->syncPermissions($permissions);

        $users = User::role('super_admin')->get();

        foreach ($users as $user) {
            $user->syncPermissions($allPermissions);

        }
    }
}
