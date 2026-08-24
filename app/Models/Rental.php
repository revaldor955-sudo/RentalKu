<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';

    protected $fillable = [
        'user_id',
        'mobil_id',
        'cabang_ambil_id',
        'cabang_kembali_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'harga_perhari',
        'subtotal',
        'deposit',
        'total_harga',
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
        return $this->belongsTo(User::class);
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function cabangAmbil()
    {
        return $this->belongsTo(Cabang::class, 'cabang_ambil_id');
    }

    public function cabangKembali()
    {
        return $this->belongsTo(Cabang::class, 'cabang_kembali_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'rental_id');
    }
}
