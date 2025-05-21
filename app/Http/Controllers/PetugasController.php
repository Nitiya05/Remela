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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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

    public function createLaporan(Request $request)
    {
        $search = $request->input('search');
        $now = now();
        $bulanLalu = $now->copy()->subMonth();

        $pasiens = Pasien::with(['rekamMedisTerakhir' => function ($query) use ($now, $bulanLalu) {
            $query->orderByRaw("
            CASE
                WHEN MONTH(tanggal_rekam) = ? AND YEAR(tanggal_rekam) = ? THEN 1
                WHEN MONTH(tanggal_rekam) = ? AND YEAR(tanggal_rekam) = ? THEN 2
                ELSE 3
            END
        ", [
                $now->month,
                $now->year,
                $bulanLalu->month,
                $bulanLalu->year
            ])
                ->orderBy('tanggal_rekam', 'desc');
        }])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
            })
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
    {
        try {
            $pasien = Pasien::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('petugas.daftarPasien')
                ->with('error', 'Pasien tidak ditemukan');
        }

        $query = RekamMedisLansia::where('patient_id', $id)
            ->orderBy('tanggal_rekam', 'desc');

        // Deteksi apakah ada filter
        $filtered = false;

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_rekam', $request->bulan);
            $filtered = true;
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_rekam', $request->tahun);
            $filtered = true;
        }

        // Jika tidak difilter, hanya ambil 3 data terakhir
        if (!$filtered) {
            $query->limit(3);
        }

        $records = $query->get();

        // Persiapan data chart
        $labels = [];
        $tekananDarahSistolik = [];
        $tekananDarahDiastolik = [];
        $gulaDarah = [];
        $kolesterol = [];
        $asamUrat = [];
        $imt = [];
        $lingkarPerut = [];
        $beratBadan = [];
        $tinggiBadan = [];

        foreach ($records as $record) {
            $labels[] = \Carbon\Carbon::parse($record->tanggal_rekam)->format('d M Y');
            $tekananDarahSistolik[] = $record->tekanan_darah_sistolik ?? null;
            $tekananDarahDiastolik[] = $record->tekanan_darah_diastolik ?? null;
            $gulaDarah[] = $record->gula_darah ?? null;
            $kolesterol[] = $record->kolesterol ?? null;
            $asamUrat[] = $record->asam_urat ?? null;
            $imt[] = $record->bmi ?? null;
            $lingkarPerut[] = $record->lingkar_perut ?? null;
            $beratBadan[] = $record->berat_badan ?? null;
            $tinggiBadan[] = $record->tinggi_badan ?? null;
        }

        $availableYears = RekamMedisLansia::selectRaw('YEAR(tanggal_rekam) as year')
            ->where('patient_id', $id)
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('petugas.rekamMedis.show', compact(
            'pasien',
            'records',
            'labels',
            'tekananDarahSistolik',
            'tekananDarahDiastolik',
            'gulaDarah',
            'kolesterol',
            'asamUrat',
            'imt',
            'lingkarPerut',
            'beratBadan',
            'tinggiBadan',
            'availableYears'
        ))->with([
            'selectedBulan' => $request->bulan,
            'selectedTahun' => $request->tahun
        ]);
    }


    public function editProfil()
    {
        $petugas = Auth::user()->petugas; // Pastikan relasi 'petugas' ada di model User
        return view('petugas.edit-profil', compact('petugas')); // Sesuaikan dengan path view Anda
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        $petugas = $user->petugas;

        // Validasi data
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:15',
        ];

        // Validasi password jika diisi
        if ($request->filled('password')) {
            $rules['current_password'] = ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Password saat ini tidak sesuai');
                }
            }];
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        $validatedData = $request->validate($rules);

        DB::beginTransaction();
        try {
            // Update data user
            $user->email = $validatedData['email'];
            if ($request->filled('password')) {
                $user->password = Hash::make($validatedData['password']);
            }
            $user->save();

            // Update data petugas
            $petugas->update([
                'nama' => $validatedData['nama'],
                'no_hp' => $validatedData['no_hp'] ?? null,
                'email' => $validatedData['email'],
            ]);

            DB::commit();

            return redirect()->route('petugas.editProfil')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    public function generatePDF($id)
    {
        // Ambil bulan dan tahun terakhir dari data rekam medis
        $latestRecordDate = RekamMedisLansia::orderBy('tanggal_rekam', 'desc')->value('tanggal_rekam');

        if (!$latestRecordDate) {
            return redirect()->back()->with('error', 'Tidak ada data rekam medis tersedia.');
        }

        $latestMonth = \Carbon\Carbon::parse($latestRecordDate)->month;
        $latestYear = \Carbon\Carbon::parse($latestRecordDate)->year;

        // Ambil data rekam medis di bulan dan tahun tersebut
        $record = RekamMedisLansia::with('pasien')
            ->whereMonth('tanggal_rekam', $latestMonth)
            ->whereYear('tanggal_rekam', $latestYear)
            ->orderBy('tanggal_rekam', 'desc')
            ->first(); // ambil salah satu rekam medis terbaru dari bulan itu

        if (!$record) {
            return redirect()->back()->with('error', 'Rekam medis bulan terakhir tidak ditemukan.');
        }

        $pasien = $record->pasien;

        $pdf = Pdf::loadView('petugas.laporan-pdf', [
            'pasien' => $pasien,
            'record' => $record,
        ]);

        return $pdf->stream('rekam_medis_' . $pasien->nama . '.pdf');

    }
}
