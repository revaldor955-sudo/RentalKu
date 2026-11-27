<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KompensasiBukti extends Model
{
    protected $table = 'kompensasi_buktis';

    protected $fillable = [
        'kompensasi_id',
        'path',
        'original_name',
    ];

    protected static function booted(): void
    {
        static::deleting(function (KompensasiBukti $bukti): void {
            if ($bukti->path && Storage::disk('public')->exists($bukti->path)) {
                Storage::disk('public')->delete($bukti->path);
            }
        });
    }

    public function kompensasi()
    {
        return $this->belongsTo(Kompensasi::class, 'kompensasi_id');
    }
}
