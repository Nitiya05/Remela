<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Petugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'password',
        'nik',
        'user_id',  // Relasi ke user
    ];

    protected $hidden = ['password'];

    // Relasi dengan User (1 petugas punya 1 user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
