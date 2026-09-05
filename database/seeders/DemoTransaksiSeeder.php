<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Denda;
use App\Models\Kompensasi;
use App\Models\MetodePembayaran;
use App\Models\Mobil;
use App\Models\Pembayaran;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoTransaksiSeeder extends Seeder
{
    /**
     * Transaksi demo: rental Selesai + pembayaran Disetujui, tanggal bayar
     * disebar dalam 30 hari terakhir supaya chart dashboard langsung terisi.
     */
    public function run(): void
    {
        mt_srand(42);

        $customer = User::where('roles_id', 3)->firstOrFail();
        $mobils = Mobil::orderBy('id')->get();
        $metodes = MetodePembayaran::orderBy('id')->get();
        $cabangs = Cabang::orderBy('id')->get();

        if ($mobils->isEmpty() || $metodes->isEmpty()) {
            $this->command->warn('Butuh data mobil & metode pembayaran dulu.');
            return;
        }

        $today = Carbon::today();

        for ($i = 0; $i < 16; $i++) {
            $mobil = $mobils[$i % $mobils->count()];
            $offset = mt_rand(0, 29);
            $selesai = $today->copy()->subDays($offset);
            $hari = mt_rand(1, 4);
            $mulai = $selesai->copy()->subDays($hari);

            $subtotal = $hari * (float) $mobil->harga_perhari;
            $total = $subtotal + (float) $mobil->deposit;

            $cabangId = $mobil->cabang_id ?? $cabangs->first()?->id;

            $rental = Rental::create([
                'user_id' => $customer->id,
                'mobil_id' => $mobil->id,
                'cabang_ambil_id' => $cabangId,
                'cabang_kembali_id' => $cabangId,
                'tanggal_mulai' => $mulai->toDateString(),
                'tanggal_selesai' => $selesai->toDateString(),
                'jumlah_hari' => $hari,
                'harga_perhari' => $mobil->harga_perhari,
                'subtotal' => $subtotal,
                'deposit' => $mobil->deposit,
                'total_harga' => $total,
                'status' => 'Selesai',
                'catatan' => 'Data demo seeder.',
            ]);

            Pembayaran::create([
                'rental_id' => $rental->id,
                'metode_pembayaran_id' => $metodes->random()->id,
                'tanggal_bayar' => $selesai->toDateString(),
                'jumlah' => $total,
                'bukti' => null,
                'status' => 'Disetujui',
            ]);
        }

        // Rental Selesai = mobil kembali Tersedia.
        Mobil::query()->update(['status' => 'Tersedia']);

        // Antrean demo: 2 pengajuan Menunggu + 1 Disetujui dengan
        // pembayaran Menunggu, supaya badge sidebar hidup.
        $tersedia = Mobil::where('status', 'Tersedia')->orderBy('id')->take(3)->get();

        foreach ([0, 1] as $i) {
            $mobil = $tersedia[$i];
            $hari = 2;
            $mulai = Carbon::today()->addDay()->toDateString();
            $selesai = Carbon::today()->addDays(3)->toDateString();
            $subtotal = $hari * (float) $mobil->harga_perhari;
            $total = $subtotal + (float) $mobil->deposit;

            Rental::create([
                'user_id' => $customer->id,
                'mobil_id' => $mobil->id,
                'cabang_ambil_id' => $mobil->cabang_id,
                'cabang_kembali_id' => $mobil->cabang_id,
                'tanggal_mulai' => $mulai,
                'tanggal_selesai' => $selesai,
                'jumlah_hari' => $hari,
                'harga_perhari' => $mobil->harga_perhari,
                'subtotal' => $subtotal,
                'deposit' => $mobil->deposit,
                'total_harga' => $total,
                'status' => 'Menunggu',
                'catatan' => 'Data demo seeder.',
            ]);
        }

        $mobil = $tersedia[2];
        $hari = 3;
        $mulai = Carbon::today()->toDateString();
        $selesai = Carbon::today()->addDays(3)->toDateString();
        $subtotal = $hari * (float) $mobil->harga_perhari;
        $total = $subtotal + (float) $mobil->deposit;

        $rental = Rental::create([
            'user_id' => $customer->id,
            'mobil_id' => $mobil->id,
            'cabang_ambil_id' => $mobil->cabang_id,
            'cabang_kembali_id' => $mobil->cabang_id,
            'tanggal_mulai' => $mulai,
            'tanggal_selesai' => $selesai,
            'jumlah_hari' => $hari,
            'harga_perhari' => $mobil->harga_perhari,
            'subtotal' => $subtotal,
            'deposit' => $mobil->deposit,
            'total_harga' => $total,
            'status' => 'Disetujui',
            'catatan' => 'Data demo seeder.',
        ]);

        $mobil->update(['status' => 'Disewa']);

        Pembayaran::create([
            'rental_id' => $rental->id,
            'metode_pembayaran_id' => MetodePembayaran::orderBy('id')->first()->id,
            'tanggal_bayar' => Carbon::today()->toDateString(),
            'jumlah' => $total,
            'bukti' => null,
            'status' => 'Menunggu',
        ]);

        // Satu denda belum bayar + satu kompensasi diajukan (badge hidup).
        $contohSelesai = Rental::where('status', 'Selesai')->first();

        if ($contohSelesai) {
            Denda::create([
                'rental_id' => $contohSelesai->id,
                'jenis' => 'keterlambatan',
                'nominal' => 150000,
                'status' => 'belum bayar',
            ]);

            Kompensasi::create([
                'mobil_id' => $contohSelesai->mobil_id,
                'rental_id' => $contohSelesai->id,
                'customer_id' => $contohSelesai->user_id,
                'jenis' => 'pengembalian_dana',
                'nominal' => 200000,
                'alasan' => 'Demo seeder.',
                'tanggal' => Carbon::today()->toDateString(),
                'status' => 'diajukan',
            ]);
        }

        $this->command->info('16 transaksi demo dibuat.');
    }
}
