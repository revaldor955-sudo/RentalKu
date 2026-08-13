<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanKerusakan extends Model
{
    protected $table = 'pemeriksaan_kerusakans';
    protected $fillable = [
        'pemeriksaan_id',
        'kerusakan_id',
        'keterangan',
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(PemeriksaanMobil::class, 'pemeriksaan_id');
    }

    public function kerusakan()
    {
        return $this->belongsTo(KerusakanMobil::class, 'kerusakan_id');
    }
}