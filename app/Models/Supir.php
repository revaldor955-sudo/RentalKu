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

    public function booking()
    {
        return $this->belongsToMany(Booking::class, 'booking_supir', 'supir_id', 'booking_id');
    }
}
