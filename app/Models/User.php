<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi dengan Kader (1 user bisa punya 1 kader)
    public function kader()
    {
        return $this->hasOne(Kader::class);
    }

    // Relasi ke tabel pasiens
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'user_id');
    }

    // Fungsi untuk mengecek apakah user ini adalah kader
    public function isKader()
    {
        return $this->role === 'kader';
    }

    // Fungsi untuk mengecek apakah user ini adalah pasien
    public function isPasien()
    {
        return $this->role === 'pasien';
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'user_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}
