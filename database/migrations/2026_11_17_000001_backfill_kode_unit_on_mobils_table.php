<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('mobils', 'kode_unit')) {
            return;
        }

        $used = [];

        foreach (DB::table('mobils')->whereNotNull('kode_unit')->where('kode_unit', '!=', '')->pluck('kode_unit') as $kode) {
            $used[$kode] = true;
        }

        $nomor = 1;

        // Query builder dipakai supaya backfill tidak memicu event creating/updating model.
        $ids = DB::table('mobils')
            ->where(fn ($q) => $q->whereNull('kode_unit')->orWhere('kode_unit', ''))
            ->orderBy('id')
            ->pluck('id');

        foreach ($ids as $id) {
            while (isset($used['UNIT' . str_pad($nomor, 3, '0', STR_PAD_LEFT)])) {
                $nomor++;
            }

            $kode = 'UNIT' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

            DB::table('mobils')->where('id', $id)->update(['kode_unit' => $kode]);

            $used[$kode] = true;
            $nomor++;
        }
    }

    public function down(): void
    {
        // Backfill data: kode unit yang sudah terisi dibiarkan.
    }
};
