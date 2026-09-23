<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalSupir extends Model
{
        protected $fillable = [
        'rental_id',
        'supir_id',
        'tarif_perhari',
        'sub_total',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }

    public function supir()
    {
        return $this->belongsTo(Supir::class, 'supir_id');
    }
}
