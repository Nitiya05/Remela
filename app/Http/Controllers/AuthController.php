<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            // Jika sudah login, redirect ke dashboard sesuai role
            return redirect()->route(Auth::user()->role . '.dashboard');
        }

        // Jika belum login, tampilkan halaman login dengan no-cache
        return response()
            ->view('auth.login')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT'
            ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'role' => 'required|in:admin,pasien,petugas,kader',
            'nik' => 'required_if:role,pasien|digits:16',
            'email' => 'required_if:role,admin,petugas,kader|email',
            'password' => 'required|min:6',
        ], [
            'role.required' => 'Pilih peran terlebih dahulu',
            'nik.required_if' => 'NIK wajib diisi untuk pasien',
            'nik.digits' => 'NIK harus 16 digit angka',
            'email.required_if' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        $loginField = $request->role === 'pasien' ? 'nik' : 'email';

        if (Auth::attempt([$loginField => $request->$loginField, 'password' => $request->password, 'role' => $request->role])) {
            $request->session()->regenerate();

            // Clear session old url
            $request->session()->forget('url.intended');

            return redirect()
                ->intended(route($request->role . '.dashboard'))
                ->withHeaders([
                    'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
                    'Pragma' => 'no-cache'
                ]);
        }

        return back()
            ->withInput($request->only($loginField, 'role'))
            ->withErrors(['auth' => 'Kredensial tidak valid']);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect dengan status 303 untuk clear history browser
        return redirect()
            ->route('login', [], 303)  // Kode status 303
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT'
            ]);
    }
}
