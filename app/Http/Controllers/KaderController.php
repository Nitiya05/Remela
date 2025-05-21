<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedisLansia;
use App\Models\Kader;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

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



        return view('kader.dashboard', compact('kader', 'jumlahLansia', 'jumlahPasien', 'umurDistribusi', 'genderDistribusi'));
    }


    public function dataPasien(Request $request)
    {
        $kader = Auth::user();
        $search = $request->query('search');

        $query = Pasien::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%');
        }

        $pasiens = $query->paginate(10); // 10 data per halaman

        foreach ($pasiens as $pasien) {
            $pasien->umur = Carbon::parse($pasien->tanggal_lahir)->age;
        }

        return view('kader.data-pasien', compact('kader', 'pasiens'));
    }

    public function rekamMedis(Request $request)
    {
        $query = RekamMedisLansia::with('pasien');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->whereHas('pasien', function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nik', 'like', '%' . $searchTerm . '%');
            });
        }

        $records = $query->paginate(20);
        $patient = Pasien::all();
        $kader = Auth::user();

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

    public function editProfil()
    {
        $kader = Auth::user()->kader;
        return view('kader.edit-profil', compact('kader'));
    }

    public function updateProfile(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());
        $kader = $user->kader;

        // Validasi data
        $rules = [
            'nama' => 'required|string|max:255', // Untuk tabel kaders
            'email' => 'required|email|unique:users,email,' . $user->id, // Untuk tabel users
            'no_hp' => 'nullable|string|max:15', // Untuk tabel kaders
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

        // Mulai transaction
        DB::beginTransaction();
        try {
            // Update data di tabel users (email dan password saja)
            $userData = [
                'email' => $validatedData['email'],
                'name' => $validatedData['nama'], // Jika Anda ingin sync nama ke users juga
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validatedData['password']);
            }

            foreach ($userData as $key => $value) {
                $user->$key = $value;
            }
            $user->save();

            // Update data di tabel kaders (nama dan no_hp,email)
            $kader->update([
                'nama' => $validatedData['nama'],
                'no_hp' => $validatedData['no_hp'] ?? null,
                'email' => $validatedData['email'],
            ]);

            DB::commit();

            return redirect()->route('kader.editProfil')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect('/login');
    }
}
