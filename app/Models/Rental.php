<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{

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
        'kode_promo',
        'diskon',
        'total_harga',
        'status',
        'catatan',
        'tanggal_dikembalikan',
        'dikembalikan_oleh',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_dikembalikan' => 'datetime',
        'harga_perhari' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'deposit' => 'decimal:2',
        'diskon' => 'decimal:2',
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
        return $this->hasOne(Pembayaran::class, 'rental_id')->orderByDesc('id');
    }

    public function pembayaranLunas(): bool
    {
        return $this->pembayaran()
            ->where('status', 'Disetujui')
            ->exists();
    }

    public function semuaDendaLunas(): bool
    {
        return !$this->dendas()
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhereRaw('LOWER(status) != ?', ['lunas']);
            })
            ->exists();
    }

 
public function dendas()
{
    return $this->hasMany(\App\Models\Denda::class, 'rental_id');
}


    public function kompensasis()
    {
        return $this->hasMany(Kompensasi::class, 'rental_id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'rental_id');
    }

    public function supirs()
    {
        return $this->belongsToMany(Supir::class, 'rental_supir', 'rental_id', 'supir_id')
            ->withPivot('tarif_perhari', 'sub_total')
            ->withTimestamps();
    }
    
}
