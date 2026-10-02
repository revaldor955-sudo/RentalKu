<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{

    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'cabang_id');
    }

    public function rentalAmbil()
    {
        return $this->hasMany(Rental::class, 'cabang_ambil_id');
    }

    public function rentalKembali()
    {
        return $this->hasMany(Rental::class, 'cabang_kembali_id');
    }
}
