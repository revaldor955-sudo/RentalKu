<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->enum('status', [
                'Menunggu',
                'Disetujui',
                'Ditolak',
            ])->default('Menunggu')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->enum('status', [
                'Menunggu',
                'Diverifikasi',
                'Ditolak',
            ])->default('Menunggu')->change();
        });
    }
};