<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kompensasi extends Model
{

    protected $fillable = [
        'mobil_id',
        'rental_id',
        'customer_id',
        'staff_id',
        'jenis',
        'nominal',
        'alasan',
        'tanggal',
        'status',
        'catatan',
        'dibaca_at',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
        'dibaca_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        // Cascade rental/mobil/user menghapus rows buktis di DB, tapi file fisik
        // tetap tertinggal; bersihkan di sini agar tak jadi orphan.
        static::deleting(function (Kompensasi $kompensasi): void {
            foreach ($kompensasi->buktis as $bukti) {
                if ($bukti->path && Storage::disk('public')->exists($bukti->path)) {
                    Storage::disk('public')->delete($bukti->path);
                }
            }
        });
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function buktis()
    {
        return $this->hasMany(KompensasiBukti::class, 'kompensasi_id');
    }
}
