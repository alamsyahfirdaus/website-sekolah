<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'Admin')->first() ?? User::first();
        $operator = User::where('role', 'Operator')->first() ?? $admin;

        $beritas = [
            [
                'judul' => 'Penerimaan Peserta Didik Baru Telah Dibuka',
                'isi' => 'SMK YPC Tasikmalaya resmi membuka pendaftaran peserta didik baru (PPDB) tahun ajaran baru. Calon siswa dapat mendaftar langsung secara online melalui portal sekolah atau datang ke sekretariat panitia PPDB di kampus sekolah.',
                'tanggal' => '2025-01-10',
                'gambar' => 'ppdb_pembukaan.jpg',
                'id_user' => $admin->id,
            ],
            [
                'judul' => 'Siswa PPLG Raih Juara 1 LKS Tingkat Provinsi',
                'isi' => 'Kabar membanggakan datang dari bidang keahlian PPLG. Perwakilan siswa SMK YPC berhasil meraih predikat Juara 1 dalam ajang Lomba Kompetensi Siswa (LKS) kategori Web Technologies dan akan mewakili ke tingkat nasional.',
                'tanggal' => '2025-01-25',
                'gambar' => 'lks_juara_satu.jpg',
                'id_user' => $operator->id,
            ],
            [
                'judul' => 'Sosialisasi Bahaya Narkoba Bersama Polsek',
                'isi' => 'Guna membentengi generasi muda dari bahaya penyalahgunaan obat terlarang, sekolah bekerjasama dengan kepolisian setempat menyelenggarakan sosialisasi bahaya narkoba dan tertib berlalu lintas untuk seluruh siswa kelas X.',
                'tanggal' => '2025-02-05',
                'gambar' => 'sosialisasi_polsek.jpg',
                'id_user' => $admin->id,
            ],
            [
                'judul' => 'Ujian Akhir Semester Berbasis Digital Dimulai',
                'isi' => 'Pelaksanaan Penilaian Akhir Semester (PAS) semester ganjil berlangsung tertib menggunakan aplikasi ujian berbasis daring di laboratorium komputer dan perangkat masing-masing siswa yang terhubung jaringan lokal aman.',
                'tanggal' => '2025-02-18',
                'gambar' => 'ujian_cbt_digital.jpg',
                'id_user' => $operator->id,
            ],
            [
                'judul' => 'Peringatan Hari Guru Nasional di SMK YPC',
                'isi' => 'Upacara khidmat dan penampilan persembahan puisi dari OSIS mewarnai peringatan Hari Guru Nasional. Acara ditutup dengan pemberian apresiasi kepada bapak dan ibu guru berprestasi serta ramah tamah keluarga besar sekolah.',
                'tanggal' => '2025-02-28',
                'gambar' => null,
                'id_user' => $admin->id,
            ],
        ];

        foreach ($beritas as $berita) {
            Berita::create($berita);
        }
    }
}
