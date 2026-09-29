<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supir extends Model
{

    protected $fillable = [
        'name',
        'phone',
        'tarif_perhari',
        'status',
        'image',
        'cabang_id',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function rental()
    {
        return $this->belongsToMany(Rental::class, 'rental_supir', 'supir_id', 'rental_id');
    }
}
