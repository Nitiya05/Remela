<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedisLansia extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis_lansia';

    protected $fillable = [
        'patient_id',
        'tanggal_rekam',
        'riwayat_penyakit',
        'merokok',
        'kurang_aktivitas_fisik',
        'kurang_sayur_buah',
        'konsumsi_alkohol',
        'berat_badan',
        'tinggi_badan',
        'lingkar_perut',
        'bmi',
        'tekanan_darah_sistolik',
        'tekanan_darah_diastolik',
        'gula_darah',
        'kolesterol',
        'asam_urat', 
        'obat',
        'catatan_petugas'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'patient_id');
    }

    

    public function setBmiAttribute()
    {
        if ($this->berat_badan && $this->tinggi_badan) {
            $tinggi_meter = $this->tinggi_badan / 100; // Konversi cm ke meter
            $this->attributes['bmi'] = round($this->berat_badan / ($tinggi_meter * $tinggi_meter), 2);
        }
    }
}
