<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kupon extends Model
{
    protected $table = 'kupons';

    protected $fillable = [
        'code',
        'jenis',
        'value',
        'kuota',
        'terpakai',
        'minimal_pembelian',
        'active_at',
        'expired_at',
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class, 'kupon_id');
    }
}
