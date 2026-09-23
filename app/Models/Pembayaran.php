<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
        protected $fillable = [
        'rental_id',
        'metode_pembayaran_id',
        'tanggal_bayar',
        'jumlah',
        'bukti',
        'status',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(
            MetodePembayaran::class,
            'metode_pembayaran_id'
        );
    }
}