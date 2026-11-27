<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'nama' => 'Andi Saputra',
                'email' => 'andi@example.com',
                'subjek' => 'Tanya sewa bulanan',
                'pesan' => 'Apakah tersedia paket sewa bulanan untuk Avanza?',
                'status' => 'Belum Dibaca',
                'balasan' => null,
                'dibalas_pada' => null,
            ],
            [
                'nama' => 'Maya Putri',
                'email' => 'maya@example.com',
                'subjek' => 'Ketersediaan Alphard',
                'pesan' => 'Apakah Alphard tersedia untuk akhir bulan?',
                'status' => 'Dibaca',
                'balasan' => null,
                'dibalas_pada' => null,
            ],
            [
                'nama' => 'Rudi Hartono',
                'email' => 'rudi@example.com',
                'subjek' => 'Konfirmasi pembayaran',
                'pesan' => 'Saya sudah transfer, mohon dicek.',
                'status' => 'Dibalas',
                'balasan' => 'Pembayaran sudah kami verifikasi. Terima kasih.',
                'dibalas_pada' => now()->subDay(),
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::updateOrCreate(
                [
                    'email' => $contact['email'],
                    'subjek' => $contact['subjek'],
                ],
                [
                    'nama' => $contact['nama'],
                    'pesan' => $contact['pesan'],
                    'status' => $contact['status'],
                    'balasan' => $contact['balasan'],
                    'dibalas_pada' => $contact['dibalas_pada'],
                ]
            );
        }
    }
}
