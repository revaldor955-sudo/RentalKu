<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'dendas';

    protected $fillable = [
        'rental_id',
        'jenis',
        'nominal',
        'foto_bukti',
        'syarat_dan_ketentuan',
        'status',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }
}
