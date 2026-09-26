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

// LANDING PAGE PUBLIK
Route::get('/', [DashboardController::class, 'publicDashboard'])->name('public.dashboard');

// AUTENTIKASI (HANYA BISA DIAKSES JIKA BELUM LOGIN)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::get('/admin/login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('/login-proses', [AuthController::class, 'processLogin'])->name('proses.login');
});

// LOGOUT
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// ROUTE GROUP ADMIN (WAJIB LOGIN / AUTH MIDDLEWARE)
// =========================================================================
Route::middleware('auth')->prefix('admin')->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 2. Profil Sekolah (Hanya Tampil & Ubah)
    Route::get('/profil-sekolah', [ProfilSekolahController::class, 'index'])->name('admin.profil-sekolah');
    Route::post('/profil-sekolah/save', [ProfilSekolahController::class, 'save'])->name('admin.profil-sekolah.save');
    Route::get('/profil', [ProfilSekolahController::class, 'index'])->name('admin.profil');

    // 3. Kelola Guru
    Route::prefix('guru')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('admin.guru.index');
        Route::get('/create', [GuruController::class, 'create'])->name('admin.guru.create');
        Route::get('/{id}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
        Route::post('/save/{id?}', [GuruController::class, 'save'])->name('admin.guru.save');
        Route::get('/{id}', [GuruController::class, 'show'])->name('admin.guru.show');
        Route::delete('/{id}', [GuruController::class, 'destroy'])->name('admin.guru.delete');
    });

    // 4. Kelola Siswa
    Route::prefix('siswa')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('admin.siswa.index');
        Route::get('/create', [SiswaController::class, 'create'])->name('admin.siswa.create');
        Route::get('/{id}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
        Route::post('/save/{id?}', [SiswaController::class, 'save'])->name('admin.siswa.save');
        Route::get('/{id}', [SiswaController::class, 'show'])->name('admin.siswa.show');
        Route::delete('/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.delete');
    });

    // 5. Kelola Berita
    Route::prefix('berita')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('admin.berita.index');
        Route::get('/create', [BeritaController::class, 'create'])->name('admin.berita.create');
        Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('admin.berita.edit');
        Route::post('/save/{id?}', [BeritaController::class, 'save'])->name('admin.berita.save');
        Route::get('/{id}', [BeritaController::class, 'show'])->name('admin.berita.show');
        Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('admin.berita.delete');
    });

    // 6. Kelola Ekstrakurikuler
    Route::prefix('ekstrakurikuler')->group(function () {
        Route::get('/', [EkstrakurikulerController::class, 'index'])->name('admin.ekstrakurikuler.index');
        Route::get('/create', [EkstrakurikulerController::class, 'create'])->name('admin.ekstrakurikuler.create');
        Route::get('/{id}/edit', [EkstrakurikulerController::class, 'edit'])->name('admin.ekstrakurikuler.edit');
        Route::post('/save/{id?}', [EkstrakurikulerController::class, 'save'])->name('admin.ekstrakurikuler.save');
        Route::get('/{id}', [EkstrakurikulerController::class, 'show'])->name('admin.ekstrakurikuler.show');
        Route::delete('/{id}', [EkstrakurikulerController::class, 'destroy'])->name('admin.ekstrakurikuler.delete');
    });

    // 7. Kelola Galeri
    Route::prefix('galeri')->group(function () {
        Route::get('/', [GaleriController::class, 'index'])->name('admin.galeri.index');
        Route::get('/create', [GaleriController::class, 'create'])->name('admin.galeri.create');
        Route::get('/{id}/edit', [GaleriController::class, 'edit'])->name('admin.galeri.edit');
        Route::post('/save/{id?}', [GaleriController::class, 'save'])->name('admin.galeri.save');
        Route::get('/{id}', [GaleriController::class, 'show'])->name('admin.galeri.show');
        Route::delete('/{id}', [GaleriController::class, 'destroy'])->name('admin.galeri.delete');
    });
});
