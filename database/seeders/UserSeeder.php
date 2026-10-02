<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's default users.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->value('id');
        $staffRole = Role::where('name', 'Staff')->value('id');
        $customerRole = Role::where('name', 'Customer')->value('id');

        $users = [
            [
                'name' => 'Admin RentalKu',
                'email' => 'admin@rentalku.test',
                'roles_id' => $adminRole,
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 1, Jakarta',
            ],
            [
                'name' => 'Staff RentalKu',
                'email' => 'staff@rentalku.test',
                'roles_id' => $staffRole,
                'phone' => '081234567892',
                'address' => 'Jl. Sudirman No. 1, Jakarta',
            ],
            [
                'name' => 'Customer RentalKu',
                'email' => 'customer@rentalku.test',
                'roles_id' => $customerRole,
                'phone' => '081234567893',
                'address' => 'Jl. Merdeka No. 10, Bandung',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'roles_id' => $user['roles_id'],
                    'phone' => $user['phone'],
                    'address' => $user['address'],
                    'password' => 'password123',
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
