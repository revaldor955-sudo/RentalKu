<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('kode_promo')->nullable()->after('total_harga');

            $table->decimal('diskon', 15, 2)
                ->default(0)
                ->after('kode_promo');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn([
                'kode_promo',
                'diskon',
            ]);
        });
    }
};