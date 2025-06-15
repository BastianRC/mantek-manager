<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Src\Role\Domain\ValueObject\RolePermission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User
            'Create user',
            'Update user',
            'Delete user',
            'View user',
            'View all users',
            'Assign role',

            // Role
            'Create role',
            'Update role',
            'Delete role',
            'View role',
            'View all roles',
            'View all permissions',

            // Location
            'Create location',
            'Update location',
            'Delete location',
            'View location',
            'View all locations',

            // Machine
            'Create machine',
            'Update machine',
            'Delete machine',
            'View machine',
            'View all machines',

            // Work Order
            'Create work order',
            'Update work order',
            'Delete work order',
            'View work order',
            'View all work orders',

            // Chronology
            'View chronology',
            'View all chronologies',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'sanctum']);
        }
    }
}
