<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';

    protected $fillable = [
        'name',
    ];

    public function mobil()
    {
        return $this->belongsToMany(
            Mobil::class,
            'mobil_fasilitas',
            'fasilitas_id',
            'mobil_id'
        );
    }
}