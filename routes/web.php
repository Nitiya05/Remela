<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\RekamMedisLansiaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DokumentasiController;
use Illuminate\Support\Facades\Auth;


use App\Models\Jadwal;
use App\Models\Dokumentasi;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role . '.dashboard');
    }
    
    return view('welcome', [
        'jadwal' => Jadwal::orderBy('tanggal', 'desc')->take(5)->get(), 
        'dokumentasi' => Dokumentasi::with('fotos')
                            ->orderBy('created_at', 'desc')
                            ->take(8)
                            ->get()
    ]);
})->middleware(\App\Http\Middleware\NoCacheHeaders::class);

// Route untuk menampilkan form login
Route::get('login', function () {
    return view('auth.login');
})->name('auth.login');

// Route untuk menangani proses login (POST)
Route::post('login', [AuthController::class, 'login'])->name('login');

// Route untuk logout (POST)
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// Dashboard sesuai role
Route::middleware(['auth', \App\Http\Middleware\NoCacheHeaders::class])->group(function () {
    Route::get('/pasien/dashboard', [PasienController::class, 'index'])->name('pasien.dashboard');
    Route::get('/kader/dashboard', [KaderController::class, 'index'])->name('kader.dashboard');
    Route::get('/petugas/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard'); // Ini tetap di luar prefix admin
});

// Rute khusus admin untuk manajemen pengguna
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/manajemenpengguna', [AdminController::class, 'manajemenPengguna'])->name('admin.manajemenpengguna');

    // CRUD Pengguna
    Route::get('/admin/pengguna/create', [AdminController::class, 'create'])->name('admin.createpengguna');
    Route::match(['get', 'post'], '/admin/pengguna', [AdminController::class, 'store'])->name('admin.pengguna.store');

    // Route::post('/admin/pengguna', [AdminController::class, 'store'])->name('admin.pengguna.store');
    Route::get('/admin/pengguna/{id}/edit', [AdminController::class, 'edit'])->name('admin.editpengguna');
    Route::put('/admin/pengguna/{id}', [AdminController::class, 'update'])->name('admin.pengguna.update');
    Route::delete('/admin/pengguna/{id}', [AdminController::class, 'destroy'])->name('admin.pengguna.destroy');
});

// Rute khusus kader
Route::middleware(['auth'])->group(function () {
    // Dashboard dan menu utama
    Route::get('/data-pasien', [KaderController::class, 'dataPasien'])->name('kader.dataPasien');
    Route::get('/rekam-medis', [KaderController::class, 'rekamMedis'])->name('kader.rekamMedis');
    Route::get('/jadwal', [KaderController::class, 'jadwal'])->name('kader.jadwal');
    Route::get('/dokumentasi', [KaderController::class, 'dokumentasi'])->name('kader.dokumentasi');

    // CRUD Data Pasien
    Route::prefix('data-pasien')->group(function () {
        Route::get('/{pasien}', [PasienController::class, 'show'])->name('kader.data-pasien.show');
        Route::get('/{pasien}/edit', [PasienController::class, 'edit'])->name('kader.data-pasien.edit');
        Route::put('/{pasien}', [PasienController::class, 'update'])->name('kader.data-pasien.update');
        Route::delete('/{pasien}', [PasienController::class, 'destroy'])->name('kader.data-pasien.destroy');
        Route::get('/pasiens/cek-nik', [PasienController::class, 'cekNik'])->name('pasiens.cekNik');
    });

    // CRUD Rekam Medis Lansia
    Route::resource('rekam-medis-lansia', RekamMedisLansiaController::class);
    Route::get('/rekam-medis-lansia/create/{patient_id}', [RekamMedisLansiaController::class, 'create'])
        ->name('rekam-medis-lansia.create');
    Route::get('/printpdf', [RekamMedisLansiaController::class, 'generatePdf'])
        ->name('rekam-medis.printpdf'); // Named route

    // CRUD Jadwal
    Route::prefix('jadwal')->group(function () {
        Route::get('/', [JadwalController::class, 'index'])->name('kader.jadwal');
        Route::get('/create', [JadwalController::class, 'create'])->name('kader.jadwalKunjung.create');
        Route::post('/', [JadwalController::class, 'store'])->name('kader.jadwal.store');
        Route::get('/{id}/edit', [JadwalController::class, 'edit'])->name('kader.jadwal.edit');
        Route::put('/{id}', [JadwalController::class, 'update'])->name('kader.jadwal.update');
        Route::delete('/{id}', [JadwalController::class, 'destroy'])->name('kader.jadwal.destroy');
    });

    // CRUD Dokumentasi
    Route::prefix('dokumentasi')->group(function () {
        Route::get('/', [DokumentasiController::class, 'index'])->name('kader.dokumentasi');
        Route::get('/create', [DokumentasiController::class, 'create'])->name('kader.dokumentasi.create');
        Route::post('/', [DokumentasiController::class, 'store'])->name('kader.dokumentasi.store');
        Route::get('/{id}/edit', [DokumentasiController::class, 'edit'])->name('kader.dokumentasi.edit');
        Route::put('/{id}', [DokumentasiController::class, 'update'])->name('kader.dokumentasi.update');
        Route::delete('/{id}', [DokumentasiController::class, 'destroy'])->name('kader.dokumentasi.destroy');
        Route::delete('/foto/{foto}', [DokumentasiController::class, 'destroyFoto'])->name('kader.dokumentasi.destroyFoto');
    });

    // EditProfil
    Route::get('/editProfil', [KaderController::class, 'editProfil'])->name('kader.editProfil');
    Route::put('/profile/update', [KaderController::class, 'updateProfile'])->name('kader.profile.update');
});

// Rute untuk CRUD Pasien
Route::resource('pasiens', PasienController::class);
Route::get('/pasiens/{pasien}/profile', [PasienController::class, 'showProfile'])->name('pasiens.profile');
Route::get('/pasiens/{id}/editProfile', [PasienController::class, 'editProfile'])->name('pasiens.editProfile');
Route::put('/pasiens/{id}/updateProfile', [PasienController::class, 'updateProfile'])->name('pasiens.updateProfile');
Route::get('/pasien/cetak-pdf', [PasienController::class, 'cetakPdf'])->name('pasien.cetak-pdf');
Route::get('/cetak-laporan/{id}', [PasienController::class, 'downloadLaporan'])->name('download.laporan');

//Rute untuk CRUD Petugas Kesehatan
Route::prefix('petugas')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/daftar-kader', [PetugasController::class, 'daftarKader'])->name('petugas.daftarKader');
    Route::get('/daftar-pasien', [PetugasController::class, 'daftarPasien'])->name('petugas.daftarPasien');
    Route::get('/daftar-pasien/{id}', [PetugasController::class, 'show'])->name('petugas.rekamMedis.show');
    Route::get('/laporan', [PetugasController::class, 'createLaporan'])->name('petugas.laporan');
    Route::post('/laporan/simpan', [PetugasController::class, 'simpanLaporan'])->name('petugas.simpanLaporan');
    Route::get('/rekam-medis-terakhir/{pasienId}', [PetugasController::class, 'getRekamMedisTerakhir']);
    Route::get('/editProfil', [PetugasController::class, 'editProfil'])->name('petugas.editProfil');
    Route::put('/profile/update', [PetugasController::class, 'updateProfile'])->name('petugas.profile.update');
    Route::get('/petugas/cetak-pdf/{id}', [PetugasController::class, 'generatePDF'])->name('petugas.cetakPdf');

});

Route::get('/petugas/rekam-medis/{id}', [RekamMedisLansiaController::class, 'show'])->name('rekam-medis.show');
