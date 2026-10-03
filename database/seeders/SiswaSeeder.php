<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = [
            [
                'nisn' => '0071234501',
                'nama_siswa' => 'Muhammad Farhan',
                'jenis_kelamin' => 'Laki-Laki',
                'tahun_masuk' => 2024,
            ],
            [
                'nisn' => '0071234502',
                'nama_siswa' => 'Aisyah Putri Azzahra',
                'jenis_kelamin' => 'Perempuan',
                'tahun_masuk' => 2024,
            ],
            [
                'nisn' => '0071234503',
                'nama_siswa' => 'Rafi Alamsyah',
                'jenis_kelamin' => 'Laki-Laki',
                'tahun_masuk' => 2024,
            ],
            [
                'nisn' => '0071234504',
                'nama_siswa' => 'Nabila Zahra',
                'jenis_kelamin' => 'Perempuan',
                'tahun_masuk' => 2024,
            ],
            [
                'nisn' => '0071234505',
                'nama_siswa' => 'Dimas Aditya Nugraha',
                'jenis_kelamin' => 'Laki-Laki',
                'tahun_masuk' => 2024,
            ],
            [
                'nisn' => '0081234506',
                'nama_siswa' => 'Syifa Nur Anggraeni',
                'jenis_kelamin' => 'Perempuan',
                'tahun_masuk' => 2025,
            ],
            [
                'nisn' => '0081234507',
                'nama_siswa' => 'Fajar Hidayatullah',
                'jenis_kelamin' => 'Laki-Laki',
                'tahun_masuk' => 2025,
            ],
            [
                'nisn' => '0081234508',
                'nama_siswa' => 'Tiara Salma Ramadhani',
                'jenis_kelamin' => 'Perempuan',
                'tahun_masuk' => 2025,
            ],
            [
                'nisn' => '0081234509',
                'nama_siswa' => 'Bagus Tri Pamungkas',
                'jenis_kelamin' => 'Laki-Laki',
                'tahun_masuk' => 2025,
            ],
            [
                'nisn' => '0081234510',
                'nama_siswa' => 'Zahra Anindya',
                'jenis_kelamin' => 'Perempuan',
                'tahun_masuk' => 2025,
            ],
        ];

        foreach ($siswas as $siswa) {
            Siswa::create($siswa);
        }
    }
}
