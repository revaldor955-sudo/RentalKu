<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LokasiMobil extends Model
{
    protected $table = 'lokasi_mobils';

    protected $fillable = [
        'mobil_id',
        'rental_id',
        'latitude',
        'longitude',
    ];

    public function mobil(): BelongsTo
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }
}