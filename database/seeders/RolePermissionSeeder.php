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
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'user-create',
            'user-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api', // Ensure the guard is 'api'
            ]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $viewer = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'api']);

        $admin->givePermissionTo($permissions);
        $viewer->givePermissionTo(['product-list']);
    }
}
