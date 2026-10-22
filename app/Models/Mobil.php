<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mobil extends Model
{

    protected $fillable = [
        'brand_id',
        'tipe_mobil_id',
        'cabang_id',
        'name',
        'plate_number',
        'slug',
        'tahun',
        'transmisi',
        'kapasitas',
        'warna',
        'harga_perhari',
        'deposit',
        'image',
        'status',
        'description',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Mobil $mobil) {
            if (empty($mobil->slug)) {
                $mobil->slug = static::generateUniqueSlug($mobil->name, $mobil->plate_number);
            }
        });

        static::updating(function (Mobil $mobil) {
            if ($mobil->isDirty('name') || $mobil->isDirty('plate_number') || empty($mobil->slug)) {
                $mobil->slug = static::generateUniqueSlug($mobil->name, $mobil->plate_number, $mobil->id);
            }
        });
    }

    protected static function generateUniqueSlug(?string $name, ?string $plateNumber, ?int $excludeId = null): string
    {
        $base = Str::slug(($name ?? '') . '-' . ($plateNumber ?? ''));
        $candidate = $base;
        $i = 2;
        while (static::where('slug', $candidate)->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $candidate = $base . '-' . $i;
            $i++;
        }
        return $candidate;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function tipeMobil()
    {
        return $this->belongsTo(TipeMobil::class, 'tipe_mobil_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'mobil_fasilitas',
            'mobil_id',
            'fasilitas_id'
        );
    }

    public function fotoMobils()
    {
        return $this->hasMany(FotoMobil::class, 'mobil_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'mobil_id');
    }
}
