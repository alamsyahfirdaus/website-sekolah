<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'indexPublic'])->name('public.dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('/login-proses', [AuthController::class, 'processLogin'])->name('proses.login');
});


Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/profil', [ProfilSekolahController::class, 'index'])->name('admin.profil');
    Route::get('/berita', [BeritaController::class, 'index'])->name('admin.berita');
    Route::get('/ekstakurikuler', [EkstrakurikulerController::class, 'index'])->name('admin.ekstakurikuler');
    Route::get('/galeri', [GaleriController::class, 'index'])->name('admin.galeri');
    Route::get('/guru', [GuruController::class, 'index'])->name('admin.guru');
    Route::get('/siswa', [SiswaController::class, 'index'])->name('admin.siswa');
});
