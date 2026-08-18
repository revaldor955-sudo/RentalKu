<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jika rental_id belum ada, tambahkan
        if (!Schema::hasColumn('pembayarans', 'rental_id')) {

            Schema::table('pembayarans', function (Blueprint $table) {

                $table->foreignId('rental_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('rentals')
                    ->cascadeOnDelete();

            });
        }

        // Jika booking_id masih ada, hapus kolomnya
        if (Schema::hasColumn('pembayarans', 'booking_id')) {

            Schema::table('pembayarans', function (Blueprint $table) {

                $table->dropColumn('booking_id');

            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pembayarans', 'rental_id')) {

            Schema::table('pembayarans', function (Blueprint $table) {

                $table->dropForeign(['rental_id']);
                $table->dropColumn('rental_id');

            });
        }

        if (!Schema::hasColumn('pembayarans', 'booking_id')) {

            Schema::table('pembayarans', function (Blueprint $table) {

                $table->foreignId('booking_id')
                    ->nullable()
                    ->constrained('bookings')
                    ->cascadeOnDelete();

            });
        }
    }
};
