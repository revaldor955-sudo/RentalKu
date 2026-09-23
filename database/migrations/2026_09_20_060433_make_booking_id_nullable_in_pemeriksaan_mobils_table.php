<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom booking_id tidak ada di histori migrasi (fitur booking belum masuk);
        // lewati agar suite sqlite tetap jalan. honey: no-op di sqlite, MODIFY hanya di MySQL.
        if (!Schema::hasColumn('pemeriksaan_mobils', 'booking_id')) {
            return;
        }
        if (DB::getDriverName() === 'sqlite') {
            return;
        }
        DB::statement('ALTER TABLE pemeriksaan_mobils MODIFY booking_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        if (!Schema::hasColumn('pemeriksaan_mobils', 'booking_id')) {
            return;
        }
        if (DB::getDriverName() === 'sqlite') {
            return;
        }
        DB::statement('ALTER TABLE pemeriksaan_mobils MODIFY booking_id BIGINT UNSIGNED NOT NULL');
    }
};