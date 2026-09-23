<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KerusakanMobil extends Model
{
    protected $fillable = ['jenis_kerusakan', 'description'];

    public function pemeriksaanKerusakan()
    {
        return $this->hasMany(PemeriksaanKerusakan::class, 'kerusakan_id');
    }
}