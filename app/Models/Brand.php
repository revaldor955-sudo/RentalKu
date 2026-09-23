<?php

namespace App\Models;

use App\Models\Mobil;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = [
        'name',
        'logo',
        'description'
    ];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'brand_id');
    }
}
