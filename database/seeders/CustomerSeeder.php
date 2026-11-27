<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $roleId = Role::where('name', 'Customer')->value('id');

        $customers = [
            [
                'name' => 'Rina Wijaya',
                'email' => 'rina@rentalku.test',
                'phone' => '081234567894',
                'address' => 'Jl. Gajah Mada No. 21, Pontianak',
            ],
            [
                'name' => 'Dimas Prakoso',
                'email' => 'dimas@rentalku.test',
                'phone' => '081234567895',
                'address' => 'Jl. Malioboro No. 8, Yogyakarta',
            ],
            [
                'name' => 'Sari Melati',
                'email' => 'sari@rentalku.test',
                'phone' => '081234567896',
                'address' => 'Jl. Dago No. 77, Bandung',
            ],
            [
                'name' => 'Bayu Nugroho',
                'email' => 'bayu@rentalku.test',
                'phone' => '081234567897',
                'address' => 'Jl. Basuki Rahmat No. 12, Surabaya',
            ],
        ];

        foreach ($customers as $customer) {
            User::updateOrCreate(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'roles_id' => $roleId,
                    'phone' => $customer['phone'],
                    'address' => $customer['address'],
                    'password' => 'password123',
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
