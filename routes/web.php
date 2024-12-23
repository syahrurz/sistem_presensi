<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

// Halaman login hanya dapat diakses oleh user yang belum login (guest)
Route::middleware(['guest'])->group(function () {
    // Halaman login
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    // Proses login
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

// Halaman setelah login, hanya bisa diakses oleh user yang sudah login (auth)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Proses logout
    Route::post('/proseslogout', [AuthController::class, 'proseslogout'])->name('proseslogout');

    // Presensi
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    // Izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);

    // Histori Presensi
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);
});
