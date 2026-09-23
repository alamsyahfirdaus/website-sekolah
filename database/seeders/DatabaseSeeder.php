<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProfilSekolahSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
            GaleriSeeder::class,
            BeritaSeeder::class,
            EkstrakurikulerSeeder::class,
        ]);
    }
}
