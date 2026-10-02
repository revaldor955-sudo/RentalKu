<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('metode_pembayarans', function (Blueprint $table) {
            if (! Schema::hasColumn('metode_pembayarans', 'cabang_id')) {
                $table->foreignId('cabang_id')
                    ->nullable()
                    ->after('nomor_akun')
                    ->constrained('cabangs')
                    ->nullOnDelete();
            }
            if (! Schema::hasColumn('metode_pembayarans', 'atas_nama')) {
                $table->string('atas_nama')->nullable()->after('cabang_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('metode_pembayarans', function (Blueprint $table) {
            if (Schema::hasColumn('metode_pembayarans', 'cabang_id')) {
                $table->dropConstrainedForeignId('cabang_id');
            }
            if (Schema::hasColumn('metode_pembayarans', 'atas_nama')) {
                $table->dropColumn('atas_nama');
            }
        });
    }
};
