<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use App\Models\Guru;
use Illuminate\Database\Seeder;

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = Guru::all();

        $g1 = $gurus->skip(0)->first();
        $g2 = $gurus->skip(1)->first() ?? $g1;
        $g3 = $gurus->skip(2)->first() ?? $g1;
        $g4 = $gurus->skip(3)->first() ?? $g1;
        $g5 = $gurus->skip(4)->first() ?? $g1;

        $ekskuls = [
            [
                'nama_ekskul' => 'Pramuka',
                'id_guru' => $g3->id,
                'jadwal_latihan' => 'Jumat, 15.00 - 17.00 WIB',
                'deskripsi' => 'Ekstrakurikuler wajib yang melatih kedisiplinan, kepemimpinan, kemandirian, dan kecintaan pada alam.',
                'gambar' => 'ekskul_pramuka.jpg',
            ],
            [
                'nama_ekskul' => 'Futsal',
                'id_guru' => $g1->id,
                'jadwal_latihan' => 'Selasa & Kamis, 16.00 - 18.00 WIB',
                'deskripsi' => 'Wadah pembinaan bakat olahraga sepak bola mini untuk meningkatkan kebugaran jasmani dan sportivitas tim.',
                'gambar' => 'ekskul_futsal.jpg',
            ],
            [
                'nama_ekskul' => 'Paskibra',
                'id_guru' => $g4->id,
                'jadwal_latihan' => 'Rabu & Sabtu, 15.30 - 17.30 WIB',
                'deskripsi' => 'Membina baris-berbaris, ketahanan fisik, serta penyiapan petugas pengibar bendera upacara resmi sekolah.',
                'gambar' => 'ekskul_paskibra.jpg',
            ],
            [
                'nama_ekskul' => 'Palang Merah Remaja (PMR)',
                'id_guru' => $g2->id,
                'jadwal_latihan' => 'Senin, 15.30 - 17.00 WIB',
                'deskripsi' => 'Melatih keterampilan pertolongan pertama pada kecelakaan (P3K), kesiapsiagaan bencana, dan kepedulian sosial kemanusiaan.',
                'gambar' => 'ekskul_pmr.jpg',
            ],
            [
                'nama_ekskul' => 'Seni Musik dan Tari',
                'id_guru' => $g5->id,
                'jadwal_latihan' => 'Sabtu, 09.00 - 12.00 WIB',
                'deskripsi' => 'Eksplorasi bakat seni tradisi maupun modern, mencakup seni gamelan/karawitan, tari daerah, dan vokal grup.',
                'gambar' => 'ekskul_seni.jpg',
            ],
        ];

        foreach ($ekskuls as $ekskul) {
            Ekstrakurikuler::create($ekskul);
        }
    }
}
