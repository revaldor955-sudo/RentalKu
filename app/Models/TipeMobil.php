<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeMobil extends Model
{
    protected $fillable = ['name', 'description'];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'tipe_mobil_id');
    }
}
