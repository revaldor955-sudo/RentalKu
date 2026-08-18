<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    protected $table = 'metode_pembayarans';
    protected $fillable = [
        'name',
        'nomor_akun',
    ];

   public function pembayaran()
{
    return $this->hasMany(
        Pembayaran::class,
        'metode_pembayaran_id'
    );
}
}
