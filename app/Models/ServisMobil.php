<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServisMobil extends Model
{
    protected $table = 'servis_mobils';
    protected $fillable = [
        'mobil_id',
        'tanggal',
        'jenis',
        'biaya',
        'keterangan',
        'bengkel',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'biaya' => 'decimal:2',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }
}