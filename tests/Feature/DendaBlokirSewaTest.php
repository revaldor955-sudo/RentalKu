<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Denda;
use App\Models\Kompensasi;
use App\Models\Mobil;
use App\Models\Rental;
use App\Models\Role;
use App\Models\TipeMobil;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DendaBlokirSewaTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    private User $customerB;

    private Cabang $cabang;

    private Mobil $mobil;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $this->customer = User::where('email', 'customer@rentalku.test')->firstOrFail();
        $this->customerB = User::create([
            'name' => 'Customer B',
            'email' => 'b@rentalku.test',
            'password' => 'password123',
            'roles_id' => Role::where('name', 'Customer')->value('id'),
        ]);

        $this->cabang = Cabang::create(['name' => 'A', 'address' => 'Jl A', 'phone' => '081']);

        $brand = Brand::create(['name' => 'Toyota']);
        $tipe = TipeMobil::create(['name' => 'MPV']);

        $this->mobil = Mobil::create([
            'brand_id' => $brand->id,
            'tipe_mobil_id' => $tipe->id,
            'cabang_id' => $this->cabang->id,
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
    }

    private function buatRental(User $user, string $status = 'Selesai'): Rental
    {
        return Rental::create([
            'user_id' => $user->id,
            'mobil_id' => $this->mobil->id,
            'tanggal_mulai' => now()->subDays(3)->toDateString(),
            'tanggal_selesai' => now()->subDay()->toDateString(),
            'jumlah_hari' => 2,
            'harga_perhari' => 300000,
            'subtotal' => 600000,
            'deposit' => 500000,
            'total_harga' => 1100000,
            'status' => $status,
        ]);
    }

    private function buatDenda(Rental $rental, ?string $status = 'belum bayar'): Denda
    {
        return Denda::create([
            'rental_id' => $rental->id,
            'jenis' => 'keterlambatan',
            'nominal' => 200000,
            'deskripsi' => 'Denda tes.',
            'status' => $status,
        ]);
    }

    private function payloadSewa(): array
    {
        return [
            'tanggal_mulai' => now()->addDay()->toDateString(),
            'tanggal_selesai' => now()->addDays(3)->toDateString(),
        ];
    }

    private function ajukanSewa()
    {
        return $this->actingAs($this->customer)
            ->postJson("/customer/rental/{$this->mobil->slug}", $this->payloadSewa());
    }

    public function test_denda_belum_bayar_memblokir_sewa_baru(): void
    {
        $this->buatDenda($this->buatRental($this->customer), 'belum bayar');

        $this->ajukanSewa()
            ->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Anda masih memiliki denda yang belum dibayar. Selesaikan pembayaran denda terlebih dahulu sebelum menyewa mobil lagi.');

        $this->assertDatabaseCount('rentals', 1);
    }

    public function test_denda_menunggu_verifikasi_memblokir_sewa_baru(): void
    {
        $this->buatDenda($this->buatRental($this->customer), 'menunggu verifikasi');

        $this->ajukanSewa()
            ->assertStatus(422)
            ->assertJsonPath('message', 'Pembayaran denda Anda sedang menunggu verifikasi tim kami. Anda bisa menyewa mobil lagi setelah denda dinyatakan lunas.');

        $this->assertDatabaseCount('rentals', 1);
    }

    public function test_denda_lunas_tidak_memblokir_sewa_baru(): void
    {
        $this->buatDenda($this->buatRental($this->customer), 'lunas');

        $this->ajukanSewa()
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseCount('rentals', 2);
        $this->assertDatabaseHas('rentals', [
            'user_id' => $this->customer->id,
            'status' => 'Menunggu',
        ]);
    }

    public function test_denda_customer_lain_tidak_memblokir_sewa_baru(): void
    {
        $this->buatDenda($this->buatRental($this->customerB), 'belum bayar');

        $this->ajukanSewa()
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseCount('rentals', 2);
    }

    public function test_status_denda_uppercase_tetap_diblokir_dengan_pesan_belum_dibayar(): void
    {
        $this->buatDenda($this->buatRental($this->customer), 'BELUM BAYAR');

        $this->ajukanSewa()
            ->assertStatus(422)
            ->assertJsonPath('message', 'Anda masih memiliki denda yang belum dibayar. Selesaikan pembayaran denda terlebih dahulu sebelum menyewa mobil lagi.');

        $this->assertDatabaseCount('rentals', 1);
    }

    public function test_checkout_dan_confirm_tetap_diblokir_saat_denda_belum_lunas(): void
    {
        $this->buatDenda($this->buatRental($this->customer), 'belum bayar');

        $pesan = 'Anda masih memiliki denda yang belum dibayar. Selesaikan pembayaran denda terlebih dahulu sebelum menyewa mobil lagi.';

        $this->actingAs($this->customer)
            ->postJson("/customer/checkout/{$this->mobil->slug}", [])
            ->assertStatus(422)
            ->assertJsonPath('message', $pesan);

        $this->actingAs($this->customer)
            ->postJson("/customer/checkout/confirm/{$this->mobil->slug}", [])
            ->assertStatus(422)
            ->assertJsonPath('message', $pesan);
    }

    public function test_dashboard_menampilkan_banner_denda_dan_kompensasi(): void
    {
        $rental = $this->buatRental($this->customer);
        $this->buatDenda($rental);

        Kompensasi::create([
            'mobil_id' => $this->mobil->id,
            'rental_id' => $rental->id,
            'customer_id' => $this->customer->id,
            'jenis' => 'pengembalian_dana',
            'nominal' => 100000,
            'alasan' => 'Tes.',
            'tanggal' => now()->toDateString(),
        ]);

        $this->actingAs($this->customer)
            ->get('/customer/dashboard')
            ->assertOk()
            ->assertSee('Denda Belum Lunas')
            ->assertSee('200.000')
            ->assertSee('Kabar kompensasi')
            ->assertSee('Pengembalian Dana');
    }

    public function test_status_denda_uppercase_dengan_spasi_ditampilkan_bisa_dibayar_di_banner(): void
    {
        $rental = $this->buatRental($this->customer);
        $denda = $this->buatDenda($rental, ' BELUM BAYAR ');

        $this->actingAs($this->customer)
            ->get('/customer/dashboard')
            ->assertOk()
            ->assertSee('Bayar denda')
            ->assertSee('customer/riwayat?denda=' . $denda->id, false);

        $this->actingAs($this->customer)
            ->get('/customer/riwayat?denda=' . $denda->id)
            ->assertOk()
            ->assertSee('id="dendaBayarModal' . $denda->id . '"', false);
    }

    public function test_notif_denda_aktif_membuka_form_denda_di_dashboard(): void
    {
        $rental = $this->buatRental($this->customer, 'Berjalan');
        $denda = $this->buatDenda($rental);

        $this->actingAs($this->customer)
            ->get('/customer/dashboard')
            ->assertOk()
            ->assertSee('data-bayar-denda="' . $denda->id . '"', false)
            ->assertSee('data-rental="' . $rental->id . '"', false)
            ->assertSee('id="rental-' . $rental->id . '"', false)
            ->assertSee('id="dendaBayarModal' . $denda->id . '"', false)
            ->assertDontSee('customer/riwayat?denda=' . $denda->id, false);
    }

    public function test_notif_denda_selesai_tetap_ke_riwayat(): void
    {
        $rental = $this->buatRental($this->customer);
        $denda = $this->buatDenda($rental);

        $this->actingAs($this->customer)
            ->get('/customer/dashboard')
            ->assertOk()
            ->assertSee('customer/riwayat?denda=' . $denda->id, false)
            ->assertDontSee('data-bayar-denda="' . $denda->id . '"', false);
    }

    public function test_buka_halaman_kompensasi_menandai_semua_dibaca(): void
    {
        $rental = $this->buatRental($this->customer);

        $kompensasi = Kompensasi::create([
            'mobil_id' => $this->mobil->id,
            'rental_id' => $rental->id,
            'customer_id' => $this->customer->id,
            'jenis' => 'diskon',
            'nominal' => 50000,
            'alasan' => 'Tes.',
            'tanggal' => now()->toDateString(),
        ]);

        $this->assertNull($kompensasi->dibaca_at);

        $this->actingAs($this->customer)
            ->get('/customer/kompensasi')
            ->assertOk();

        $this->assertNotNull($kompensasi->fresh()->dibaca_at);

        $this->actingAs($this->customer)
            ->get('/customer/dashboard')
            ->assertOk()
            ->assertDontSee('Kabar kompensasi');
    }
}
