<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Kader;
use App\Models\Pasien;
use App\Models\RekamMedisLansia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PetugasController extends Controller
{
    public function index()
    {
        // Data Statistik Utama
        $jumlahKader = Kader::count();
        $jumlahPasien = Pasien::count();
        $jumlahRekamMedis = RekamMedisLansia::count();

        // Data Statistik Bulanan
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        $jumlahKunjunganBulanIni = RekamMedisLansia::whereMonth('tanggal_rekam', $bulanIni)
            ->whereYear('tanggal_rekam', $tahunIni)
            ->count();

        $jumlahPasienBaru = Pasien::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        // Data Demografi Pasien
        $golonganDarah = Pasien::select('golongan_darah', DB::raw('count(*) as total'))
            ->groupBy('golongan_darah')
            ->orderBy('total', 'desc')
            ->get();

        $kelompokUsia = Pasien::selectRaw('
        CASE
            WHEN umur < 5 THEN "Balita (0-4)"
            WHEN umur BETWEEN 5 AND 12 THEN "Anak-anak (5-12)"
            WHEN umur BETWEEN 13 AND 19 THEN "Remaja (13-19)"
            WHEN umur BETWEEN 20 AND 40 THEN "Dewasa (20-40)"
            WHEN umur BETWEEN 41 AND 60 THEN "Paruh Baya (41-60)"
            ELSE "Lansia (60+)"
        END AS kelompok_usia,
        COUNT(*) AS total
    ')
            ->groupBy('kelompok_usia')
            ->orderBy('total', 'desc')
            ->get();

        $statusKawin = Pasien::select('status_kawin', DB::raw('count(*) as total'))
            ->groupBy('status_kawin')
            ->orderBy('total', 'desc')
            ->get();

        $pendidikanTerakhir = Pasien::select('pendidikan_terakhir', DB::raw('count(*) as total'))
            ->groupBy('pendidikan_terakhir')
            ->orderBy('total', 'desc')
            ->get();

        $pekerjaan = Pasien::select('pekerjaan', DB::raw('count(*) as total'))
            ->groupBy('pekerjaan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Data Kunjungan 6 Bulan Terakhir
        $kunjunganPerBulan = RekamMedisLansia::selectRaw('
        DATE_FORMAT(tanggal_rekam, "%Y-%m") AS bulan,
        COUNT(*) AS total
    ')
            ->where('tanggal_rekam', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->bulan)->format('M Y') => $item->total];
            });

        // Aktivitas Terkini
        $recentActivities = [
            [
                'type' => 'new_patients',
                'count' => $jumlahPasienBaru,
                'message' => 'Pasien baru bulan ini',
                'icon' => 'user-add',
                'color' => 'green',
                'time' => now()
            ],
            [
                'type' => 'medical_records',
                'count' => $jumlahKunjunganBulanIni,
                'message' => 'Kunjungan bulan ini',
                'icon' => 'document-text',
                'color' => 'blue',
                'time' => now()
            ],
            [
                'type' => 'system_update',
                'version' => '2.1.0',
                'message' => 'Versi terbaru sistem',
                'icon' => 'refresh',
                'color' => 'purple',
                'time' => now()->subDays(2)
            ]
        ];

        // Data untuk Chart Jenis Kelamin
        $jenisKelaminData = [
            'labels' => ['Laki-laki', 'Perempuan'],
            'data' => [
                Pasien::where('jenis_kelamin', 'L')->count(),
                Pasien::where('jenis_kelamin', 'P')->count()
            ]
        ];

        return view('petugas.dashboard', compact(
            'jumlahKader',
            'jumlahPasien',
            'jumlahRekamMedis',
            'jumlahKunjunganBulanIni',
            'jumlahPasienBaru',
            'golonganDarah',
            'kelompokUsia',
            'statusKawin',
            'pendidikanTerakhir',
            'pekerjaan',
            'kunjunganPerBulan',
            'recentActivities',
            'jenisKelaminData'
        ));
    }

    public function daftarKader()
    {
        // Ambil data user dengan role 'kader' beserta relasi kader-nya
        $users = User::where('role', 'kader')->with('kader')->get();

        return view('petugas.daftar-kader', compact('users'));
    }

    public function daftarPasien(Request $request)
    {
        $search = $request->query('search');

        $query = Pasien::with(['rekamMedisLansia' => function ($query) {
            $query->orderBy('tanggal_rekam', 'desc');
        }]);

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%');
        }

        $pasiens = $query->paginate(10);

        return view('petugas.daftar-pasien', compact('pasiens'));
    }

    public function createLaporan()
    {
        // Ambil data pasien dengan rekam medis terakhir (prioritas: bulan ini -> bulan lalu -> terakhir)
        $pasiens = Pasien::with(['rekamMedisTerakhir' => function($query) {
            $now = now();
            $bulanLalu = $now->copy()->subMonth();
            
            $query->orderByRaw("
                CASE
                    WHEN MONTH(tanggal_rekam) = ? AND YEAR(tanggal_rekam) = ? THEN 1
                    WHEN MONTH(tanggal_rekam) = ? AND YEAR(tanggal_rekam) = ? THEN 2
                    ELSE 3
                END
            ", [
                $now->month, $now->year,
                $bulanLalu->month, $bulanLalu->year
            ])
            ->orderBy('tanggal_rekam', 'desc');
        }])
        ->paginate(15);

        return view('petugas.laporan', compact('pasiens'));
    }

    public function simpanLaporan(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:pasiens,id',
            'catatan' => 'required|string|max:1000',
        ]);

        // Cari rekam medis terakhir untuk pasien ini
        $rekamMedis = RekamMedisLansia::where('patient_id', $request->patient_id)
            ->latest('tanggal_rekam')
            ->first();

        if ($rekamMedis) {
            // Update catatan petugas
            $rekamMedis->update(['catatan_petugas' => $request->catatan]);
            return redirect()->back()->with('success', 'Catatan berhasil diperbarui.');
        }

        // Jika tidak ada rekam medis, buat yang baru
        RekamMedisLansia::create([
            'patient_id' => $request->patient_id,
            'tanggal_rekam' => now(),
            'catatan_petugas' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Catatan baru berhasil ditambahkan.');
    }

    public function show($id, Request $request)
    { // Ambil data rekam medis berdasarkan ID
        $record = RekamMedisLansia::with('pasien')->find($id);

        if (!$record) {
            return redirect()->route('rekam-medis-lansia.index')->with('error', 'Rekam medis tidak ditemukan.');
        }

        // Ambil data pasien terkait
        $pasien = $record->pasien;

        // Query untuk mengambil rekam medis berdasarkan ID pasien
        $query = RekamMedisLansia::with('pasien')->where('patient_id', $pasien->id);

        // Filter berdasarkan bulan jika ada
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_rekam', $request->bulan);
        }

        // Filter berdasarkan tahun jika ada
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_rekam', $request->tahun);
        }

        // Ambil data rekam medis
        $records = $query->get();

        // Siapkan data untuk grafik
        $labels = [];
        $tekananDarahSistolik = [];
        $tekananDarahDiastolik = [];
        $gulaDarah = [];
        $kolesterol = [];
        $asamUrat = [];
        $imt = [];
        $lingkarPerut = [];

        foreach ($records as $record) {
            $labels[] = \Carbon\Carbon::parse($record->tanggal_rekam)->format('d M Y');
            $tekananDarahSistolik[] = $record->tekanan_darah_sistolik;
            $tekananDarahDiastolik[] = $record->tekanan_darah_diastolik;
            $gulaDarah[] = $record->gula_darah;
            $kolesterol[] = $record->kolesterol;
            $asamUrat[] = $record->asam_urat;
            $imt[] = $record->imt;
            $lingkarPerut[] = $record->lingkar_perut;
        }

        // Tampilkan view dengan data yang diperlukan
        return view('petugas.rekamMedis.show', compact(
            'records',
            'labels',
            'tekananDarahSistolik',
            'tekananDarahDiastolik',
            'gulaDarah',
            'kolesterol',
            'asamUrat',
            'imt',
            'lingkarPerut',
            'pasien'
        ));
    }
}
