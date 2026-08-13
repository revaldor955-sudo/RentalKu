<?php

namespace App\Models;

use App\Models\Mobil;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabangs';
    protected $fillable = [
        'name',
        'address',
    ];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'cabang_id');
    }

    public function bookingAmbil()
    {
        return $this->hasMany(Booking::class, 'cabang_ambil_id');
    }

    public function bookingKembali()
    {
        return $this->hasMany(Booking::class, 'cabang_kembali_id');
    }
}
