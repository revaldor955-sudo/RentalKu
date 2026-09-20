<?php

namespace App\Models;

use App\Models\KerusakanMobil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class PemeriksaanMobil extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_mobils';

    protected $fillable = [
        'rental_id',
        'mobil_id',
        'booking_id',
        'jenis',
        'kondisi',
        'catatan',
        'foto_bukti',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }

    public function mobil(): BelongsTo
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    public function kerusakan(): BelongsToMany
    {
        return $this->belongsToMany(
            KerusakanMobil::class,
            'pemeriksaan_kerusakans',
            'pemeriksaan_id',
            'kerusakan_id'
        )->withPivot('keterangan');
    }
}