<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\TipeMobil;
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
        'description'
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
}
