<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'sanctum',
            'description' => 'Role with access to all system features.',
            'color' => 'purple',
        ]);

        $role->syncPermissions(Permission::all());

        $user = UserEloquent::firstOrCreate(
            ['email' => 'admin@mantek.com'],
            [
                'first_name'  => 'Mantek',
                'last_name'   => 'Manager',
                'phone'       => '000000000',
                'password'    => bcrypt('Administrator#'),
                'department'  => 'Administration',
                'notes'       => null,
                'avatar_url'  => null,
                'is_active'   => true,
                'last_login'  => now(),
                'created_by'  => null,
                'updated_by'  => null,
            ]
        );

        $user->assignRole($role);
    }
}
