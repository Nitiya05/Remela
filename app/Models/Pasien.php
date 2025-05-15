<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pasien extends Model
{
    protected $fillable = [
        'user_id','nama','nik','tanggal_lahir','umur','jenis_kelamin','alamat','email','no_hp','pendidikan_terakhir','pekerjaan','status_kawin','golongan_darah',
    ];

    protected $table = 'pasiens';

    protected $appends = ['umur'];

    public function getUmurAttribute()
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rekamMedisLansia()
    {
        return $this->hasMany(RekamMedisLansia::class, 'patient_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pasien) {
            // Hapus user yang terkait dengan pasien ini
            $pasien->user()->delete();
        });
    }
    
    public function rekamMedisTerakhir()
    {
        return $this->hasOne(RekamMedisLansia::class, 'patient_id')->latest('tanggal_rekam');
    }
}
