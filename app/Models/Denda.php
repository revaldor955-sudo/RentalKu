<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'dendas';
    protected $fillable = [
        'booking_id',
        'jenis',
        'nominal',
        'foto_bukti',
        'syarat_dan_ketentuan',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}