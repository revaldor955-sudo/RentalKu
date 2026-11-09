<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatLokasiMobil extends Model
{
    protected $table = 'riwayat_lokasi_mobils';

    protected $fillable = [
        'rental_id',
        'mobil_id',
        'latitude',
        'longitude',
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }

    public function mobil(): BelongsTo
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }
}