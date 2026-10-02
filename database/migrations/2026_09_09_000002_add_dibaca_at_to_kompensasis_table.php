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
        Schema::table('kompensasis', function (Blueprint $table) {
            if (! Schema::hasColumn('kompensasis', 'dibaca_at')) {
                $table->timestamp('dibaca_at')->nullable()->after('catatan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kompensasis', function (Blueprint $table) {
            if (Schema::hasColumn('kompensasis', 'dibaca_at')) {
                $table->dropColumn('dibaca_at');
            }
        });
    }
};
