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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            // Relasi ke rental
            $table->foreignId('rental_id')
                ->constrained('rentals')
                ->cascadeOnDelete();

            // Relasi ke metode pembayaran
            $table->foreignId('metode_pembayaran_id')
                ->constrained('metode_pembayarans')
                ->restrictOnDelete();

            $table->date('tanggal_bayar');

            $table->decimal('jumlah', 15, 2);

            $table->string('bukti_pembayaran')->nullable();

            $table->enum('status', [
                'Menunggu',
                'Diverifikasi',
                'Ditolak'
            ])->default('Menunggu');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
