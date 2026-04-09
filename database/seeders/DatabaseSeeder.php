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
        // 1. Membuat 1 Akun Admin (Untuk kamu gunakan login)
        User::factory()->create([
            'name' => 'Administrator Perpus',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('password123'), // Ingat password ini
            'role' => 'admin',
        ]);

        // 2. Membuat 1 Akun Siswa Spesifik (Untuk uji coba tampilan siswa)
        User::factory()->create([
            'name' => 'Ridwan Siswa',
            'email' => 'siswa@perpus.com',
            'password' => Hash::make('password123'), // Password disamakan agar mudah
            'role' => 'siswa',
        ]);

        // 3. (Opsional) Membuat 5 akun Siswa acak (dummy) untuk meramaikan tabel
        User::factory(5)->create([
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);
    }
}