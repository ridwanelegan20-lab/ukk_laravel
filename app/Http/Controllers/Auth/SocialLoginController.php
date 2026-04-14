<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SocialLoginController extends Controller
{
    // Mengarahkan user ke halaman login Google/Facebook
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Menangkap data setelah user berhasil login dari Google/Facebook
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Cek apakah email user sudah terdaftar di database kita
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                // Jika belum pernah daftar, buatkan akun otomatis sebagai "siswa"
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(24)), // Buatkan password acak yang kuat
                    'role' => 'siswa', // Jadikan siswa secara default
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            } else {
                // Jika email sudah ada, cukup update data provider-nya
                $user->update([
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            }

            // Login-kan user ke dalam sistem
            Auth::login($user);
            
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            \Log::error('Social Login Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Login menggunakan ' . ucfirst($provider) . ' gagal. Silakan coba lagi.');
        }
    }
}