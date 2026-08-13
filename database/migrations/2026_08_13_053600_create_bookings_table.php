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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking', 20)->unique();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('mobil_id')->constrained('mobils')->onDelete('cascade');
            $table->foreignId('cabang_ambil_id')->constrained('cabangs')->onDelete('cascade');
            $table->foreignId('cabang_kembali_id')->nullable()->constrained('cabangs')->onDelete('set null');
            $table->foreignId('kupon_id')->nullable()->constrained('kupons')->onDelete('set null');
            $table->dateTime('tanggal_ambil');
            $table->dateTime('tanggal_kembali');
            $table->integer('durasi');
            $table->decimal('total_tarif', 12, 2);
            $table->decimal('potongan', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'berlangsung', 'selesai', 'batal'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};