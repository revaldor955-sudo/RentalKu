<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Status denda jadi string biasa (bukan enum) — konsisten dengan
     * rentals.status. Nilai valid dijaga di validasi controller.
     * Tanpa doctrine/dbal: MySQL pakai MODIFY, SQLite rebuild tabel.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE dendas MODIFY status VARCHAR(50) NOT NULL DEFAULT 'belum bayar'");

            return;
        }

        Schema::create('dendas_new', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->onDelete('cascade');
            $table->enum('jenis', ['keterlambatan', 'kerusakan', 'kehilangan']);
            $table->decimal('nominal', 12, 2);
            $table->string('foto_bukti')->nullable();
            $table->text('syarat_dan_ketentuan')->nullable();
            $table->string('status', 50)->default('belum bayar');
            $table->string('bukti_bayar')->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });

        DB::statement('INSERT INTO dendas_new (id, rental_id, jenis, nominal, foto_bukti, syarat_dan_ketentuan, status, bukti_bayar, tanggal_bayar, created_at, updated_at) SELECT id, rental_id, jenis, nominal, foto_bukti, syarat_dan_ketentuan, status, bukti_bayar, tanggal_bayar, created_at, updated_at FROM dendas');

        Schema::drop('dendas');
        Schema::rename('dendas_new', 'dendas');
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE dendas MODIFY status ENUM('belum bayar','lunas','menunggu verifikasi') DEFAULT 'belum bayar'");

            return;
        }

        Schema::create('dendas_old', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->onDelete('cascade');
            $table->enum('jenis', ['keterlambatan', 'kerusakan', 'kehilangan']);
            $table->decimal('nominal', 12, 2);
            $table->string('foto_bukti')->nullable();
            $table->text('syarat_dan_ketentuan')->nullable();
            $table->enum('status', ['belum bayar', 'lunas', 'menunggu verifikasi'])->default('belum bayar');
            $table->string('bukti_bayar')->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });

        DB::statement('INSERT INTO dendas_old (id, rental_id, jenis, nominal, foto_bukti, syarat_dan_ketentuan, status, bukti_bayar, tanggal_bayar, created_at, updated_at) SELECT id, rental_id, jenis, nominal, foto_bukti, syarat_dan_ketentuan, status, bukti_bayar, tanggal_bayar, created_at, updated_at FROM dendas');

        Schema::drop('dendas');
        Schema::rename('dendas_old', 'dendas');
    }
};
