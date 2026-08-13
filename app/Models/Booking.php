<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = [
        'kode_booking',
        'customer_id',
        'staff_id',
        'mobil_id',
        'cabang_ambil_id',
        'cabang_kembali_id',
        'kupon_id',
        'tanggal_ambil',
        'tanggal_kembali',
        'durasi',
        'total_tarif',
        'potongan',
        'catatan',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    public function cabangAmbil()
    {
        return $this->belongsTo(Cabang::class, 'cabang_ambil_id');
    }

    public function cabangKembali()
    {
        return $this->belongsTo(Cabang::class, 'cabang_kembali_id');
    }

    public function kupon()
    {
        return $this->belongsTo(Kupon::class, 'kupon_id');
    }

    public function supir()
    {
        return $this->belongsToMany(
            Supir::class,
            'booking_supir',
            'booking_id',
            'supir_id'
        )->withPivot('tarif_perhari', 'sub_total');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'booking_id');
    }

    public function denda()
    {
        return $this->hasMany(Denda::class, 'booking_id');
    }

    public function kompensasi()
    {
        return $this->hasMany(Kompensasi::class, 'booking_id');
    }

    public function pemeriksaanMobil()
    {
        return $this->hasMany(PemeriksaanMobil::class, 'booking_id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'booking_id');
    }
}