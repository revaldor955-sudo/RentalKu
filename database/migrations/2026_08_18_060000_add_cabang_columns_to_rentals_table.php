<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->foreignId('cabang_ambil_id')
                ->nullable()
                ->after('mobil_id')
                ->constrained('cabangs')
                ->onDelete('set null');

            $table->foreignId('cabang_kembali_id')
                ->nullable()
                ->after('cabang_ambil_id')
                ->constrained('cabangs')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cabang_ambil_id');
            $table->dropConstrainedForeignId('cabang_kembali_id');
        });
    }
};
