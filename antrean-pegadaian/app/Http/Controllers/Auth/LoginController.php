<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Memproses form login Kiosk & Kasir/Admin di satu gerbang yang sama
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->has('remember'); 

        // Proses autentikasi ke database
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Tangkap data user yang barusan sukses login
            $user = Auth::user();

            // 1. JIKA YANG LOGIN ADALAH SATPAM KIOSK
            if ($user->role === 'kiosk') {
                return redirect()->intended('/kiosk');
            }

            // 2. JIKA YANG LOGIN ADALAH KASIR ATAU ADMIN
            // Keduanya langsung dilempar ke dashboard Filament (/admin)
            if ($user->role === 'kasir' || $user->role === 'admin') {
                return redirect()->intended('/admin');
            }
        } 

        // Jika data login salah, kembalikan dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    // Tombol Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}