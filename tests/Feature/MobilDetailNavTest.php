<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Mobil;
use App\Models\TipeMobil;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobilDetailNavTest extends TestCase
{
    use RefreshDatabase;

    private function buatMobil(): Mobil
    {
        $cabang = Cabang::create(['name' => 'A', 'address' => 'Jl A', 'phone' => '081']);
        $brand = Brand::create(['name' => 'Toyota']);
        $tipe = TipeMobil::create(['name' => 'MPV']);

        return Mobil::create([
            'brand_id' => $brand->id, 'tipe_mobil_id' => $tipe->id, 'cabang_id' => $cabang->id,
            'name' => 'Avanza', 'plate_number' => 'D 9 Z', 'tahun' => 2022, 'transmisi' => 'Manual',
            'kapasitas' => 7, 'warna' => 'Hitam', 'harga_perhari' => 300000, 'deposit' => 500000,
            'status' => 'Tersedia',
        ]);
    }

    public function test_navbar_sesuai_role(): void
    {
        $this->seed([RoleSeeder::class, UserSeeder::class]);
        $mobil = $this->buatMobil();
        $url = '/mobils/' . $mobil->slug;

        // Tamu: navbar landing.
        $this->get($url)->assertOk()->assertSee('id="mainNavbar"', false);

        // Customer: navbar customer + modal profil tersedia.
        $customer = User::where('email', 'customer@rentalku.test')->firstOrFail();
        $this->actingAs($customer)->get($url)->assertOk()
            ->assertSee('id="customerNavbar"', false)
            ->assertSee('id="profileModal"', false)
            ->assertDontSee('id="mainNavbar"', false);

        // Staff: tetap navbar landing.
        $staff = User::where('email', 'staff@rentalku.test')->firstOrFail();
        $this->actingAs($staff)->get($url)->assertOk()
            ->assertSee('id="mainNavbar"', false)
            ->assertDontSee('id="customerNavbar"', false);
    }
}
