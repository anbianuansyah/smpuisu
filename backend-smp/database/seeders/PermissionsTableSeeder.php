<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //permission for posts
        Permission::create(['name' => 'posts.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'posts.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'posts.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'posts.delete', 'guard_name' => 'api']);

        //permission for categories
        Permission::create(['name' => 'categories.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'categories.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'categories.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'categories.delete', 'guard_name' => 'api']);

        //permission for sliders
        Permission::create(['name' => 'sliders.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'sliders.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'sliders.delete', 'guard_name' => 'api']);

        //permission for roles
        Permission::create(['name' => 'roles.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'roles.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'roles.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'roles.delete', 'guard_name' => 'api']);

        //permission for permissions
        Permission::create(['name' => 'permissions.index', 'guard_name' => 'api']);

        //permission for users
        Permission::create(['name' => 'users.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'users.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'users.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'users.delete', 'guard_name' => 'api']);

        //permission for products
        Permission::create(['name' => 'products.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'products.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'products.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'products.delete', 'guard_name' => 'api']);

        //permission for pages
        Permission::create(['name' => 'pages.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'pages.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'pages.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'pages.delete', 'guard_name' => 'api']);

        //permission for photos
        Permission::create(['name' => 'photos.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'photos.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'photos.delete', 'guard_name' => 'api']);

        //permission for gurus
        Permission::create(['name' => 'gurus.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'gurus.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'gurus.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'gurus.delete', 'guard_name' => 'api']);
    }
}