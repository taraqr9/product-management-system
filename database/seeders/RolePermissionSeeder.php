<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create_products',
            'edit_products',
            'delete_products',
            'view_products',
            'manage_users',
            'manage_roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::create(['name' => 'admin']);
        $viewer = Role::create(['name' => 'viewer']);

        $admin->givePermissionTo($permissions);
        $viewer->givePermissionTo('view_products');
    }
}
