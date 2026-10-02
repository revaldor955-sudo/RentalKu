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
        Schema::create('dokumen_mobils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobil_id')->constrained('mobils')->onDelete('cascade');
            $table->enum('jenis', ['stnk', 'asuransi', 'bpkb']);
            $table->string('nomor_dokumen');
            $table->date('berlaku_sampai');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_mobils');
    }
};