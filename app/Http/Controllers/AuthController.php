<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
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

        if (Auth::attempt([$loginField => $request->$loginField, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended(route($request->role . '.dashboard'));
        }

        return back()
            ->withInput($request->only($loginField, 'role'))
            ->withErrors([
                'auth' => 'NIK/Email atau password salah',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}