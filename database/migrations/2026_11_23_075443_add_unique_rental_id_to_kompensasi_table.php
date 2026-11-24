<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Satu rental hanya boleh punya satu kompensasi.
     * Cek duplikat dulu sebelum migrate:
     * SELECT rental_id, COUNT(*) FROM kompensasis GROUP BY rental_id HAVING COUNT(*) > 1;
     */
    public function up(): void
    {
        Schema::table('kompensasis', function (Blueprint $table) {
            $table->unique('rental_id');
        });
    }

    public function down(): void
    {
        Schema::table('kompensasis', function (Blueprint $table) {
            $table->dropUnique(['rental_id']);
        });
    }
};
