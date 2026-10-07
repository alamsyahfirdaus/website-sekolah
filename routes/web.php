<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// LANDING PAGE PUBLIK
Route::get('/', [DashboardController::class, 'publicDashboard'])->name('public.dashboard');
Route::get('/profile', [ProfilSekolahController::class, 'publicProfil'])->name('public.profile');
Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'publicEkstrakurikuler'])->name('public.ekstrakurikuler');
Route::get('/guru', [GuruController::class, 'publicGuru'])->name('public.guru');
Route::get('/siswa', [SiswaController::class, 'publicSiswa'])->name('public.siswa');
Route::get('/berita', [BeritaController::class, 'publicBerita'])->name('public.berita');
Route::get('/galeri', [GaleriController::class, 'publicGaleri'])->name('public.galeri');

// AUTENTIKASI (HANYA BISA DIAKSES JIKA BELUM LOGIN)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('/login-proses', [AuthController::class, 'processLogin'])->name('proses.login');
    Route::get('/login', [AuthController::class, 'index'])->name('login');
});

// LOGOUT
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// ROUTE GROUP ADMIN (WAJIB LOGIN / AUTH MIDDLEWARE)
// =========================================================================
Route::middleware('auth')->prefix('admin')->group(function () {

    // ---------------------------------------------------------------------
    // A. FITUR BERSAMA (DAPAT DIAKSES OLEH ADMIN & OPERATOR)
    // ---------------------------------------------------------------------

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 2. Profil Sekolah (Hanya Tampil & Ubah)
    Route::get('/profil-sekolah', [ProfilSekolahController::class, 'index'])->name('admin.profil-sekolah');
    Route::post('/profil-sekolah/save', [ProfilSekolahController::class, 'save'])->name('admin.profil-sekolah.save');
    Route::get('/profil', [ProfilSekolahController::class, 'index'])->name('admin.profil');

    // 3. Kelola Berita
    Route::prefix('berita')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('admin.berita.index');
        Route::get('/add-edit/{id?}', [BeritaController::class, 'addEdit'])->name('admin.berita.addEdit');
        Route::post('/save/{id?}', [BeritaController::class, 'save'])->name('admin.berita.save');
        Route::get('/{id}', [BeritaController::class, 'show'])->name('admin.berita.show');
        Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('admin.berita.delete');
    });

    // 4. Kelola Ekstrakurikuler
    Route::prefix('ekstrakurikuler')->group(function () {
        Route::get('/', [EkstrakurikulerController::class, 'index'])->name('admin.ekstrakurikuler.index');
        Route::get('/add-edit/{id?}', [EkstrakurikulerController::class, 'addEdit'])->name('admin.ekstrakurikuler.addEdit');
        Route::post('/save/{id?}', [EkstrakurikulerController::class, 'save'])->name('admin.ekstrakurikuler.save');
        Route::get('/{id}', [EkstrakurikulerController::class, 'show'])->name('admin.ekstrakurikuler.show');
        Route::delete('/{id}', [EkstrakurikulerController::class, 'destroy'])->name('admin.ekstrakurikuler.delete');
    });

    // 5. Kelola Galeri
    Route::prefix('galeri')->group(function () {
        Route::get('/', [GaleriController::class, 'index'])->name('admin.galeri.index');
        Route::get('/add-edit/{id?}', [GaleriController::class, 'addEdit'])->name('admin.galeri.addEdit');
        Route::post('/save/{id?}', [GaleriController::class, 'save'])->name('admin.galeri.save');
        Route::get('/{id}', [GaleriController::class, 'show'])->name('admin.galeri.show');
        Route::delete('/{id}', [GaleriController::class, 'destroy'])->name('admin.galeri.delete');
    });

    // ---------------------------------------------------------------------
    // B. FITUR KHUSUS ADMIN (DILINDUNGI MIDDLEWARE role:admin)
    // Operator DILARANG mengelola: Guru, Siswa, dan User (Otomatis 403)
    // ---------------------------------------------------------------------
    Route::middleware('role:admin')->group(function () {

        // 6. Kelola Guru
        Route::prefix('guru')->group(function () {
            Route::get('/', [GuruController::class, 'index'])->name('admin.guru.index');
            Route::get('/add-edit/{id?}', [GuruController::class, 'addEdit'])->name('admin.guru.addEdit');
            Route::post('/save/{id?}', [GuruController::class, 'save'])->name('admin.guru.save');
            Route::get('/{id}', [GuruController::class, 'show'])->name('admin.guru.show');
            Route::delete('/{id}', [GuruController::class, 'destroy'])->name('admin.guru.delete');
        });

        // 7. Kelola Siswa
        Route::prefix('siswa')->group(function () {
            Route::get('/', [SiswaController::class, 'index'])->name('admin.siswa.index');
            Route::get('/add-edit/{id?}', [SiswaController::class, 'addEdit'])->name('admin.siswa.addEdit');
            Route::post('/save/{id?}', [SiswaController::class, 'save'])->name('admin.siswa.save');
            Route::get('/{id}', [SiswaController::class, 'show'])->name('admin.siswa.show');
            Route::delete('/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.delete');
        });

        // 8. Kelola User
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/add-edit/{id?}', [UserController::class, 'addEdit'])->name('admin.user.addEdit');
            Route::post('/save/{id?}', [UserController::class, 'save'])->name('admin.user.save');
            Route::get('/{id}', [UserController::class, 'show'])->name('admin.user.show');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');
        });
    });
});
