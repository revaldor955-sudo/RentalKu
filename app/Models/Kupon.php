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

    protected $casts = [
        'active_at' => 'datetime',
        'expired_at' => 'datetime',
        'value' => 'decimal:2',
        'minimal_pembelian' => 'decimal:2',
    ];

    public $timestamps = true;
}
