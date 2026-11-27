<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    public const STATUS_BELUM_BAYAR = 'belum bayar';
    public const STATUS_MENUNGGU_VERIFIKASI = 'menunggu verifikasi';
    public const STATUS_LUNAS = 'lunas';

    protected $fillable = ['rental_id', 'jenis', 'nominal', 'deskripsi', 'foto_bukti', 'status', 'bukti_bayar', 'tanggal_bayar'];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }

    /**
     * Semua denda yang belum lunas (status NULL juga dianggap belum lunas,
     * huruf besar/kecil diabaikan).
     */
    public function scopeBelumLunas($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('status')->orWhereRaw('LOWER(status) != ?', [self::STATUS_LUNAS]);
        });
    }

    public function isBelumBayar(): bool
    {
        return strtolower((string) $this->status) !== self::STATUS_LUNAS && strtolower((string) $this->status) !== self::STATUS_MENUNGGU_VERIFIKASI;
    }
}
