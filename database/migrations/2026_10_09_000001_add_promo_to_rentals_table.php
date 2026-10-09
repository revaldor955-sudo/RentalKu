<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (! Schema::hasColumn('rentals', 'kode_promo')) {
                $table->string('kode_promo', 50)->nullable()->after('deposit');
            }

            if (! Schema::hasColumn('rentals', 'diskon')) {
                $table->decimal('diskon', 15, 2)->default(0)->after('kode_promo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'diskon')) {
                $table->dropColumn('diskon');
            }

            if (Schema::hasColumn('rentals', 'kode_promo')) {
                $table->dropColumn('kode_promo');
            }
        });
    }
};
