<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\RekamMedisLansia;
use App\Models\Dokumentasi;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;

class PasienController extends Controller
{
    // Tambahkan method index
    public function index(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Cari data pasien berdasarkan user_id
        $pasien = $user->pasien;


        if (!$pasien) {
            $riwayat = collect();
        } else {
            // Default to latest record if no filters
            if (!$request->has('bulan') && !$request->has('tahun')) {
                $riwayat = RekamMedisLansia::where('patient_id', $pasien->id)
                    ->latest('tanggal_rekam')
                    ->take(1)
                    ->get();
            } else {
                // Apply filters when requested
                $riwayat = RekamMedisLansia::where('patient_id', $pasien->id)
                    ->when($request->has('bulan'), function ($query) use ($request) {
                        $query->whereMonth('tanggal_rekam', $request->bulan);
                    })
                    ->when($request->has('tahun'), function ($query) use ($request) {
                        $query->whereYear('tanggal_rekam', $request->tahun);
                    })
                    ->orderBy('tanggal_rekam', 'desc')
                    ->get();
            }
        

            // Riwayat bulan ini / terakhir
            $riwayatBulanIni = RekamMedisLansia::where('patient_id', $pasien->id)
                ->whereMonth('tanggal_rekam', now()->month)
                ->whereYear('tanggal_rekam', now()->year)
                ->orderBy('tanggal_rekam', 'desc')
                ->get()
                ->map(function ($item) use ($pasien) {
                    // Ensure tanggal_rekam is a Carbon instance
                    $item->tanggal_rekam = \Carbon\Carbon::parse($item->tanggal_rekam);

                    // Add health categories
                    $item->kategori_tekanan_darah = $this->kategoriTekananDarah(
                        $item->tekanan_darah_sistolik,
                        $item->tekanan_darah_diastolik
                    );
                    $item->kategori_gula_darah = $this->kategoriGulaDarah($item->gula_darah);
                    $item->kategori_kolesterol = $this->kategoriKolesterol($item->kolesterol);
                    $item->kategori_asam_urat = $this->kategoriAsamUrat(
                        $item->asam_urat,
                        $pasien->jenis_kelamin
                    );
                    $item->kategori_lingkar_perut = $this->kategoriLingkarPerut(
                        $item->lingkar_perut,
                        $pasien->jenis_kelamin
                    );
                    $item->kategori_imt = $this->kategoriIMT($item->bmi);

                    return $item;
                });

            // Jika tidak ada riwayat bulan ini, ambil data riwayat terakhir
            if ($riwayatBulanIni->isEmpty()) {
                $riwayatBulanIni = RekamMedisLansia::where('patient_id', $pasien->id)
                    ->orderBy('tanggal_rekam', 'desc')
                    ->take(1)
                    ->get()
                    ->map(function ($item) use ($pasien) {
                        // Ensure tanggal_rekam is a Carbon instance
                        $item->tanggal_rekam = \Carbon\Carbon::parse($item->tanggal_rekam);

                        // Add health categories
                        $item->kategori_tekanan_darah = $this->kategoriTekananDarah(
                            $item->tekanan_darah_sistolik,
                            $item->tekanan_darah_diastolik
                        );
                        $item->kategori_gula_darah = $this->kategoriGulaDarah($item->gula_darah);
                        $item->kategori_kolesterol = $this->kategoriKolesterol($item->kolesterol);
                        $item->kategori_asam_urat = $this->kategoriAsamUrat(
                            $item->asam_urat,
                            $pasien->jenis_kelamin
                        );
                        $item->kategori_lingkar_perut = $this->kategoriLingkarPerut(
                            $item->lingkar_perut,
                            $pasien->jenis_kelamin
                        );
                        $item->kategori_imt = $this->kategoriIMT($item->bmi);

                        return $item;
                    });

                // Add a flag to indicate this is last record (not current month)
                if ($riwayatBulanIni->isNotEmpty()) {
                    $riwayatBulanIni->first()->is_last_record = true;
                }
            }

            // Ambil data untuk grafik
            $grafikData = RekamMedisLansia::where('patient_id', $pasien->id)
                ->when($request->has('tahun'), function ($query) use ($request) {
                    $query->whereYear('tanggal_rekam', $request->tahun); // Filter tahun
                })
                ->orderBy('tanggal_rekam')
                ->get();
        }

        // Siapkan data untuk grafik
        $labels = $grafikData->pluck('tanggal_rekam')->map(function ($date) {
            return Carbon::parse($date)->format('d M Y'); // Konversi string ke Carbon dan format
        });

        $tekananDarahSistolik = $grafikData->pluck('tekanan_darah_sistolik');
        $tekananDarahDiastolik = $grafikData->pluck('tekanan_darah_diastolik');
        $gulaDarah = $grafikData->pluck('gula_darah');
        $kolesterol = $grafikData->pluck('kolesterol');
        $asamUrat = $grafikData->pluck('asam_urat');
        $lingkarPerut = $grafikData->pluck('lingkar_perut');
        $imt = $grafikData->pluck('bmi');

        // Ambil data dokumentasi
        $dokumentasi = Dokumentasi::all();

        // Ambil jadwal pelayanan selanjutnya
        $jadwal = Jadwal::where('tanggal', '>=', now()->subMonths(3))
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(function ($item) {
                $item->tanggal = \Carbon\Carbon::parse($item->tanggal);
                return $item;
            });

        // Kirim semua data ke view
        return view('pasiens.dashboard', compact(
            'riwayat',
            'riwayatBulanIni',
            'labels',
            'tekananDarahSistolik',
            'tekananDarahDiastolik',
            'gulaDarah',
            'kolesterol',
            'asamUrat',
            'lingkarPerut',
            'imt',
            'dokumentasi',
            'jadwal'
        ));
    }

