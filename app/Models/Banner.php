<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

    protected $fillable = [
        'judul',
        'gambar',
        'description',
        'link',
        'status',
        'urutan',
    ];
}