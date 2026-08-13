<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSupir extends Model
{
    protected $table = 'booking_supir';
    protected $fillable = [
        'booking_id',
        'supir_id',
        'tarif_perhari',
        'sub_total',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function supir()
    {
        return $this->belongsTo(Supir::class, 'supir_id');
    }
}