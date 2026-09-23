<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = [
            [
                'nama_guru' => 'Ahmad Fauzi, S.Kom.',
                'nip' => '198501152010011',
                'mapel' => 'Informatika',
                'foto' => 'guru_ahmad.jpg',
            ],
            [
                'nama_guru' => 'Siti Rahmawati, S.Pd.',
                'nip' => '198803202012022',
                'mapel' => 'Bahasa Indonesia',
                'foto' => 'guru_siti.jpg',
            ],
            [
                'nama_guru' => 'Budi Santoso, M.Pd.',
                'nip' => '198207102008011',
                'mapel' => 'Matematika',
                'foto' => 'guru_budi.jpg',
            ],
            [
                'nama_guru' => 'Dewi Lestari, S.Pd.',
                'nip' => '199011052014022',
                'mapel' => 'Bahasa Inggris',
                'foto' => 'guru_dewi.jpg',
            ],
            [
                'nama_guru' => 'Rizki Pratama, M.Kom.',
                'nip' => '199205122016011',
                'mapel' => 'Produktif PPLG',
                'foto' => 'guru_rizki.jpg',
            ],
            [
                'nama_guru' => 'Endang Maryani, S.Pd.',
                'nip' => '198709182011022',
                'mapel' => 'Seni Budaya',
                'foto' => 'guru_endang.jpg',
            ],
        ];

        foreach ($gurus as $guru) {
            Guru::create($guru);
        }
    }
}
