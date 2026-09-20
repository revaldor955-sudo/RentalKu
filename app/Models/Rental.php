<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;
use App\Models\Supir;

class Rental extends Model
{
    protected $table = 'rentals';

    protected $fillable = [
        'user_id',
        'mobil_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'harga_perhari',
        'subtotal',
        'deposit',
        'total_harga',
        'kode_promo',
        'diskon',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'harga_perhari' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'deposit' => 'decimal:2',
        'total_harga' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function mobil()
    {
        return $this->belongsTo(
            Mobil::class,
            'mobil_id'
        );
    }

    public function pembayaran()
    {
        return $this->hasOne(
            Pembayaran::class,
            'rental_id'
        );
    }
    
public function rating()
{
    return $this->hasOne(
        Rating::class,
        'booking_id',
        'id'
    );
}


public function supirs()
{
    return $this->belongsToMany(
        Supir::class,
        'rental_supir',
        'rental_id',
        'supir_id'
    )->withPivot([
        'tarif_perhari',
        'sub_total',
    ]);
}
}