<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanMobil extends Model
{
    protected $table = 'pemeriksaan_mobils';

    protected $fillable = [
        'rental_id',
        'mobil_id',
        'jenis',
        'kondisi',
        'catatan',
        'foto_bukti',
        'tanggal',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    public function kerusakan()
    {
        return $this->belongsToMany(
            KerusakanMobil::class,
            'pemeriksaan_kerusakans',
            'pemeriksaan_id',
            'kerusakan_id'
        )->withPivot('keterangan');
    }
}
