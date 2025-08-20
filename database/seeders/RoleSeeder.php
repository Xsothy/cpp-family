<?php

namespace Database\Seeders;

use App\Enums\UserRole;
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
        // Create permissions
        $permissions = [
            'view_family_members',
            'create_family_members',
            'edit_family_members',
            'delete_family_members',
            'view_families',
            'create_families',
            'edit_families',
            'delete_families',
            'manage_users',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        foreach (UserRole::cases() as $roleEnum) {
            $role = Role::firstOrCreate([
                'name' => $roleEnum->value,
                'guard_name' => 'web'
            ]);

            // Assign permissions based on role
            match ($roleEnum) {
                UserRole::ADMIN => $role->syncPermissions($permissions),
                UserRole::HEAD_OF_COMMUNE => $role->syncPermissions([
                    'view_family_members', 'create_family_members', 'edit_family_members',
                    'view_families', 'create_families', 'edit_families',
                    'view_reports'
                ]),
                UserRole::SUB_OF_HEAD_OF_COMMUNE => $role->syncPermissions([
                    'view_family_members', 'create_family_members', 'edit_family_members',
                    'view_families', 'view_reports'
                ]),
                UserRole::HEAD_OF_DISTRICT => $role->syncPermissions([
                    'view_family_members', 'view_families', 'view_reports'
                ]),
                UserRole::SUB_OF_DISTRICT => $role->syncPermissions([
                    'view_family_members', 'view_families'
                ]),
            };
        }
    }
}
