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
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->enum('jenis', ['keterlambatan', 'kerusakan', 'kehilangan']);
            $table->decimal('nominal', 12, 2);
            $table->string('foto_bukti')->nullable();
            $table->text('syarat_dan_ketentuan')->nullable();
            $table->enum('status', ['belum bayar', 'lunas'])->default('belum bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};