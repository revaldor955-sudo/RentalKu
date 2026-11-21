<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Mobil;
use App\Models\PemeriksaanMobil;
use App\Models\Rental;
use App\Models\TipeMobil;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PemeriksaanKendaraanTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $customer;

    private Cabang $cabang;

    private Mobil $mobilA;

    private Mobil $mobilB;

    private Rental $rentalDisetujui;

    private Rental $rentalSelesai;

    private Rental $rentalBerjalan;

    private Rental $rentalMenunggu;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $this->admin = User::where('email', 'admin@rentalku.test')->firstOrFail();
        $this->customer = User::where('email', 'customer@rentalku.test')->firstOrFail();

        $this->cabang = Cabang::create([
            'name' => 'Pusat',
            'address' => 'Jl. Pusat',
            'phone' => '081',
        ]);

        $brand = Brand::create(['name' => 'Toyota']);
        $tipe = TipeMobil::create(['name' => 'MPV']);

        $this->mobilA = Mobil::create([
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

        $this->mobilB = Mobil::create([
            'brand_id' => $brand->id,
            'tipe_mobil_id' => $tipe->id,
            'cabang_id' => $this->cabang->id,
            'name' => 'Innova',
            'plate_number' => 'D 2 B',
            'tahun' => 2023,
            'transmisi' => 'Matic',
            'kapasitas' => 7,
            'warna' => 'Putih',
            'harga_perhari' => 450000,
            'deposit' => 700000,
            'status' => 'Tersedia',
        ]);

        $this->rentalDisetujui = $this->buatRental($this->mobilA, 'Disetujui');
        $this->rentalSelesai = $this->buatRental($this->mobilB, 'Selesai');
        $this->rentalBerjalan = $this->buatRental($this->mobilA, 'Berjalan');
        $this->rentalMenunggu = $this->buatRental($this->mobilB, 'Menunggu');
    }

    private function buatRental(Mobil $mobil, string $status): Rental
    {
        return Rental::create([
            'user_id' => $this->customer->id,
            'mobil_id' => $mobil->id,
            'cabang_ambil_id' => $this->cabang->id,
            'cabang_kembali_id' => $this->cabang->id,
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

    private function payload(Rental $rental, int $mobilId): array
    {
        return [
            'rental_id' => $rental->id,
            'mobil_id' => $mobilId,
            'jenis' => 'sebelum_sewa',
            'kondisi' => 'baik',
            'tanggal' => now()->format('Y-m-d H:i:s'),
        ];
    }

    public function test_index_hanya_menampilkan_rental_dan_mobil_yang_layak(): void
    {
        $this->actingAs($this->admin)
            ->get(route('pemeriksaan-kendaraan.index'))
            ->assertOk()
            ->assertViewHas('rentals', function ($rentals) {
                return $rentals->pluck('id')->sort()->values()->all()
                    === [$this->rentalDisetujui->id, $this->rentalSelesai->id];
            })
            ->assertViewHas('mobils', function ($mobils) {
                return $mobils->pluck('id')->sort()->values()->all()
                    === [$this->mobilA->id, $this->mobilB->id];
            });
    }

    public function test_store_menyimpan_rental_id_dan_mobil_dari_rental(): void
    {
        $this->actingAs($this->admin)
            ->postJson(
                route('pemeriksaan-kendaraan.store'),
                $this->payload($this->rentalDisetujui, $this->mobilA->id)
            )
            ->assertOk();

        $this->assertDatabaseHas('pemeriksaan_mobils', [
            'rental_id' => $this->rentalDisetujui->id,
            'mobil_id' => $this->mobilA->id,
        ]);
    }

    public function test_store_menolak_rental_di_luar_status_layak(): void
    {
        $this->actingAs($this->admin)
            ->postJson(
                route('pemeriksaan-kendaraan.store'),
                $this->payload($this->rentalBerjalan, $this->mobilA->id)
            )
            ->assertStatus(422)
            ->assertJsonValidationErrors(['rental_id']);

        $this->assertDatabaseCount('pemeriksaan_mobils', 0);
    }

    public function test_store_menolak_mobil_yang_tidak_sesuai_rental(): void
    {
        $this->actingAs($this->admin)
            ->postJson(
                route('pemeriksaan-kendaraan.store'),
                $this->payload($this->rentalDisetujui, $this->mobilB->id)
            )
            ->assertStatus(422)
            ->assertJsonValidationErrors(['mobil_id']);

        $this->assertDatabaseCount('pemeriksaan_mobils', 0);
    }

    public function test_update_memindahkan_rental_dan_mobil_ikut_rental_baru(): void
    {
        $pemeriksaan = PemeriksaanMobil::create([
            'rental_id' => $this->rentalDisetujui->id,
            'mobil_id' => $this->mobilA->id,
            'jenis' => 'sebelum_sewa',
            'kondisi' => 'baik',
            'tanggal' => now()->format('Y-m-d H:i:s'),
        ]);

        $this->actingAs($this->admin)
            ->putJson(
                route('pemeriksaan-kendaraan.update', $pemeriksaan),
                $this->payload($this->rentalSelesai, $this->mobilB->id)
            )
            ->assertOk();

        $this->assertDatabaseHas('pemeriksaan_mobils', [
            'id' => $pemeriksaan->id,
            'rental_id' => $this->rentalSelesai->id,
            'mobil_id' => $this->mobilB->id,
        ]);
    }

    public function test_data_mengembalikan_kolom_rental_dan_kode_mobil(): void
    {
        PemeriksaanMobil::create([
            'rental_id' => $this->rentalDisetujui->id,
            'mobil_id' => $this->mobilA->id,
            'jenis' => 'sebelum_sewa',
            'kondisi' => 'baik',
            'tanggal' => now()->format('Y-m-d H:i:s'),
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson(route('pemeriksaan-kendaraan.data', [
                'draw' => 1,
                'start' => 0,
                'length' => 10,
            ]))
            ->assertOk()
            ->assertJsonPath('draw', 1)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        'rental_id',
                        'rental_user_name',
                        'rental_status',
                        'mobil_kode',
                    ],
                ],
            ]);

        $row = $response->json('data.0');

        $this->assertSame($this->rentalDisetujui->id, $row['rental_id']);
        $this->assertSame($this->customer->name, $row['rental_user_name']);
        $this->assertSame('Disetujui', $row['rental_status']);
        $this->assertSame($this->mobilA->kode_unit, $row['mobil_kode']);
    }
}
