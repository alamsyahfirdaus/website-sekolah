<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama admin dengan statistik data nyata dari database.
     */
    public function index()
    {
        // 1. Menghitung total data dari masing-masing model
        $totalGuru            = Guru::count();
        $totalSiswa           = Siswa::count();
        $totalBerita          = Berita::count();
        $totalEkstrakurikuler = Ekstrakurikuler::count();
        $totalGaleri          = Galeri::count();

        // 2. Mengambil data profil sekolah
        $profilSekolah = ProfilSekolah::first();

        // 3. Mengambil berita terbaru untuk widget ringkasan
        $beritaTerbaru = Berita::with('user')->latest('tanggal')->take(5)->get();

        return view('admin.dashboard', [
            'title'                => 'Dashboard',
            'totalGuru'            => $totalGuru,
            'totalSiswa'           => $totalSiswa,
            'totalBerita'          => $totalBerita,
            'totalEkstrakurikuler' => $totalEkstrakurikuler,
            'totalGaleri'          => $totalGaleri,
            'profilSekolah'        => $profilSekolah,
            'beritaTerbaru'        => $beritaTerbaru,
        ]);
    }

    /**
     * Dashboard untuk landing page publik.
     */
    public function publicDashboard()
    {
        $profilSekolah = ProfilSekolah::first();

        return view('public.home', [
            'title'         => 'Beranda Website Sekolah',
            'profilSekolah' => $profilSekolah,
        ]);
    }
}
