<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Denda;
use App\Models\Mobil;
use App\Models\Rental;
use App\Models\TipeMobil;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DendaOtomatisTest extends TestCase
{
    use RefreshDatabase;

    private User $staff;

    private User $customer;

    private Cabang $cabang;

    private Mobil $mobil;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $this->staff = User::where('email', 'staff@rentalku.test')->firstOrFail();
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
            'status' => 'Disewa',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    private function buatRental(string $status, string $tanggalSelesai): Rental
    {
        return Rental::create([
            'user_id' => $this->customer->id,
            'mobil_id' => $this->mobil->id,
            'cabang_ambil_id' => $this->cabang->id,
            'cabang_kembali_id' => $this->cabang->id,
            'tanggal_mulai' => Carbon::parse($tanggalSelesai)->subDays(2)->toDateString(),
            'tanggal_selesai' => $tanggalSelesai,
            'jumlah_hari' => 2,
            'harga_perhari' => 300000,
            'subtotal' => 600000,
            'deposit' => 500000,
            'total_harga' => 1100000,
            'status' => $status,
        ]);
    }

    public function test_menyelesaikan_rental_terlambat_membuat_denda_otomatis(): void
    {
        Carbon::setTestNow('2026-11-03 10:00:00');
        $rental = $this->buatRental('Disetujui', '2026-11-02');

        $this->actingAs($this->staff)
            ->putJson("/rentals/{$rental->id}/status", ['status' => 'Selesai'])
            ->assertOk()
            ->assertJsonPath('message', 'Rental berhasil diselesaikan. Denda Keterlambatan otomatis tercatat.');

        $denda = Denda::where('rental_id', $rental->id)->first();

        $this->assertNotNull($denda);
        $this->assertSame('Selesai', $rental->fresh()->status);
        $this->assertSame('keterlambatan', $denda->jenis);
        $this->assertSame('belum bayar', $denda->status);
        $this->assertSame(200000.0, (float) $denda->nominal);
        $this->assertStringContainsString('1 hari', $denda->deskripsi);
    }

    public function test_menyelesaikan_rental_tepat_waktu_tidak_membuat_denda(): void
    {
        Carbon::setTestNow('2026-11-03 10:00:00');
        $rental = $this->buatRental('Disetujui', '2026-11-03');

        $this->actingAs($this->staff)
            ->putJson("/rentals/{$rental->id}/status", ['status' => 'Selesai'])
            ->assertOk()
            ->assertJsonPath('message', 'Rental berhasil diselesaikan.');

        $this->assertSame(0, Denda::where('rental_id', $rental->id)->count());
    }

    public function test_menyelesaikan_rental_tiga_hari_terlambat_menagih_tiga_hari(): void
    {
        Carbon::setTestNow('2026-11-05 10:00:00');
        $rental = $this->buatRental('Disetujui', '2026-11-02');

        $this->actingAs($this->staff)
            ->putJson("/rentals/{$rental->id}/status", ['status' => 'Selesai'])
            ->assertOk();

        $denda = Denda::where('rental_id', $rental->id)->first();

        $this->assertNotNull($denda);
        $this->assertSame(600000.0, (float) $denda->nominal);
        $this->assertStringContainsString('3 hari', $denda->deskripsi);
    }

    public function test_denda_yang_sedang_diverifikasi_tidak_ditimpa(): void
    {
        Carbon::setTestNow('2026-11-05 10:00:00');
        $rental = $this->buatRental('Disetujui', '2026-11-02');

        $denda = Denda::create([
            'rental_id' => $rental->id,
            'jenis' => 'keterlambatan',
            'nominal' => 200000,
            'status' => 'menunggu verifikasi',
        ]);

        $this->actingAs($this->staff)
            ->putJson("/rentals/{$rental->id}/status", ['status' => 'Selesai'])
            ->assertOk()
            ->assertJsonPath('message', 'Rental berhasil diselesaikan.');

        $denda->refresh();

        $this->assertSame('menunggu verifikasi', $denda->status);
        $this->assertSame(200000.0, (float) $denda->nominal);
    }

    public function test_command_membuat_denda_untuk_rental_belum_dikembalikan(): void
    {
        Carbon::setTestNow('2026-11-03 10:00:00');
        $rental = $this->buatRental('Disetujui', '2026-11-02');

        $this->artisan('dendas:generate-late')->assertExitCode(0);

        $denda = Denda::where('rental_id', $rental->id)->first();

        $this->assertNotNull($denda);
        $this->assertSame(200000.0, (float) $denda->nominal);
    }

    public function test_command_memperbarui_denda_belum_bayar_sesuai_hari_terlambat(): void
    {
        Carbon::setTestNow('2026-11-03 10:00:00');
        $rental = $this->buatRental('Disetujui', '2026-11-02');

        $this->artisan('dendas:generate-late')->assertExitCode(0);
        $this->assertSame(200000.0, (float) Denda::where('rental_id', $rental->id)->firstOrFail()->nominal);

        Carbon::setTestNow('2026-11-05 10:00:00');
        $this->artisan('dendas:generate-late')->assertExitCode(0);

        $this->assertSame(600000.0, (float) Denda::where('rental_id', $rental->id)->firstOrFail()->nominal);
    }
}
