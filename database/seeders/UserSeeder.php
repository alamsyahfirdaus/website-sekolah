<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        User::create([
            'username' => 'operator',
            'name' => 'Operator Sekolah',
            'email' => 'operator@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'Operator',
        ]);
    }
}
