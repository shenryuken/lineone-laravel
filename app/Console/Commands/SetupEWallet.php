<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SetupEWallet extends Command
{
    protected $signature = 'ewallet:setup';
    protected $description = 'Setup roles and permissions for the e-wallet application';

    public function handle()
    {
        $this->info('Setting up roles and permissions...');

        // Create roles
        $roles = [
            'Super Admin',
            'Admin',
            'Fund Manager',
            'Staff',
            'User',
            'Merchant'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
            $this->info("Role '{$role}' created");
        }

        // Create basic permissions
        $permissions = [
            'manage users',
            'manage wallets',
            'manage transactions',
            'view reports',
            'process payments',
            'receive payments'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $this->info("Permission '{$permission}' created");
        }

        // Assign permissions to roles
        $superAdmin = Role::findByName('Super Admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('Admin');
        $admin->givePermissionTo(['manage users', 'manage wallets', 'view reports']);

        $fundManager = Role::findByName('Fund Manager');
        $fundManager->givePermissionTo(['manage transactions', 'view reports']);

        $staff = Role::findByName('Staff');
        $staff->givePermissionTo(['view reports']);

        $user = Role::findByName('User');
        $user->givePermissionTo(['process payments']);

        $merchant = Role::findByName('Merchant');
        $merchant->givePermissionTo(['process payments', 'receive payments']);

        $this->info('Roles and permissions setup completed successfully!');
    }
}

