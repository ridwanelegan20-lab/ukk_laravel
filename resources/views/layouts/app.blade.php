<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perpustakaan') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 overflow-hidden" style="font-family: 'Poppins', sans-serif;">
    
    <div class="flex h-screen bg-gray-50 w-full">

        <aside class="hidden md:flex flex-col w-[260px] bg-[#17336b] text-white flex-shrink-0 shadow-xl z-20">
            <div class="flex items-center gap-3 px-6 h-20 border-b border-white/10">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h1 class="text-sm font-bold tracking-widest leading-tight">PERPUSTAKAAN</h1>
                    <p class="text-[9px] text-blue-200 uppercase tracking-widest">Sistem Manajemen</p>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <p class="px-3 text-[10px] font-semibold text-blue-300/70 uppercase mb-3 tracking-wider">Menu</p>

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#2563eb] text-white shadow-md' : 'text-blue-100 hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-[#2563eb] text-white shadow-md' : 'text-blue-100 hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="text-sm font-medium">Kelola Buku</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-[#2563eb] text-white shadow-md' : 'text-blue-100 hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <span class="text-sm font-medium">Kategori Buku</span>
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.members.*') ? 'bg-[#2563eb] text-white shadow-md' : 'text-blue-100 hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-sm font-medium">Kelola Anggota</span>
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-[#2563eb] text-white shadow-md' : 'text-blue-100 hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm font-medium">Riwayat Transaksi</span>
                    </a>

                @else
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#2563eb] text-white shadow-md' : 'text-blue-100 hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-sm font-medium">Dashboard Utama</span>
                    </a>
                    <a href="{{ url('/katalog') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->is('katalog') ? 'bg-[#2563eb] text-white shadow-md' : 'text-blue-100 hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="text-sm font-medium">Katalog Buku</span>
                    </a>
                    <a href="{{ url('/riwayat-saya') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->is('riwayat-saya') ? 'bg-[#2563eb] text-white shadow-md' : 'text-blue-100 hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm font-medium">Riwayat Pinjaman</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-[#2563eb] text-white shadow-md' : 'text-blue-100 hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-sm font-medium">Profil Siswa</span>
                    </a>
                @endif
            </nav>

            <div class="px-4 mb-4">
                <div class="bg-gradient-to-b from-blue-600/30 to-blue-800/30 rounded-2xl p-4 border border-blue-500/20 text-center backdrop-blur-sm relative overflow-hidden">
                    <div class="flex justify-center mb-3">
                        <svg class="w-10 h-10 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/></svg>
                    </div>
                    <p class="text-[11px] text-blue-100/90 leading-relaxed">Membaca adalah jendela dunia. Selamat mengelola perpustakaan.</p>
                </div>
            </div>

            <div class="border-t border-white/10 p-4 bg-black/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-800 font-bold shadow-md">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-blue-300 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-blue-300 hover:text-white transition-colors p-1" title="Log Out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50/50">
            
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 shadow-sm/50">
                
                <div class="hidden sm:block">
                    <h2 class="text-lg font-bold text-gray-800">Halo, {{ Auth::user()->name }}</h2>
                    <p class="text-xs text-gray-500">Semoga harimu menyenangkan!</p>
                </div>

                <div class="flex items-center gap-4 sm:gap-6 ml-auto">
                    
                    <form method="GET" action="{{ Auth::user()->role === 'admin' ? route('admin.books.index') : url('/katalog') }}" class="hidden md:block relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-full text-sm bg-gray-50 focus:bg-white focus:ring-[#2563eb] focus:border-[#2563eb] w-56 lg:w-72 transition-all outline-none">
                        <button type="submit" class="hidden"></button>
                    </form>

                    @php
                        $notifCount = 0;
                        $recentNotifs = collect();

                        if(Auth::check()) {
                            if(Auth::user()->role === 'admin') {
                                // ADMIN: Munculkan yang butuh ACC & Terlambat
                                $recentNotifs = \App\Models\Transaction::with(['user', 'book'])
                                    ->whereIn('status', ['menunggu', 'menunggu_pengembalian'])
                                    ->orWhere(function($query) {
                                        $query->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])
                                              ->whereDate('return_date', '<', \Carbon\Carbon::today());
                                    })
                                    ->latest()->take(5)->get();
                                $notifCount = $recentNotifs->count();
                            } else {
                                // SISWA: Munculkan 5 aktivitas terakhir apapun statusnya
                                $recentNotifs = \App\Models\Transaction::with('book')
                                    ->where('user_id', Auth::id())
                                    ->latest()->take(5)->get();
                                
                                // TITIK MERAH SISWA: Hanya nyala jika Ditolak atau Terlambat
                                $notifCount = \App\Models\Transaction::where('user_id', Auth::id())
                                    ->where(function($query) {
                                        $query->where('status', 'ditolak')
                                              ->orWhere(function($q) {
                                                  $q->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])
                                                    ->whereDate('return_date', '<', \Carbon\Carbon::today());
                                              });
                                    })
                                    ->count();
                            }
                        }
                    @endphp

                    <div class="relative flex items-center" x-data="{ openNotif: false }" @click.outside="openNotif = false">
                        <button @click="openNotif = !openNotif" class="relative p-2 text-gray-400 hover:text-blue-600 focus:outline-none transition-transform hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            
                            @if($notifCount > 0)
                                <span class="absolute top-1 right-1.5 flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                                </span>
                            @endif
                        </button>

                        <div x-show="openNotif"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             class="absolute right-0 top-12 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden"
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/80 flex justify-between items-center">
                                <p class="text-sm font-bold text-gray-900">Notifikasi</p>
                                @if($notifCount > 0)
                                    <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-md">{{ $notifCount }} Perlu Perhatian</span>
                                @endif
                            </div>

                            <div class="max-h-[320px] overflow-y-auto">
                                @forelse($recentNotifs as $notif)
                                    @php
                                        $isOverdue = in_array($notif->status, ['dipinjam', 'menunggu_pengembalian']) && \Carbon\Carbon::parse($notif->return_date)->isPast();
                                    @endphp
                                    <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors {{ $isOverdue || $notif->status == 'ditolak' ? 'bg-red-50/40' : 'bg-blue-50/20' }}">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-0.5 w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ $notif->status == 'ditolak' || $isOverdue ? 'bg-red-100 text-red-500' : 'bg-blue-100 text-blue-500' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                            </div>
                                            <div>
                                                @if(Auth::user()->role === 'admin')
                                                    <p class="text-sm text-gray-800 leading-snug">
                                                        <span class="font-bold">{{ $notif->user->name }}</span> 
                                                        @if($notif->status === 'menunggu') mengajukan pinjaman
                                                        @elseif($notif->status === 'menunggu_pengembalian') ingin menyerahkan
                                                        @elseif($isOverdue) <span class="text-red-600">terlambat kembalikan</span>
                                                        @endif
                                                        <span class="font-medium text-[#1e4ed8]">"{{ $notif->book->title }}"</span>
                                                    </p>
                                                @else
                                                    <p class="text-sm text-gray-800 leading-snug">
                                                        @if($notif->status === 'menunggu')
                                                            <span class="text-yellow-600 font-medium">Menunggu ACC:</span>
                                                        @elseif($notif->status === 'dipinjam' && !$isOverdue)
                                                            <span class="text-blue-600 font-medium">Sedang dipinjam:</span>
                                                        @elseif($notif->status === 'menunggu_pengembalian')
                                                            <span class="text-purple-600 font-medium">Menyerahkan:</span>
                                                        @elseif($notif->status === 'dikembalikan')
                                                            <span class="text-green-600 font-medium">Selesai:</span>
                                                        @elseif($notif->status === 'ditolak')
                                                            <span class="text-red-600 font-medium">Ditolak:</span>
                                                        @elseif($isOverdue)
                                                            <span class="text-red-600 font-bold">Terlambat:</span>
                                                        @endif
                                                        "{{ $notif->book->title }}"
                                                    </p>
                                                @endif
                                                <div class="flex items-center gap-2 mt-1">
                                                    <p class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-4 py-8 text-center flex flex-col items-center">
                                        <p class="text-sm text-gray-500 font-medium">Belum ada aktivitas terbaru.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="h-8 w-px bg-gray-200"></div>

                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none transition-transform hover:scale-105">
                            <div class="w-9 h-9 rounded-full bg-[#2563eb] flex items-center justify-center text-white font-bold shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-bold text-gray-700 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 hidden sm:block transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl py-2 border border-gray-100 z-50"
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50 mb-1">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 text-left px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f8fafc]">
                {{ $slot }}
            </main>

        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-8"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform translate-x-8"
             class="fixed top-24 right-6 z-50 flex items-center w-full max-w-xs p-4 space-x-3 bg-white rounded-xl shadow-2xl border-l-4 border-green-500"
             role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
            </div>
            <div class="ml-3 text-sm font-bold text-gray-700">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-8"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform translate-x-8"
             class="fixed top-24 right-6 z-50 flex items-center w-full max-w-xs p-4 space-x-3 bg-white rounded-xl shadow-2xl border-l-4 border-red-500"
             role="alert">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <div class="ml-3 text-sm font-bold text-gray-700">
                {{ session('error') }}
            </div>
        </div>
    @endif

</body>
</html>