<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dendas', function (Blueprint $table) {
            if (!Schema::hasColumn('dendas', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }

            if (!Schema::hasColumn('dendas', 'bukti_bayar')) {
                $table->string('bukti_bayar')->nullable();
            }

            if (!Schema::hasColumn('dendas', 'tanggal_bayar')) {
                $table->date('tanggal_bayar')->nullable();
            }
        });

        // Mendukung status menunggu verifikasi yang digunakan controller.
        Schema::table('dendas', function (Blueprint $table) {
            $table->string('status')->default('belum bayar')->change();
        });
    }

    public function down(): void
    {
        Schema::table('dendas', function (Blueprint $table) {
            if (Schema::hasColumn('dendas', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
        });
    }
};
