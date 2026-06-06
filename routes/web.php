<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect('/login');
});

// Login
Route::get('/login', function () {
    if (auth()->check()) {
        // Jika sudah login, cek role-nya biar diarahkan ke tempat yang benar
        $role = auth()->user()->role;
        if ($role === 'kiosk') return redirect('/kiosk');
        if ($role === 'kasir' || $role === 'admin') return redirect('/admin');
    }
    return view('auth.login'); 
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Halaman wajib login
Route::middleware('auth')->group(function () {
    
    // Rute Kiosk (Satpam)
    Route::get('/kiosk', [KioskController::class, 'index'])->name('kiosk');
    Route::post('/kiosk/ambil-antrean', [KioskController::class, 'store'])->name('kiosk.store');


});