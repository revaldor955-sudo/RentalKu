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
        Schema::create('servis_mobils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobil_id')->constrained('mobils')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('jenis', ['rutin', 'perbaikan']);
            $table->decimal('biaya', 12, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->string('bengkel', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servis_mobils');
    }
};