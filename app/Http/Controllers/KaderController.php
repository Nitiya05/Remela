<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedisLansia;
use App\Models\Kader;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KaderController extends Controller
{
    public function index()
{
    $kader = \App\Models\Kader::where('user_id', Auth::id())->first();

    // Menghitung jumlah lansia
    $jumlahLansia = Pasien::where('umur', '>=', 60)->count(); // Lansia (60+)
    // Ambil jumlah total pasien
    $jumlahPasien = \App\Models\Pasien::count();

    // Menghitung distribusi umur
    $umurDistribusi = Pasien::selectRaw('
        SUM(CASE WHEN umur BETWEEN 50 AND 59 THEN 1 ELSE 0 END) as usia_50_59,
        SUM(CASE WHEN umur BETWEEN 60 AND 64 THEN 1 ELSE 0 END) as usia_60_64,
        SUM(CASE WHEN umur BETWEEN 65 AND 69 THEN 1 ELSE 0 END) as usia_65_69,
        SUM(CASE WHEN umur BETWEEN 70 AND 74 THEN 1 ELSE 0 END) as usia_70_74,
        SUM(CASE WHEN umur BETWEEN 75 AND 79 THEN 1 ELSE 0 END) as usia_75_79,
        SUM(CASE WHEN umur >= 80 THEN 1 ELSE 0 END) as usia_80_plus
    ')->first();

    // Menghitung distribusi gender
    $genderDistribusi = Pasien::selectRaw('
        SUM(CASE WHEN jenis_kelamin = "L" THEN 1 ELSE 0 END) as laki,
        SUM(CASE WHEN jenis_kelamin = "P" THEN 1 ELSE 0 END) as perempuan
    ')->first();



    return view('kader.dashboard', compact('kader', 'jumlahLansia', 'jumlahPasien','umurDistribusi', 'genderDistribusi'));
}


    public function dataPasien(Request $request)
    {
        $kader = Auth::user();
        // Ambil data pasien dengan pagination (15 per halaman)
        $search = $request->query('search'); // Ambil parameter pencarian dari URL

        $query = Pasien::query(); // Mulai query

        // Jika ada parameter pencarian, tambahkan kondisi pencarian
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%');
        }

        // Paginasi hasil query
        $pasiens = $query->paginate(10);

        // Hitung umur untuk setiap pasien
        foreach ($pasiens as $pasien) {
            $pasien->umur = Carbon::parse($pasien->tanggal_lahir)->age;
        }

        return view('kader.data-pasien', compact('kader', 'pasiens'));
    }


    public function rekamMedis()
    {
        $kader = Auth::user();
        $records = RekamMedisLansia::all(); // Ambil semua data rekam medis
        $patient = Pasien::all(); // Ambil daftar pasien untuk modal (jika diperlukan)

        return view('kader.rekam-medis', compact('kader', 'records', 'patient'));
    }


    public function jadwal()
    {
        return view('kader.jadwal');
    }

    public function dokumentasi()
    {
        return view('kader.dokumentasi');
    }

    // public function pengaturan()
    // {
    //     return view('kader.pengaturan');
    // }

    public function logout()
    {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect('/login');
    }
}
