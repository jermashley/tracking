<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // All permissions
        $permissions = [
            'company:create',
            'company:read',
            'company:update',
            'company:delete',
            'user:create',
            'user:read',
            'user:update',
            'user:delete',
            'user:impersonate',
            'image:create',
            'image:read',
            'image:update',
            'image:delete',
            'theme:create',
            'theme:read',
            'theme:update',
            'theme:delete',
            'role:create',
            'role:read',
            'role:update',
            'role:delete',
            'permission:create',
            'permission:read',
            'permission:update',
            'permission:delete',
            'allowed_domain:create',
            'allowed_domain:read',
            'allowed_domain:update',
            'allowed_domain:delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $companyAdmin = Role::firstOrCreate(['name' => 'Company Admin']);
        $standard = Role::firstOrCreate(['name' => 'Standard']);

        // Assign all permissions to Super Admin
        $superAdmin->syncPermissions(Permission::all());

        // Assign only company and theme permissions to Company Admin
        $companyAdminPermissions = [
            'company:create',
            'company:read',
            'company:update',
            'company:delete',
            'theme:create',
            'theme:read',
            'theme:update',
            'theme:delete',
        ];
        $companyAdmin->syncPermissions($companyAdminPermissions);

        // Standard has no permissions per your spec
        $standard->syncPermissions([]);

        $this->command->info('Roles and permissions seeded successfully.');
    }
}
