<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supir extends Model
{
    protected $table = 'supirs';

    protected $fillable = [
        'name',
        'phone',
        'image',
        'tarif_perhari',
        'status',
    ];

    public function rental()
    {
        return $this->belongsToMany(Rental::class, 'rental_supir', 'supir_id', 'rental_id');
    }
}
