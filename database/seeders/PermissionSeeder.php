<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::create(['name' => 'admin_panel']);
        Permission::create(['name' => 'view_content']);
        Permission::create(['name' => 'create_comments']);
        Permission::create(['name' => 'bookmark_books']);

        $userRole = Role::where(['name' => 'user'])->first();
//        $userRole->givePermissionTo('create_posts');

        $adminRole = Role::where(['name' => 'admin'])->first();
        $adminRole->givePermissionTo(Permission::all());

        $guestRole = Role::where(['name' => 'guest'])->first();
//        $guestRole->givePermissionTo('view_content','update_posts');
    }
}
