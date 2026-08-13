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
        Schema::create('pemeriksaan_mobils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('mobil_id')->constrained('mobils')->onDelete('cascade');
            $table->enum('jenis', ['sebelum_sewa', 'setelah_sewa']);
            $table->enum('kondisi', ['baik', 'rusak'])->default('baik');
            $table->text('catatan')->nullable();
            $table->string('foto_bukti')->nullable();
            $table->dateTime('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_mobils');
    }
};