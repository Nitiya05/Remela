<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = ['nama_kegiatan', 'tanggal', 'waktu', 'lokasi', 'keterangan', 'status'];
}
