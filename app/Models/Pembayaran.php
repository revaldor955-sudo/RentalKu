<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $fillable = [
        'booking_id',
        'metode_id',
        'tanggal_bayar',
        'jumlah',
        'bukti',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function metode()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_id');
    }
}