<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompensasi extends Model
{
    protected $table = 'kompensasis';

    protected $fillable = [
        'mobil_id',
        'rental_id',
        'customer_id',
        'staff_id',
        'jenis',
        'nominal',
        'alasan',
        'tanggal',
        'status',
        'catatan',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