    /**
     * Fungsi Kategorisasi Data Kesehatan
     */
    private function kategoriTekananDarah($sistolik, $diastolik)
    {
        if ($sistolik < 120 && $diastolik < 80) {
            return 'normal';
        } elseif ($sistolik >= 120 && $sistolik <= 139 || $diastolik >= 80 && $diastolik <= 89) {
            return 'prehipertensi';
        } elseif ($sistolik >= 140 && $sistolik <= 159 || $diastolik >= 90 && $diastolik <= 99) {
            return 'hipertensi-1';
        } else {
            return 'hipertensi-2';
        }
    }

    private function kategoriGulaDarah($gulaDarah)
    {
        return $gulaDarah < 200 ? 'normal' : 'diabetes';
    }

    private function kategoriKolesterol($kolesterol)
    {
        if ($kolesterol < 200) {
            return 'normal';
        } elseif ($kolesterol >= 200 && $kolesterol <= 239) {
            return 'borderline';
        } else {
            return 'tinggi';
        }
    }

    private function kategoriAsamUrat($asamUrat, $jenisKelamin)
    {
        $batasAtas = $jenisKelamin === 'L' ? 7.0 : 6.0;
        return $asamUrat > $batasAtas ? 'tinggi' : 'normal';
    }

    private function kategoriLingkarPerut($lingkarPerut, $jenisKelamin)
    {
        $batas = $jenisKelamin === 'L' ? 90 : 80;
        return $lingkarPerut > $batas ? 'obesitas' : 'normal';
    }

    private function kategoriIMT($imt)
    {
        if ($imt < 18.5) {
            return 'kurus';
        } elseif ($imt >= 18.5 && $imt <= 24.9) {
            return 'normal';
        } elseif ($imt >= 25 && $imt <= 29.9) {
            return 'overweight';
        } else {
            return 'obesitas';
        }
    }

    public function cetakPdf(Request $request)
    {
        $user = Auth::user();

        // Ambil data pasien dari relasi
        $pasien = $user->pasien;

        // Jika pasien tidak ditemukan, kembalikan response error
        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan.');
        }

        // Query untuk riwayat kesehatan
        $riwayatQuery = RekamMedisLansia::where('patient_id', $pasien->id);

        // Filter berdasarkan bulan jika ada
        if ($request->has('bulan')) {
            $riwayatQuery->whereMonth('tanggal_rekam', $request->bulan);
        }

        // Ambil data riwayat
        $riwayat = $riwayatQuery->orderBy('tanggal_rekam', 'desc')->get();

        // Jika riwayat kosong, beri pesan
        if ($riwayat->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada riwayat kesehatan untuk pasien ini.');
        }

        // Generate PDF
        $pdf = Pdf::loadView('pasiens.cetak-pdf', compact('pasien', 'riwayat'))
            ->setPaper('A4', 'portrait'); // Atur ukuran kertas dan orientasi

