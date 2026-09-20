<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pemeriksaan_mobils', 'rental_id')) {
            Schema::table('pemeriksaan_mobils', function (Blueprint $table) {
                $table->foreignId('rental_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('rentals')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pemeriksaan_mobils', 'rental_id')) {
            Schema::table('pemeriksaan_mobils', function (Blueprint $table) {
                $table->dropForeign(['rental_id']);
                $table->dropColumn('rental_id');
            });
        }
    }
};