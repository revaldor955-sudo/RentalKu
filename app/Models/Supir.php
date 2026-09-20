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

    protected $casts = [
        'tarif_perhari' => 'decimal:2',
    ];

    public function rentals()
    {
        return $this->belongsToMany(
            Rental::class,
            'rental_supir',
            'supir_id',
            'rental_id'
        )->withPivot([
            'tarif_perhari',
            'sub_total',
        ])->withTimestamps();
    }
}