        // Return PDF untuk preview
        return $pdf->stream('riwayat-kesehatan.pdf');
    }

    public function showProfile()
    {
        // Ambil ID pengguna yang login
        $userId = Auth::user()->id;

        // Cari data pasien berdasarkan user_id dan join dengan tabel users
        $pasien = Pasien::where('user_id', $userId)
            ->join('users', 'pasiens.user_id', '=', 'users.id')
            ->select('pasiens.*', 'users.password') // Ambil kolom password dari users
            ->first();

        // Jika data pasien tidak ditemukan
        if (!$pasien) {
            abort(404, 'Data pasien tidak ditemukan.');
        }

        // Tampilkan view profil dengan data pasien
        return view('pasiens.profile', compact('pasien'));
    }

    public function editProfile($id)
    {
        // Ambil data pengguna yang sedang login beserta relasi pasien
        $user = Auth::user();
        $user->pasien;
        return view('pasiens.editProfile', compact('user'));
    }

    // Fungsi untuk menghitung umur
    private function hitungUmur($tanggal_lahir)
    {
        $tanggal_lahir = new DateTime($tanggal_lahir); // Ubah string tanggal lahir ke objek DateTime
        $sekarang = new DateTime(); // Ambil tanggal sekarang
        $umur = $sekarang->diff($tanggal_lahir); // Hitung selisih antara tanggal sekarang dan tanggal lahir
        return $umur->y; // Ambil nilai tahun dari selisih tersebut
    }

    public function updateProfile(Request $request, $id)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed|different:current_password',

            // Validasi untuk data pasien...
            'nik' => 'required|string|max:16',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
        ]);

        // Update data user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika ada password baru
        if ($request->filled('new_password')) {
            // Verifikasi password lama
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
            }

            // Update password baru
            $userData['password'] = Hash::make($request->new_password);
        }

        // Update data user
        User::where('id', $user->id)->update($userData);

        // Update data pasien
        $pasien->update([
            'nama' => $request->name,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $this->hitungUmur($request->tanggal_lahir),
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            // field lainnya...
        ]);

        return redirect()->route('pasiens.profile', Auth::id())->with('success', 'Profil berhasil diperbarui!');
    }

    public function create()
    {
        return view('kader.data-pasien.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:pasiens',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'nullable|email|unique:users', // Pastikan email unik di tabel users
            'no_hp' => 'nullable|string|max:15',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'status_kawin' => 'nullable|string|max:255',
            'golongan_darah' => 'nullable|string|max:2',
        ]);

        // Buat password default (misalnya, menggunakan NIK)
        $password = Hash::make($request->nik); // Gunakan NIK sebagai password default

        // Simpan data ke tabel `users`
        $user = User::create([
            'name' => $request->nama,
            'nik' => $request->nik,
            'email' => $request->email,
            'role' => 'pasien', // Set role sebagai pasien
            'password' => $password, // Simpan password yang sudah di-hash
        ]);

        // Hitung umur dari tanggal lahir
        $tanggalLahir = Carbon::parse($request->tanggal_lahir);
        $umur = $tanggalLahir->diffInYears(Carbon::now());

        // Simpan data ke tabel `pasiens` dengan mengaitkan `user_id`
        Pasien::create([
            'user_id' => $user->id, // Kaitkan dengan id user yang baru dibuat
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $umur,  // Simpan umur yang sudah dihitung
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'pekerjaan' => $request->pekerjaan,
            'status_kawin' => $request->status_kawin,
            'golongan_darah' => $request->golongan_darah,
        ]);

        return redirect()->route('kader.dataPasien')->with('success', 'Pasien berhasil ditambahkan!');
    }

    public function show(Pasien $pasien)
    {
        return view('kader.data-pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        return view('kader.data-pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'alamat' => 'required|string|max:255',
            // validasi lainnya
        ]);

        $pasien = Pasien::with('user')->findOrFail($id);
        $data = $request->except('_token', '_method', 'confirmReset');

        // Update data pasien
        $pasien->update($data);

        // Jika reset password dicentang
        if ($request->boolean('confirmReset')) {
            $pasien->user()->update([
                'password' => Hash::make($pasien->nik)
            ]);
        }

        return redirect()->route('kader.dataPasien')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
{
    $userId = $pasien->user_id;

    $pasien->delete(); // akan otomatis hapus juga jika user dihapus (jika arah sebaliknya)

    User::find($userId)?->delete();

    return redirect()->route('kader.dataPasien')->with('success', 'Pasien berhasil dihapus');
}


    public function downloadLaporan($id)
    {
        $pasien = Pasien::findOrFail($id);
        $riwayat = RekamMedisLansia::where('patient_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung usia
        $usia = now()->diffInYears($pasien->tanggal_lahir);

        $pdf = Pdf::loadView('pasiens.cetak-laporan', [
            'pasien' => $pasien,
            'riwayatBulanIni' => $riwayat,
            'usia' => $usia
        ]);

        // Opsi penting untuk DomPDF
        $pdf->setPaper('a4', 'portrait')
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('defaultFont', 'Arial');

        return $pdf->download('Laporan-Kesehatan-' . $pasien->nama . '.pdf');
    }
}
