<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $superAdminRole = Role::create(['name' => 'Superadmin']);
        $editorRole = Role::create(['name' => 'Editor']);

        // Create Permissions
        $manageUsers = Permission::create(['name' => 'manage_users']);
        $manageSettings = Permission::create(['name' => 'manage_settings']);
        $manageContent = Permission::create(['name' => 'manage_content']);

        // Assign Permissions to Roles
        $superAdminRole->givePermissionTo(Permission::all());
        $editorRole->givePermissionTo(['manage_content']);

        // Create default Superadmin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@sukorejo.desa.id'],
            [
                'name' => 'Admin Desa',
                'password' => Hash::make('password'), // Password default: password
                'is_active' => true,
            ]
        );
        $admin->assignRole('Superadmin');

        // Create default Editor user
        $editor = User::firstOrCreate(
            ['email' => 'editor@sukorejo.desa.id'],
            [
                'name' => 'Editor Desa',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $editor->assignRole('Editor');
    }
}
