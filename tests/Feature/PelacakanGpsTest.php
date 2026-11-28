<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\LokasiMobil;
use App\Models\Mobil;
use App\Models\Rental;
use App\Models\RiwayatLokasiMobil;
use App\Models\Role;
use App\Models\TipeMobil;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelacakanGpsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $customer;

    private Cabang $cabang;

    private Mobil $mobil;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $this->admin = User::where('email', 'admin@rentalku.test')->firstOrFail();
        $this->customer = User::where('email', 'customer@rentalku.test')->firstOrFail();

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

    private function buatRental(string $status, ?User $customer = null, ?string $mulai = null, ?string $selesai = null): Rental
    {
        return Rental::create([
            'user_id' => ($customer ?? $this->customer)->id,
            'mobil_id' => $this->mobil->id,
            'tanggal_mulai' => $mulai ?? now()->toDateString(),
            'tanggal_selesai' => $selesai ?? now()->addDays(2)->toDateString(),
            'jumlah_hari' => 2,
            'harga_perhari' => 300000,
            'subtotal' => 600000,
            'deposit' => 500000,
            'total_harga' => 1100000,
            'status' => $status,
        ]);
    }

    private function buatCustomerLain(): User
    {
        $user = User::create([
            'name' => 'Customer B',
            'email' => 'b@rentalku.test',
            'password' => 'password123',
            'roles_id' => Role::where('name', 'Customer')->value('id'),
        ]);

        $user->forceFill(['email_verified_at' => now()])->save();

        return $user;
    }

    public function test_halaman_gps_menampilkan_rental_berjalan_tanpa_koordinat(): void
    {
        $this->buatRental('Berjalan');

        $this->actingAs($this->admin)
            ->get('/pelacakan-gps')
            ->assertOk()
            ->assertSee('D 1 A')
            ->assertSee('Pelacakan GPS');
    }

    public function test_halaman_gps_tidak_menampilkan_rental_disetujui(): void
    {
        $this->buatRental('Disetujui');

        $this->actingAs($this->admin)
            ->get('/pelacakan-gps')
            ->assertOk()
            ->assertDontSee('D 1 A');
    }

    public function test_data_gps_mengembalikan_rental_tanpa_koordinat(): void
    {
        $this->buatRental('Berjalan');

        $response = $this->actingAs($this->admin)->getJson('/pelacakan-gps/data');

        $response->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.latitude', null)
            ->assertJsonPath('0.longitude', null);
    }

    public function test_customer_dapat_mengirim_lokasi_meski_jadwal_sudah_lewat(): void
    {
        $rental = $this->buatRental(
            'Berjalan',
            null,
            now()->subDays(10)->toDateString(),
            now()->subDays(5)->toDateString()
        );

        $this->actingAs($this->customer)
            ->postJson('/customer/gps/' . $rental->id . '/lokasi', [
                'latitude' => -0.0263,
                'longitude' => 109.3425,
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('lokasi_mobils', [
            'rental_id' => $rental->id,
            'latitude' => -0.0263,
        ]);

        $this->assertSame(1, RiwayatLokasiMobil::where('rental_id', $rental->id)->count());
    }

    public function test_customer_lain_tidak_bisa_mengirim_lokasi(): void
    {
        $rental = $this->buatRental('Berjalan');
        $lain = $this->buatCustomerLain();

        $this->actingAs($lain)
            ->postJson('/customer/gps/' . $rental->id . '/lokasi', [
                'latitude' => -0.0263,
                'longitude' => 109.3425,
            ])
            ->assertForbidden();

        $this->assertSame(0, LokasiMobil::where('rental_id', $rental->id)->count());
    }

    public function test_customer_tidak_bisa_mengirim_lokasi_saat_rental_belum_berjalan(): void
    {
        $rental = $this->buatRental('Disetujui');

        $this->actingAs($this->customer)
            ->postJson('/customer/gps/' . $rental->id . '/lokasi', [
                'latitude' => -0.0263,
                'longitude' => 109.3425,
            ])
            ->assertForbidden();
    }

    public function test_halaman_pengirim_terbuka_untuk_rental_berjalan(): void
    {
        $rental = $this->buatRental(
            'Berjalan',
            null,
            now()->subDays(10)->toDateString(),
            now()->subDays(5)->toDateString()
        );

        $this->actingAs($this->customer)
            ->get('/customer/gps/' . $rental->id)
            ->assertOk();
    }

    public function test_halaman_pengirim_ditolak_untuk_customer_lain(): void
    {
        $rental = $this->buatRental('Berjalan');
        $lain = $this->buatCustomerLain();

        $this->actingAs($lain)
            ->get('/customer/gps/' . $rental->id)
            ->assertForbidden();
    }

    public function test_halaman_riwayat_memakai_tabel_datatables_server_side(): void
    {
        $rental = $this->buatRental('Berjalan');

        for ($i = 0; $i < 3; $i++) {
            RiwayatLokasiMobil::create([
                'rental_id' => $rental->id,
                'mobil_id' => $this->mobil->id,
                'latitude' => -0.0263,
                'longitude' => 109.3425,
            ]);
        }

        $this->actingAs($this->admin)
            ->get('/pelacakan-gps/' . $rental->id . '/riwayat')
            ->assertOk()
            ->assertSee('riwayat-table')
            ->assertSee('serverSide: true')
            ->assertViewHas('totalRiwayat', 3);
    }

    public function test_data_riwayat_mengembalikan_protokol_datatables(): void
    {
        $rental = $this->buatRental('Berjalan');

        for ($i = 0; $i < 3; $i++) {
            RiwayatLokasiMobil::create([
                'rental_id' => $rental->id,
                'mobil_id' => $this->mobil->id,
                'latitude' => -0.0263,
                'longitude' => 109.3425,
            ]);
        }

        $response = $this->actingAs($this->admin)->getJson(
            '/pelacakan-gps/' . $rental->id . '/riwayat/data?draw=2&start=0&length=2'
        );

        $response->assertOk()
            ->assertJsonPath('draw', 2)
            ->assertJsonPath('recordsTotal', 3)
            ->assertJsonPath('recordsFiltered', 3)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [['latitude', 'longitude', 'tanggal', 'waktu', 'maps_url']],
            ]);
    }

    public function test_data_riwayat_mendukung_pencarian(): void
    {
        $rental = $this->buatRental('Berjalan');

        RiwayatLokasiMobil::create([
            'rental_id' => $rental->id,
            'mobil_id' => $this->mobil->id,
            'latitude' => -1.1111,
            'longitude' => 109.1111,
        ]);

        RiwayatLokasiMobil::create([
            'rental_id' => $rental->id,
            'mobil_id' => $this->mobil->id,
            'latitude' => -2.2222,
            'longitude' => 109.2222,
        ]);

        $response = $this->actingAs($this->admin)->getJson(
            '/pelacakan-gps/' . $rental->id . '/riwayat/data?draw=1&start=0&length=10&search[value]=-2.2222'
        );

        $response->assertOk()
            ->assertJsonPath('recordsFiltered', 1)
            ->assertJsonCount(1, 'data');
    }

    public function test_customer_tidak_bisa_mengakses_data_riwayat(): void
    {
        $rental = $this->buatRental('Berjalan');

        $this->actingAs($this->customer)
            ->getJson('/pelacakan-gps/' . $rental->id . '/riwayat/data')
            ->assertForbidden();
    }

    public function test_filter_rental_data_menerima_beberapa_status(): void
    {
        $this->buatRental('Disetujui');
        $this->buatRental('Berjalan');
        $this->buatRental('Menunggu');

        $response = $this->actingAs($this->admin)->getJson(
            '/rentals/data?draw=1&start=0&length=10&status=Disetujui,Berjalan'
        );

        $response->assertOk()
            ->assertJsonPath('recordsTotal', 2)
            ->assertJsonCount(2, 'data');
    }

    public function test_halaman_pembayaran_terbuka_untuk_rental_berjalan(): void
    {
        $rental = $this->buatRental('Berjalan');

        $this->actingAs($this->customer)
            ->get('/customer/pembayaran/' . $rental->id)
            ->assertOk();
    }

    public function test_riwayat_data_menampilkan_waktu_wib(): void
    {
        $rental = $this->buatRental('Berjalan');

        $riwayat = RiwayatLokasiMobil::create([
            'rental_id' => $rental->id,
            'mobil_id' => $this->mobil->id,
            'latitude' => -0.0263,
            'longitude' => 109.3425,
        ]);

        $riwayat->forceFill([
            'created_at' => \Carbon\Carbon::parse('2026-11-17 05:57:00', 'UTC'),
        ])->save();

        $this->actingAs($this->admin)
            ->getJson('/pelacakan-gps/' . $rental->id . '/riwayat/data?draw=1&start=0&length=10')
            ->assertOk()
            ->assertJsonPath('data.0.waktu', '12:57:00')
            ->assertJsonPath('data.0.tanggal', '17-11-2026');
    }

    public function test_pencarian_riwayat_memakai_waktu_wib(): void
    {
        $rental = $this->buatRental('Berjalan');

        $riwayat = RiwayatLokasiMobil::create([
            'rental_id' => $rental->id,
            'mobil_id' => $this->mobil->id,
            'latitude' => -0.0263,
            'longitude' => 109.3425,
        ]);

        $riwayat->forceFill([
            'created_at' => \Carbon\Carbon::parse('2026-11-17 05:57:00', 'UTC'),
        ])->save();

        $this->actingAs($this->admin)
            ->getJson('/pelacakan-gps/' . $rental->id . '/riwayat/data?draw=1&start=0&length=10&search[value]=17-11-2026')
            ->assertOk()
            ->assertJsonPath('recordsFiltered', 1)
            ->assertJsonCount(1, 'data');

        $this->actingAs($this->admin)
            ->getJson('/pelacakan-gps/' . $rental->id . '/riwayat/data?draw=1&start=0&length=10&search[value]=12:57')
            ->assertOk()
            ->assertJsonPath('recordsFiltered', 1)
            ->assertJsonCount(1, 'data');

        $this->actingAs($this->admin)
            ->getJson('/pelacakan-gps/' . $rental->id . '/riwayat/data?draw=1&start=0&length=10&search[value]=05:57')
            ->assertOk()
            ->assertJsonPath('recordsFiltered', 0)
            ->assertJsonCount(0, 'data');
    }
}
