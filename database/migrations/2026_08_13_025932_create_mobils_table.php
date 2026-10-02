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
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('tipe_mobil_id')->constrained('tipe_mobils')->onDelete('cascade');
            $table->foreignId('cabang_id')->constrained('cabangs')->onDelete('cascade');
            $table->string('name');
            $table->string('plate_number')->unique();
            $table->year('tahun');
            $table->enum('transmisi', ['Manual', 'Matic']);
            $table->integer('kapasitas');
            $table->string('warna');
            $table->decimal('harga_perhari', 12, 2);
            $table->decimal('deposit', 12, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['Tersedia', 'Disewa', 'Maintenance'])->default('Tersedia');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
