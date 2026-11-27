<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('plate_number');
        });

        DB::table('mobils')->orderBy('id')->chunkById(200, function ($mobils) {
            foreach ($mobils as $mobil) {
                $base = Str::slug($mobil->name . '-' . $mobil->plate_number);
                $candidate = $base;
                $i = 2;
                while (DB::table('mobils')->where('slug', $candidate)->exists()) {
                    $candidate = $base . '-' . $i;
                    $i++;
                }
                DB::table('mobils')->where('id', $mobil->id)->update(['slug' => $candidate]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
