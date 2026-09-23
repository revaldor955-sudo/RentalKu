<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenMobil extends Model
{
        protected $fillable = [
        'mobil_id',
        'jenis',
        'nomor_dokumen',
        'berlaku_sampai',
        'file',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }
}