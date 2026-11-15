<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->string('kode_unit')->nullable()->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->dropUnique(['kode_unit']);
            $table->dropColumn('kode_unit');
        });
    }
};