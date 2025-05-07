<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{

    protected $fillable = ['nama_kegiatan', 'deskripsi', 'waktu', 'lokasi'];

    public function fotos()
    {
        return $this->hasMany(Foto::class);
    }

    protected $casts = [
        'foto' => 'array',
    ];
}