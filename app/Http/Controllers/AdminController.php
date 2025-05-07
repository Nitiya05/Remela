<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kader;
use App\Models\Petugas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    // ✅ Dashboard Admin (Jangan diubah)
    public function index()
    {
        // Data dasar
        $jumlahPetugas = User::where('role', 'petugas')->count();
        $jumlahKader = User::where('role', 'kader')->count();
        $jumlahPasien = User::where('role', 'pasien')->count();

        // Data terbaru
        $penggunaTerbaru = User::whereIn('role', ['petugas', 'kader'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $PasienTerbaru = User::where('role', 'pasien')
            ->with('pasien')
            ->latest()
            ->take(5)
            ->get();

            // Aktivitas Terkini
    $recentActivities = [
        [
            'type' => 'new_users',
            'count' => User::whereDate('created_at', today())->count(),
            'time' => now()->subHours(2),
            'icon' => 'info',
            'color' => 'blue'
        ],
        [
            'type' => 'system_update',
            'version' => '2.1.0',
            'time' => now()->subDay(),
            'icon' => 'check',
            'color' => 'green'
        ],
        // Anda bisa menambahkan aktivitas lain seperti:
        [
            'type' => 'new_patients',
            'count' => User::where('role', 'pasien')->whereDate('created_at', today())->count(),
            'time' => now()->subHours(5),
            'icon' => 'user-add',
            'color' => 'purple'
        ],
        [
            'type' => 'new_kader',
            'count' => User::where('role', 'kader')->whereDate('created_at', today())->count(),
            'time' => now()->subHours(5),
            'icon' => 'user-add',
            'color' => 'purple'
        ],
        [
            'type' => 'new_petugasKesehatan',
            'count' => User::where('role', 'petugas')->whereDate('created_at', today())->count(),
            'time' => now()->subHours(5),
            'icon' => 'user-add',
            'color' => 'purple'
        ]
    ];

        return view('admin.dashboard', compact(
            'jumlahPetugas',
            'jumlahKader',
            'jumlahPasien',
            'penggunaTerbaru',
            'PasienTerbaru',
            'recentActivities'
            
        ));
    }

    public function manajemenPengguna()
    {
        // Gunakan eager loading untuk relasi kader dan petugas
        $pengguna = User::with(['kader', 'petugas'])
            ->whereIn('role', ['kader', 'petugas'])
            ->get();

        return view('admin.manajemenpengguna', compact('pengguna'));
    }

    // ✅ Menampilkan form tambah pengguna
    public function create()
    {
        return view('admin.createpengguna');
    }


    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:kader,petugas',
            'no_hp' => 'nullable|regex:/^[0-9]+$/|min:10|max:15'
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.regex' => 'Nomor HP harus berupa angka',
            'no_hp.min' => 'Nomor HP minimal 12 digit',
        ]);

        DB::beginTransaction();

        try {
            // Buat user baru
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'],
                'no_hp' => $validated['no_hp'] ?? null
            ]);

            // Buat record berdasarkan role
            $data = [
                'user_id' => $user->id,
                'nama' => $validated['name'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'] ?? null,
                'password' => bcrypt($validated['password']),
            ];

            match ($validated['role']) {
                'kader' => Kader::create($data),
                'petugas' => Petugas::create($data),
            };

            DB::commit();

            return redirect()
                ->route('admin.manajemenpengguna')
                ->with('success', 'Pengguna berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('User creation error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_email' => $request->input('email'),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    // ✅ Menampilkan form edit pengguna
    public function edit($id)
    {
        $pengguna = User::findOrFail($id);
        return view('admin.editpengguna', compact('pengguna'));
    }

    // ✅ Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:kader,petugas',
            'no_hp' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'no_hp' => $request->no_hp
        ];

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Mulai transaction
        DB::beginTransaction();

        try {
            // Update user
            $pengguna->update($data);

            // Update data terkait di tabel kader/petugas
            if ($pengguna->role == 'kader') {
                Kader::updateOrCreate(
                    ['user_id' => $id],
                    [
                        'nama' => $request->name,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp
                    ]
                );
            } elseif ($pengguna->role == 'petugas') {
                Petugas::updateOrCreate(
                    ['user_id' => $id],
                    [
                        'nama' => $request->name,
                        'email' => $request->email,
                        'no_hp' => $request->no_hp
                    ]
                );
            }

            DB::commit();

            return redirect()->route('admin.manajemenpengguna')
                ->with('success', 'Pengguna berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    // ✅ Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role == 'kader') {
            Kader::where('user_id', $id)->delete();
        } elseif ($user->role == 'petugas') {
            Petugas::where('user_id', $id)->delete();
        }

        $user->delete();

        return redirect()->route('admin.manajemenpengguna')->with('success', 'Pengguna berhasil dihapus');
    }
}
