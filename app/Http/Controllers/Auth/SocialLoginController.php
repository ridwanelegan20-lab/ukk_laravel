<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialLoginController extends Controller
{
    // Mengarahkan user ke halaman login Google/Facebook
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Menangani kembalian data dari Google/Facebook
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Cari user berdasarkan email, atau buat baru jika belum ada
            $user = User::updateOrCreate([
                'email' => $socialUser->getEmail(),
            ], [
                'name' => $socialUser->getName(),
                $provider . '_id' => $socialUser->getId(),
                'role' => 'siswa', // Otomatis jadikan sebagai siswa
            ]);

            // Login-kan user tersebut
            Auth::login($user);

            return redirect()->route('dashboard');

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Login dengan ' . ucfirst($provider) . ' gagal. Silakan coba lagi.');
        }
    }
}
