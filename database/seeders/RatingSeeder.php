<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'marker' => 'Demo: rental selesai ertiga',
                'rating' => 5,
                'komentar' => 'Mobil bersih, proses cepat.',
            ],
            [
                'marker' => 'Demo: rental selesai terios',
                'rating' => 4,
                'komentar' => 'Pelayanan baik, mobil sempat kotor.',
            ],
            [
                'marker' => 'Demo: rental selesai vios',
                'rating' => 5,
                'komentar' => 'Kompensasi cepat, terima kasih.',
            ],
            [
                'marker' => 'Demo: rental selesai triton',
                'rating' => 5,
                'komentar' => 'Sangat memuaskan.',
            ],
        ];

        $staffId = User::where('email', 'staff@rentalku.test')->value('id');

        if (! $staffId) {
            throw new RuntimeException('User staff@rentalku.test tidak ditemukan untuk rating demo.');
        }

        foreach ($rows as $row) {
            $rental = Rental::where('catatan', $row['marker'])->first();

            if (! $rental) {
                throw new RuntimeException("Rental dengan catatan \"{$row['marker']}\" tidak ditemukan.");
            }

            Rating::updateOrCreate(
                ['rental_id' => $rental->id],
                [
                    'customer_id' => $rental->user_id,
                    'staff_id' => $staffId,
                    'rating' => $row['rating'],
                    'komentar' => $row['komentar'],
                ]
            );
        }
    }
}
