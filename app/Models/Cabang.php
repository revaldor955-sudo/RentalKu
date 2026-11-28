<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{

    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'cabang_id');
    }

}
