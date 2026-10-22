<?php

namespace App\Models;

use App\Models\Role;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

#[Fillable([
    'name',
    'email',
    'password',
    'photo',
    'phone',
    'address'
])]
#[Hidden([
    'password',
    'remember_token',
    'otp_code'
])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id');
    }

    public function issueOtp(): string
    {
        $code = (string) random_int(100000, 999999);

        $this->forceFill([
            'otp_code' => Hash::make($code),
            'otp_expires_at' => now()->addMinutes(5),
        ])->save();

        return $code;
    }

    public function clearOtp(): void
    {
        $this->forceFill([
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();
    }
}