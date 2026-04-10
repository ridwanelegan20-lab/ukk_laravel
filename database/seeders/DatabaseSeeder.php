<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat 1 Akun Admin (Tanpa menggunakan Factory/Faker)
        User::create([
            'name' => 'Administrator Perpus',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('password123'), 
            'role' => 'admin',
        ]);

        // 2. Membuat 1 Akun Siswa Spesifik
        User::create([
            'name' => 'Ridwan Siswa',
            'email' => 'siswa@perpus.com',
            'password' => Hash::make('password123'), 
            'role' => 'siswa',
        ]);
        
        // Pembuatan 5 akun acak dihapus agar tidak memicu error Faker di server
    }
}