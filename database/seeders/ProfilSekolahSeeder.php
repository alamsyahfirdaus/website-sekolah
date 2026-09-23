<?php

namespace Database\Seeders;

use App\Models\ProfilSekolah;
use Illuminate\Database\Seeder;

class ProfilSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfilSekolah::create([
            'nama_sekolah' => 'SMK YPC Tasikmalaya',
            'kepala_sekolah' => 'Drs. Ujang Sanusi, M.M.',
            'foto' => 'gedung_sekolah.jpg',
            'logo' => 'logo_sekolah.png',
            'npsn' => '20210890',
            'alamat' => 'Jl. Raya Cintawana No. 1, Singaparna, Kab. Tasikmalaya, Jawa Barat',
            'kontak' => '081234567890',
            'visi_misi' => "Visi:\nMenjadi SMK unggulan yang berkarakter, berdaya saing global, dan berjiwa wirausaha.\n\nMisi:\n1. Menyelenggarakan pembelajaran berkualitas berbasis industri dan teknologi terkini.\n2. Menanamkan nilai religius, integritas, dan disiplin tinggi pada seluruh warga sekolah.\n3. Mengembangkan kemitraan strategis dengan dunia usaha dan industri.",
            'tahun_berdiri' => 2000,
            'deskripsi' => 'SMK YPC Tasikmalaya merupakan sekolah menengah kejuruan terakreditasi A yang berfokus mencetak lulusan kompeten, siap kerja, dan berkarakter unggul.',
        ]);
    }
}
