<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'allowed_domain:store',
            'allowed_domain:show',
            'allowed_domain:update',
            'allowed_domain:destroy',

            'company:store',
            'company:show',
            'company:update',
            'company:destroy',

            'user:store',
            'user:show',
            'user:update',
            'user:destroy',
            'user:impersonate',

            'image:store',
            'image:show',
            'image:update',
            'image:destroy',

            'theme:store',
            'theme:show',
            'theme:update',
            'theme:destroy',

            'role:store',
            'role:show',
            'role:update',
            'role:destroy',

            'permission:store',
            'permission:show',
            'permission:update',
            'permission:destroy',
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
            'company:store',
            'company:show',
            'company:update',
            'company:destroy',
            'theme:store',
            'theme:show',
            'theme:update',
            'theme:destroy',
        ];
        $companyAdmin->syncPermissions($companyAdminPermissions);

        // Standard has no permissions per your spec
        $standard->syncPermissions([]);

        $this->command->info('Roles and permissions seeded successfully.');
    }
}
