<?php

namespace Database\Seeders;

use App\Models\MetodePembayaran;
use App\Models\Pembayaran;
use App\Models\Rental;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use RuntimeException;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            'Demo: rental menunggu innova plus supir' => ['Bank Mandiri', 'Menunggu'],
            'Demo: rental disetujui pajero' => ['Bank BCA', 'Disetujui'],
            'Demo: rental disetujui hiace plus supir' => ['Bank Mandiri', 'Menunggu'],
            'Demo: rental ditolak brio' => ['Bank BNI', 'Ditolak'],
            'Demo: rental berjalan alphard' => ['Bank BCA', 'Disetujui'],
            'Demo: rental berjalan rush' => ['QRIS', 'Disetujui'],
            'Demo: rental selesai ertiga' => ['Bank BRI', 'Disetujui'],
            'Demo: rental selesai terios' => ['GoPay', 'Disetujui'],
            'Demo: rental selesai vios' => ['OVO', 'Disetujui'],
            'Demo: rental selesai triton' => ['DANA', 'Disetujui'],
            'Demo: rental selesai evalia' => ['Bank BCA', 'Disetujui'],
        ];

        $rentals = Rental::whereIn('catatan', array_keys($rows))->get()->keyBy('catatan');
        $metodes = MetodePembayaran::pluck('id', 'name');
        $sumber = public_path('images/mobils/AVANZA.jpg');

        foreach ($rows as $marker => [$namaMetode, $status]) {
            $rental = $rentals[$marker] ?? null;

            if (! $rental) {
                throw new RuntimeException("Rental dengan catatan \"{$marker}\" tidak ditemukan.");
            }

            $metodeId = $metodes[$namaMetode] ?? null;

            if (! $metodeId) {
                throw new RuntimeException("Metode pembayaran {$namaMetode} tidak ditemukan (rental: {$marker}).");
            }

            $bukti = 'bukti_pembayaran/demo-'.$rental->id.'.jpg';
            $tujuan = storage_path('app/public/'.$bukti);

            if (! File::exists($tujuan)) {
                File::ensureDirectoryExists(dirname($tujuan));
                File::copy($sumber, $tujuan);
            }

            Pembayaran::updateOrCreate(
                ['rental_id' => $rental->id],
                [
                    'metode_pembayaran_id' => $metodeId,
                    'tanggal_bayar' => now()->startOfDay()->subDays(2)->toDateString(),
                    'jumlah' => $rental->total_harga,
                    'bukti' => $bukti,
                    'status' => $status,
                ]
            );
        }
    }
}
