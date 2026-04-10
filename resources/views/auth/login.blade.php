<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Perpustakaan Digital</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="h-screen w-screen overflow-hidden relative flex flex-col items-center justify-center bg-cover bg-center text-gray-800" 
      style="background-image: url('{{ asset('images/bg-library.jpg') }}');">
    
    <div class="absolute inset-0 bg-black/50 backdrop-blur-[2px] z-0"></div>

    <div class="relative z-10 flex flex-col items-center mb-3 sm:mb-5">
        <div class="flex items-center gap-2">
            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
            </svg>
            <h1 class="text-xl sm:text-2xl font-bold text-white tracking-widest drop-shadow-md">PERPUSTAKAAN</h1>
        </div>
    </div>

    <div class="relative z-10 w-[92%] max-w-[400px] bg-white/95 backdrop-blur-xl border border-white/40 rounded-3xl shadow-2xl overflow-hidden px-5 py-5 sm:px-8 sm:py-6 flex flex-col">
        
        <div class="text-center mb-4 sm:mb-5">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900">Selamat Datang</h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Silakan masuk untuk melanjutkan</p>
        </div>
        
        <x-auth-session-status class="mb-3" :status="session('status')" />
        
        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-3 sm:gap-4">
            @csrf

            <div>
                <label for="email" class="block font-semibold text-[11px] sm:text-xs text-gray-600 mb-1">Email atau Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <input id="email" class="block w-full pl-9 py-2 sm:py-2.5 text-sm bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 rounded-xl transition-all" type="email" name="email" :value="old('email')" required autofocus placeholder="Masukkan email anda" autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-[10px]" />
            </div>

            <div>
                <label for="password" class="block font-semibold text-[11px] sm:text-xs text-gray-600 mb-1">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                    </div>
                    <input id="password" class="block w-full pl-9 py-2 sm:py-2.5 text-sm bg-gray-50/50 border border-gray-200 focus:bg-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 rounded-xl transition-all" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-[10px]" />
            </div>

            <div class="mt-1">
                <div class="flex justify-end mb-3">
                    @if (Route::has('password.request'))
                        <a class="text-[11px] sm:text-xs font-medium text-orange-600 hover:text-orange-700 transition" href="{{ route('password.request') }}">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>
                
                <button type="submit" class="w-full flex justify-center py-2.5 sm:py-3 px-4 rounded-xl text-white bg-gradient-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 font-bold text-sm sm:text-base shadow-lg shadow-orange-500/30 transform transition hover:-translate-y-0.5">
                    MASUK
                </button>
            </div>
        </form>

        <div class="mt-4 sm:mt-5 relative flex items-center justify-center">
            <div class="w-full border-t border-gray-200 absolute"></div>
            <span class="px-3 bg-white text-[10px] sm:text-xs text-gray-400 font-medium relative z-10">Atau masuk dengan</span>
        </div>

        <div class="mt-4 sm:mt-5 flex gap-2 sm:gap-3">
            <a href="{{ route('social.redirect', 'facebook') }}" class="flex-1 flex items-center justify-center py-2 rounded-xl text-white bg-[#1877F2] hover:bg-[#166FE5] text-xs sm:text-sm font-semibold shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                Facebook
            </a>
            
            <a href="{{ route('social.redirect', 'google') }}" class="flex-1 flex items-center justify-center py-2 rounded-xl text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 text-xs sm:text-sm font-semibold shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/><path fill="none" d="M1 1h22v22H1z"/></svg>
                Google
            </a>
        </div>
        
    </div>

    <div class="relative z-10 mt-4 text-center">
        <p class="text-xs sm:text-sm text-gray-200">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-white hover:text-orange-400 transition underline decoration-2 underline-offset-4">
                Daftar disini
            </a>
        </p>
    </div>

</body>
</html>