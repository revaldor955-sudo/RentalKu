<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\MetodePembayaran;
use App\Models\Mobil;
use App\Models\Pembayaran;
use App\Models\Rental;
use App\Models\TipeMobil;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalDetailPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_detail_rental_menyertakan_bukti_pembayaran(): void
    {
        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $admin = User::where('email', 'admin@rentalku.test')->firstOrFail();
        $customer = User::where('email', 'customer@rentalku.test')->firstOrFail();

        $cabang = Cabang::create(['name' => 'A', 'address' => 'Jl A', 'phone' => '081']);
        $brand = Brand::create(['name' => 'Toyota']);
        $tipe = TipeMobil::create(['name' => 'MPV']);

        $mobil = Mobil::create([
            'brand_id' => $brand->id,
            'tipe_mobil_id' => $tipe->id,
            'cabang_id' => $cabang->id,
            'name' => 'Avanza',
            'plate_number' => 'D 1 A',
            'tahun' => 2022,
            'transmisi' => 'Manual',
            'kapasitas' => 7,
            'warna' => 'Hitam',
            'harga_perhari' => 300000,
            'deposit' => 500000,
            'status' => 'Tersedia',
        ]);

        $rental = Rental::create([
            'user_id' => $customer->id,
            'mobil_id' => $mobil->id,
            'cabang_ambil_id' => $cabang->id,
            'cabang_kembali_id' => $cabang->id,
            'tanggal_mulai' => '2026-11-01',
            'tanggal_selesai' => '2026-11-02',
            'jumlah_hari' => 1,
            'harga_perhari' => 300000,
            'subtotal' => 300000,
            'deposit' => 500000,
            'total_harga' => 800000,
            'status' => 'Selesai',
        ]);

        $metode = MetodePembayaran::create([
            'name' => 'BCA',
            'nomor_akun' => '123456789',
        ]);

        $bukti = 'bukti_pembayaran/bukti-transfer.jpg';

        Pembayaran::create([
            'rental_id' => $rental->id,
            'metode_pembayaran_id' => $metode->id,
            'tanggal_bayar' => '2026-11-01',
            'jumlah' => 800000,
            'bukti' => $bukti,
            'status' => 'Menunggu',
        ]);

        $this->actingAs($admin)
            ->getJson("/rentals/{$rental->id}/detail")
            ->assertOk()
            ->assertJsonPath('pembayaran.metode', 'BCA')
            ->assertJsonPath('pembayaran.bukti_url', asset('storage/' . $bukti));
    }
}
