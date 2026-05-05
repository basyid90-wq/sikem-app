<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['super_admin', 'kudd', 'mubaligh', 'guru_apim', 'mualaf'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'basyid90@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('901022aspura'),
            ]
        );

        // Assign role
        $superAdmin->assignRole('super_admin');
    }
}
