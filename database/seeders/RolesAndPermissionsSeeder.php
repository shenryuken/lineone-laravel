<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'staff']);
        Role::create(['name' => 'funds_manager']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'merchant']);

        // Create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage funds']);
        Permission::create(['name' => 'manage transactions']);
        Permission::create(['name' => 'view merchant dashboard']);

        // Assign permissions to roles
        Role::findByName('admin')->givePermissionTo(['manage users', 'manage transactions']);
        Role::findByName('merchant')->givePermissionTo('view merchant dashboard');

        // Create a demo admin user
        $admin = User::factory()->create([
            'name' => 'Admin User 2',
            'email' => 'admin2@example.com',
        ]);
        $admin->assignRole('admin');

        // Create a demo merchant user
        $merchant = User::factory()->create([
            'name' => 'Merchant User',
            'email' => 'merchant@example.com',
        ]);
        $merchant->assignRole('merchant');

        // Assign 'user' role to all other existing users
        User::whereDoesntHave('roles')->get()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}

