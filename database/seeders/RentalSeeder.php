<?php

namespace Database\Seeders;

use App\Models\Mobil;
use App\Models\Rental;
use App\Models\Supir;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'marker' => 'Demo: rental menunggu avanza',
                'user' => 'customer@rentalku.test',
                'plate' => 'KB 1001 AA',
                'start' => 3,
                'end' => 6,
                'supir' => null,
                'kupon' => null,
                'status' => 'Menunggu',
            ],
            [
                'marker' => 'Demo: rental menunggu innova plus supir',
                'user' => 'rina@rentalku.test',
                'plate' => 'D 3456 GHI',
                'start' => 5,
                'end' => 7,
                'supir' => 'Agus Salim',
                'kupon' => 'HEMAT10',
                'status' => 'Menunggu',
            ],
            [
                'marker' => 'Demo: rental disetujui pajero',
                'user' => 'dimas@rentalku.test',
                'plate' => 'L 7890 JKL',
                'start' => 1,
                'end' => 5,
                'supir' => null,
                'kupon' => null,
                'status' => 'Disetujui',
            ],
            [
                'marker' => 'Demo: rental disetujui hiace plus supir',
                'user' => 'sari@rentalku.test',
                'plate' => 'B 5678 ABC',
                'start' => 2,
                'end' => 5,
                'supir' => 'Budi Santoso',
                'kupon' => null,
                'status' => 'Disetujui',
            ],
            [
                'marker' => 'Demo: rental ditolak brio',
                'user' => 'bayu@rentalku.test',
                'plate' => 'KB 2002 DD',
                'start' => 4,
                'end' => 6,
                'supir' => null,
                'kupon' => null,
                'status' => 'Ditolak',
            ],
            [
                'marker' => 'Demo: rental berjalan alphard',
                'user' => 'customer@rentalku.test',
                'plate' => 'B 1234 XYZ',
                'start' => -2,
                'end' => 3,
                'supir' => 'Slamet Riyadi',
                'kupon' => null,
                'status' => 'Berjalan',
            ],
            [
                'marker' => 'Demo: rental berjalan rush',
                'user' => 'rina@rentalku.test',
                'plate' => 'KB 2001 CC',
                'start' => -1,
                'end' => 2,
                'supir' => null,
                'kupon' => null,
                'status' => 'Berjalan',
            ],
            [
                'marker' => 'Demo: rental selesai ertiga',
                'user' => 'dimas@rentalku.test',
                'plate' => 'KB 1002 BB',
                'start' => -8,
                'end' => -5,
                'supir' => null,
                'kupon' => null,
                'status' => 'Selesai',
            ],
            [
                'marker' => 'Demo: rental selesai terios',
                'user' => 'sari@rentalku.test',
                'plate' => 'KB 3001 EE',
                'start' => -12,
                'end' => -10,
                'supir' => null,
                'kupon' => null,
                'status' => 'Selesai',
            ],
            [
                'marker' => 'Demo: rental selesai vios',
                'user' => 'bayu@rentalku.test',
                'plate' => 'KS 4001 FF',
                'start' => -19,
                'end' => -15,
                'supir' => null,
                'kupon' => null,
                'status' => 'Selesai',
            ],
            [
                'marker' => 'Demo: rental selesai triton',
                'user' => 'customer@rentalku.test',
                'plate' => 'KT 5001 GG',
                'start' => -25,
                'end' => -22,
                'supir' => null,
                'kupon' => null,
                'status' => 'Selesai',
            ],
            [
                'marker' => 'Demo: rental selesai evalia',
                'user' => 'rina@rentalku.test',
                'plate' => 'KT 6001 HH',
                'start' => -30,
                'end' => -27,
                'supir' => null,
                'kupon' => null,
                'status' => 'Selesai',
            ],
        ];

        $users = User::pluck('id', 'email');
        $mobils = Mobil::whereIn('plate_number', array_column($rows, 'plate'))->get()->keyBy('plate_number');
        $supirs = Supir::whereIn('name', array_filter(array_column($rows, 'supir')))->get()->keyBy('name');

        $staffId = $users['staff@rentalku.test'] ?? null;

        if (! $staffId) {
            throw new RuntimeException('User staff@rentalku.test tidak ditemukan untuk dikembalikan_oleh rental demo.');
        }

        $mobilDisewa = [];

        foreach ($rows as $row) {
            $userId = $users[$row['user']] ?? null;

            if (! $userId) {
                throw new RuntimeException("User dengan email {$row['user']} tidak ditemukan (rental: {$row['marker']}).");
            }

            $mobil = $mobils[$row['plate']] ?? null;

            if (! $mobil) {
                throw new RuntimeException("Mobil dengan plat {$row['plate']} tidak ditemukan (rental: {$row['marker']}).");
            }

            $supir = null;

            if ($row['supir'] !== null) {
                $supir = $supirs[$row['supir']] ?? null;

                if (! $supir) {
                    throw new RuntimeException("Supir dengan nama {$row['supir']} tidak ditemukan (rental: {$row['marker']}).");
                }
            }

            $mulai = now()->startOfDay()->addDays($row['start']);
            $selesai = now()->startOfDay()->addDays($row['end']);
            $jumlahHari = (int) $mulai->diffInDays($selesai);

            $hargaPerhari = (float) $mobil->harga_perhari;
            $deposit = (float) ($mobil->deposit ?? 0);
            $subtotal = $jumlahHari * $hargaPerhari;
            $supirSubtotal = $supir ? $jumlahHari * (float) $supir->tarif_perhari : 0;
            $diskon = $row['kupon'] === 'HEMAT10'
                ? round(0.10 * ($subtotal + $supirSubtotal), 2)
                : 0;
            $totalHarga = max(0, $subtotal + $supirSubtotal + $deposit - $diskon);

            $rental = Rental::updateOrCreate(
                ['catatan' => $row['marker']],
                [
                    'user_id' => $userId,
                    'mobil_id' => $mobil->id,
                    'tanggal_mulai' => $mulai->toDateString(),
                    'tanggal_selesai' => $selesai->toDateString(),
                    'jumlah_hari' => $jumlahHari,
                    'harga_perhari' => $hargaPerhari,
                    'subtotal' => $subtotal,
                    'deposit' => $deposit,
                    'kode_promo' => $row['kupon'],
                    'diskon' => $diskon,
                    'total_harga' => $totalHarga,
                    'status' => $row['status'],
                    'tanggal_dikembalikan' => $row['status'] === 'Selesai' ? $selesai->copy()->setTime(17, 0) : null,
                    'dikembalikan_oleh' => $row['status'] === 'Selesai' ? $staffId : null,
                ]
            );

            $rental->supirs()->sync(
                $supir
                    ? [$supir->id => ['tarif_perhari' => $supir->tarif_perhari, 'sub_total' => $supirSubtotal]]
                    : []
            );

            if (in_array($row['status'], ['Disetujui', 'Berjalan'], true)) {
                $mobilDisewa[] = $mobil->id;
            }
        }

        Mobil::whereIn('id', $mobilDisewa)->update(['status' => 'Disewa']);
        Mobil::whereNotIn('id', $mobilDisewa)->update(['status' => 'Tersedia']);
    }
}
