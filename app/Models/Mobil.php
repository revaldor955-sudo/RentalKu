<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $table = 'mobils';

    protected $fillable = [
        'brand_id',
        'tipe_mobil_id',
        'cabang_id',
        'name',
        'plate_number',
        'tahun',
        'transmisi',
        'kapasitas',
        'warna',
        'harga_perhari',
        'deposit',
        'image',
        'status',
        'description',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function tipeMobil()
    {
        return $this->belongsTo(TipeMobil::class, 'tipe_mobil_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'mobil_fasilitas',
            'mobil_id',
            'fasilitas_id'
        );
    }

    public function fotoMobils()
    {
        return $this->hasMany(FotoMobil::class, 'mobil_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'mobil_id');
    }
}
