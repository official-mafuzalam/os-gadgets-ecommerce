<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles and permissions
        $roles = [
            'super_admin',
            'admin',
            'user'
        ];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        $permissions = [
            'orders_manage',
            'products_manage',
            'categories_manage',
            'brands_manage',
            'deals_manage',
            'attributes_manage',
            'reviews_manage',
            'reports_view',
            'subscribers_manage',
            'settings_manage',
            'finance_manage',
            'roles_manage',
            'permissions_manage',
            'accounts_manage',
            'user_create',
            'block_user',
            'user_assign_role',
            'user_assign_permission',
            'user_edit',
            'user_delete'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to super_admin
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $superAdminRole->syncPermissions($permissions);
        }
    }
}