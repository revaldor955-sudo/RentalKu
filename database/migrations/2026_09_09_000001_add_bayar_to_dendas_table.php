<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dendas', function (Blueprint $table) {
            if (! Schema::hasColumn('dendas', 'bukti_bayar')) {
                $table->string('bukti_bayar')->nullable()->after('foto_bukti');
            }
            if (! Schema::hasColumn('dendas', 'tanggal_bayar')) {
                $table->date('tanggal_bayar')->nullable()->after('bukti_bayar');
            }
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE dendas MODIFY status ENUM('belum bayar','lunas','menunggu verifikasi') DEFAULT 'belum bayar'");
        }
    }

    public function down(): void
    {
        Schema::table('dendas', function (Blueprint $table) {
            if (Schema::hasColumn('dendas', 'bukti_bayar')) {
                $table->dropColumn('bukti_bayar');
            }
            if (Schema::hasColumn('dendas', 'tanggal_bayar')) {
                $table->dropColumn('tanggal_bayar');
            }
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE dendas MODIFY status ENUM('belum bayar','lunas') DEFAULT 'belum bayar'");
        }
    }
};
