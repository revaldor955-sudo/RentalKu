<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'tanggal_dikembalikan')) {
                $table->dateTime('tanggal_dikembalikan')->nullable()->after('status');
            }

            if (!Schema::hasColumn('rentals', 'dikembalikan_oleh')) {
                $table->foreignId('dikembalikan_oleh')
                    ->nullable()
                    ->after('tanggal_dikembalikan')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'dikembalikan_oleh')) {
                $table->dropConstrainedForeignId('dikembalikan_oleh');
            }

            if (Schema::hasColumn('rentals', 'tanggal_dikembalikan')) {
                $table->dropColumn('tanggal_dikembalikan');
            }
        });
    }
};
