<?php

namespace Database\Seeders;

use App\Models\Galeri;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galeris = [
            [
                'judul' => 'Upacara Hari Kemerdekaan RI Ke-79',
                'keterangan' => 'Dokumentasi pelaksanaan upacara peringatan HUT RI ke-79 di lapangan utama sekolah.',
                'file' => 'upacara_hut_ri_79.jpg',
                'kategori' => 'Foto',
                'tanggal' => '2024-08-17',
            ],
            [
                'judul' => 'Highlights Turnamen Futsal Antar Kelas',
                'keterangan' => 'Video cuplikan aksi seru pertandingan final turnamen futsal tahunan.',
                'file' => 'futsal_cup_final.mp4',
                'kategori' => 'Video',
                'tanggal' => '2024-09-10',
            ],
            [
                'judul' => 'Kunjungan Industri Jurusan PPLG',
                'keterangan' => 'Siswa jurusan PPLG melakukan kunjungan studi industri ke software house.',
                'file' => 'kunjungan_industri_pplg.jpg',
                'kategori' => 'Foto',
                'tanggal' => '2024-10-05',
            ],
            [
                'judul' => 'Video Profil SMK YPC Tasikmalaya',
                'keterangan' => 'Video profil fasilitas modern dan lingkungan belajar sekolah.',
                'file' => 'video_profil_sekolah.mp4',
                'kategori' => 'Video',
                'tanggal' => '2024-10-20',
            ],
            [
                'judul' => 'Pelantikan Pengurus OSIS & MPK',
                'keterangan' => 'Kegiatan serah terima jabatan dan ikrar pengurus OSIS periode baru.',
                'file' => 'pelantikan_osis.jpg',
                'kategori' => 'Foto',
                'tanggal' => '2024-11-12',
            ],
            [
                'judul' => 'Pentas Seni dan Budaya Sunda',
                'keterangan' => 'Penampilan tari kreasi tradisional dan arumba oleh ekstrakurikuler seni.',
                'file' => 'pentas_seni_budaya.jpg',
                'kategori' => 'Foto',
                'tanggal' => '2024-12-15',
            ],
            [
                'judul' => 'Dokumentasi Latihan Kepemimpinan Siswa',
                'keterangan' => 'Video rangkuman kegiatan LDKS pembentukan karakter siswa berintegritas.',
                'file' => 'ldks_karakter_siswa.mp4',
                'kategori' => 'Video',
                'tanggal' => '2025-01-22',
            ],
            [
                'judul' => 'Workshop Pemrograman Web Modern',
                'keterangan' => 'Pelatihan intensif pembuatan website portfolio interaktif bersama praktisi industri.',
                'file' => 'workshop_web_modern.jpg',
                'kategori' => 'Foto',
                'tanggal' => '2025-02-14',
            ],
        ];

        foreach ($galeris as $galeri) {
            Galeri::create($galeri);
        }
    }
}
