<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HubungiKami extends Model
{
    protected $fillable = ['nama', 'phone', 'email', 'pesan'];
}