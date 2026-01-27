<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // POS
            'pos.access',
            'pos.apply-discount',
            'pos.apply-promo',
            'pos.void-order',
            'pos.edit-all-orders',
            
            // Activity
            'activity.view-all',
            'activity.view-own',
            'activity.update-status',
            'activity.delete',
            
            // Report
            'report.view',
            'report.export',
            
            // Inventory
            'inventory.view',
            'inventory.create',
            'inventory.edit',
            'inventory.delete',
            
            // Teams
            'teams.view',
            'teams.manage',
            
            // Settings
            'settings.store',
            'settings.tax',
            'settings.printer',
            'settings.tables',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Superadmin - all permissions
        $superadmin = Role::create(['name' => 'superadmin']);
        $superadmin->givePermissionTo(Permission::all());

        // Staff Full Time - limited permissions
        $fulltime = Role::create(['name' => 'staff-fulltime']);
        $fulltime->givePermissionTo([
            'pos.access',
            'pos.apply-discount',
            'pos.apply-promo',
            'pos.edit-all-orders',
            'activity.view-all',
            'activity.view-own',
            'activity.update-status',
            'report.view',
            'inventory.view',
            'settings.printer',
        ]);

        // Staff Part Time - minimal permissions
        $parttime = Role::create(['name' => 'staff-parttime']);
        $parttime->givePermissionTo([
            'pos.access',
            'pos.apply-promo',
            'activity.view-own',
            'activity.update-status',
        ]);

        // Create default superadmin user
        $admin = User::create([
            'name' => 'Admin Setara',
            'email' => 'admin@setaraspace.id',
            'password' => Hash::make('password'),
            'employment_type' => 'fulltime',
            'is_active' => true,
        ]);
        $admin->assignRole('superadmin');

        // Create sample staff user
        $staff = User::create([
            'name' => 'Kasir Demo',
            'email' => 'kasir@setaraspace.id',
            'password' => Hash::make('password'),
            'employment_type' => 'fulltime',
            'is_active' => true,
        ]);
        $staff->assignRole('staff-fulltime');
    }
}
