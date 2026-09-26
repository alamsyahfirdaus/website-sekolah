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

// LANDING PAGE
Route::get('/', [DashboardController::class, 'publicDashboard'])->name('public.dashboard');
// Route::get('berita', [BeritaController::class, 'publicIndex'])->name('public.berita');
// Route::get('ekstrakurikuler', [EkstrakurikulerController::class, 'publicIndex'])->name('public.ekstrakurikuler');
// Route::get('galeri', [GaleriController::class, 'publicIndex'])->name('public.galeri');
// Route::get('guru', [GuruController::class, 'publicIndex'])->name('public.guru');
// Route::get('siswa', [SiswaController::class, 'publicIndex'])->name('public.siswa');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('/login-proses', [AuthController::class, 'processLogin'])->name('proses.login');
});

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Profil Sekolah (Hanya Tampil & Update)
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfilSekolahController::class, 'index'])->name('admin.profil');
        Route::get('/{id}/edit', [ProfilSekolahController::class, 'edit'])->name('profil.edit');
        Route::put('/{id}/update', [ProfilSekolahController::class, 'update'])->name('profil.update');
    });

    // Modul Guru
    Route::prefix('guru')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('admin.guru');
        Route::get('/create', [GuruController::class, 'create'])->name('guru.create');
        Route::post('/store', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/{id}', [GuruController::class, 'show'])->name('guru.show');
        Route::get('/{id}/edit', [GuruController::class, 'edit'])->name('guru.edit');
        Route::put('/{id}', [GuruController::class, 'update'])->name('guru.update');
        Route::delete('/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');
    });

    // Modul Siswa
    Route::prefix('siswa')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('admin.siswa');
        Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('/store', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/{id}', [SiswaController::class, 'show'])->name('siswa.show');
        Route::get('/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('/{id}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    });

    // Modul Berita
    Route::prefix('berita')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('admin.berita');
        Route::get('/create', [BeritaController::class, 'create'])->name('berita.create');
        Route::post('/store', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('/{id}', [BeritaController::class, 'show'])->name('berita.show');
        Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/{id}', [BeritaController::class, 'update'])->name('berita.update');
        Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    });

    // Modul Ekstrakurikuler
    Route::prefix('ekstrakurikuler')->group(function () {
        Route::get('/', [EkstrakurikulerController::class, 'index'])->name('admin.ekstrakurikuler');
        Route::get('/create', [EkstrakurikulerController::class, 'create'])->name('ekstrakurikuler.create');
        Route::post('/store', [EkstrakurikulerController::class, 'store'])->name('ekstrakurikuler.store');
        Route::get('/{id}', [EkstrakurikulerController::class, 'show'])->name('ekstrakurikuler.show');
        Route::get('/{id}/edit', [EkstrakurikulerController::class, 'edit'])->name('ekstrakurikuler.edit');
        Route::put('/{id}', [EkstrakurikulerController::class, 'update'])->name('ekstrakurikuler.update');
        Route::delete('/{id}', [EkstrakurikulerController::class, 'destroy'])->name('ekstrakurikuler.destroy');
    });

    // Modul Galeri
    Route::prefix('galeri')->group(function () {
        Route::get('/', [GaleriController::class, 'index'])->name('admin.galeri');
        Route::get('/create', [GaleriController::class, 'create'])->name('galeri.create');
        Route::post('/store', [GaleriController::class, 'store'])->name('galeri.store');
        Route::get('/{id}', [GaleriController::class, 'show'])->name('galeri.show');
        Route::get('/{id}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
        Route::put('/{id}', [GaleriController::class, 'update'])->name('galeri.update');
        Route::delete('/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
    });
});

