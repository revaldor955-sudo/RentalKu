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
        Schema::create('kupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('jenis', ['persen', 'nominal']);
            $table->decimal('value', 12, 2);
            $table->integer('kuota')->nullable();
            $table->integer('terpakai')->default(0);
            $table->decimal('minimal_pembelian', 12, 2)->nullable();
            $table->date('active_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kupons');
    }
};
