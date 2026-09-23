<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoMobil extends Model
{
        protected $fillable = [
        'mobil_id',
        'url',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }
}