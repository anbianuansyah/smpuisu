<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create user
        $user = User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('password'),
        ]);

        // Ambil role admin untuk guard 'api'
        $role = Role::where('name', 'admin')->where('guard_name', 'api')->first();

        // Assign semua permission ke role ini
        $permissions = Permission::where('guard_name', 'api')->get();
        $role->syncPermissions($permissions);

        // Assign role ke user
        $user->assignRole($role);
    }
}