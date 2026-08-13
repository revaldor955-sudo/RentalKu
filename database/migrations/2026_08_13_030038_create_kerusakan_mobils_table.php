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
        Schema::create('kerusakan_mobils', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kerusakan', ['Mesin', 'Ban', 'Body', 'Interior', 'Rem', 'Kelistrikan', 'AC', 'Transmisi', 'Suspensi', 'Kaca', 'Lainnya']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerusakan_mobils');
    }
};
