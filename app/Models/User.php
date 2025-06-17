<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * =======================================================
     * PASTIKAN KONSTANTA INI SUDAH ADA
     * =======================================================
     */
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;
    const ROLE_SUPERADMIN = 2;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Pastikan ini ada agar bisa di-update
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke data nasabah
     */
    public function nasabah(): HasOne
    {
        return $this->hasOne(Nasabah::class);
    }

    /**
     * =======================================================
     * TAMBAHKAN DUA METHOD DI BAWAH INI
     * =======================================================
     */

    /**
     * Cek apakah user adalah Admin atau Super Admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin >= self::ROLE_ADMIN; // (is_admin >= 1)
    }

    /**
     * Cek apakah user adalah Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_admin === self::ROLE_SUPERADMIN; // (is_admin == 2)
    }
}