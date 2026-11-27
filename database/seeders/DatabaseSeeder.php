<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(FasilitasSeeder::class);
        $this->call(TipeMobilSeeder::class);
        $this->call(CabangSeeder::class);
        $this->call(MobilSeeder::class);
        $this->call(FotoMobilSeeder::class);
        $this->call(DokumenMobilSeeder::class);
        $this->call(MobilFasilitasSeeder::class);
        $this->call(MetodePembayaranSeeder::class);
        $this->call(KerusakanMobilSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(SupirSeeder::class);
        $this->call(KuponSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(LandingSettingSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(RentalSeeder::class);
        $this->call(PembayaranSeeder::class);
        $this->call(DendaSeeder::class);
        $this->call(KompensasiSeeder::class);
        $this->call(PemeriksaanSeeder::class);
        $this->call(ServisMobilSeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(PelacakanGpsSeeder::class);
    }
}
