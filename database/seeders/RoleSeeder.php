<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's roles.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Administrator dengan akses penuh.'],
            ['name' => 'Staff', 'description' => 'Staff yang mengelola operasional rental.'],
            ['name' => 'Customer', 'description' => 'Pengguna umum yang melakukan rental.'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}