<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Selamat Datang, <br class="sm:hidden">{{ Auth::user()->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">Dashboard dan ringkasan aktivitas perpustakaan</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50/70 rounded-2xl p-5 border border-blue-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Total Buku</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ number_format($totalBooks) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Semua koleksi</p>
                </div>
            </div>

            <div class="bg-green-50/70 rounded-2xl p-5 border border-green-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Total Anggota</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ number_format($totalMembers) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Anggota terdaftar</p>
                </div>
            </div>

            <div class="bg-orange-50/70 rounded-2xl p-5 border border-orange-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-orange-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Dipinjam</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ number_format($borrowedBooks) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Sedang dipinjam</p>
                </div>
            </div>

            <div class="bg-purple-50/70 rounded-2xl p-5 border border-purple-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Dipinjam Hari Ini</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ number_format($transactionsToday) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Transaksi hari ini</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Grafik Peminjaman Buku</h3>
                    <select class="text-xs border-gray-200 rounded-lg text-gray-500 focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
                        <option>6 Bulan Terakhir</option>
                        <option>Tahun Ini</option>
                    </select>
                </div>
                
                <div class="relative h-64 w-full bg-gray-50 rounded-xl overflow-hidden flex items-end">
                    <div class="absolute inset-0 flex flex-col justify-between py-4 px-2 opacity-20 pointer-events-none">
                        <div class="border-b border-gray-400 w-full"></div>
                        <div class="border-b border-gray-400 w-full"></div>
                        <div class="border-b border-gray-400 w-full"></div>
                        <div class="border-b border-gray-400 w-full"></div>
                    </div>
                    
                    <svg class="w-full h-full text-blue-500 drop-shadow-md" preserveAspectRatio="none" viewBox="0 0 100 100">
                        <defs>
                            <linearGradient id="gradientBlue" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.4"/>
                                <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.0"/>
                            </linearGradient>
                        </defs>
                        <polygon fill="url(#gradientBlue)" points="0,100 0,60 20,65 40,40 60,70 80,30 100,50 100,100" />
                        <polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="0,60 20,65 40,40 60,70 80,30 100,50" />
                        <circle cx="80" cy="30" r="2" fill="white" stroke="currentColor" stroke-width="1.5" />
                    </svg>
                    
                    <div class="absolute top-[20%] left-[70%] bg-white border border-gray-200 shadow-lg rounded-lg px-3 py-1.5 text-xs font-bold text-gray-700">
                        193 Peminjaman
                    </div>
                </div>
                
                <div class="flex justify-between mt-3 text-[10px] text-gray-400 font-medium px-2">
                    <span>Nov</span>
                    <span>Des</span>
                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Riwayat Terakhir</h3>
                    <a href="{{ route('admin.transactions.index') ?? '#' }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium bg-blue-50 px-2 py-1 rounded">Lihat Semua</a>
                </div>

                <div class="space-y-4">
    @forelse($recentTransactions as $transaction)
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold shrink-0 uppercase">
            {{ substr($transaction->user->name, 0, 1) }}
        </div>
        
        <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-gray-900 truncate">{{ $transaction->user->name }}</p>
            <p class="text-[11px] text-gray-500 truncate">{{ $transaction->book->title }}</p>
        </div>
        
        <div class="text-right shrink-0">
            @if($transaction->status == 'dipinjam')
                <span class="inline-block bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded-md">Dipinjam</span>
            @else
                <span class="inline-block bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-md">Dikembalikan</span>
            @endif
            <p class="text-[9px] text-gray-400 mt-0.5">{{ $transaction->created_at->format('d M Y') }}</p>
        </div>
    </div>
    @empty
    <div class="text-center py-4">
        <p class="text-xs text-gray-500">Belum ada riwayat transaksi.</p>
    </div>
    @endforelse
</div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold shrink-0">
                            S
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">Siti Dwi</p>
                            <p class="text-[11px] text-gray-500 truncate">Atomic Habits</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-md">Dikembalikan</span>
                            <p class="text-[9px] text-gray-400 mt-0.5">7 Apr 2026</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold shrink-0">
                            J
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">Joko Santoso</p>
                            <p class="text-[11px] text-gray-500 truncate">Harry Potter</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-md">Dikembalikan</span>
                            <p class="text-[9px] text-gray-400 mt-0.5">5 Apr 2026</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 font-bold shrink-0">
                            A
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">Ani Rahmawati</p>
                            <p class="text-[11px] text-gray-500 truncate">Bumi</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-md">Dikembalikan</span>
                            <p class="text-[9px] text-gray-400 mt-0.5">1 Apr 2026</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative h-24 flex items-center px-6">
            <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ asset('images/bg-library.jpg') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900 via-blue-800/80 to-transparent"></div>
            
            <div class="relative z-10 flex justify-between items-center w-full">
                <div>
                    <h3 class="text-white font-bold text-lg">Jelajahi Koleksi Terbaru Kami</h3>
                    <p class="text-blue-100 text-xs">Tersedia ratusan buku baru minggu ini.</p>
                </div>
                <a href="{{ route('admin.books.index') }}" class="bg-white text-blue-900 font-bold px-4 py-2 rounded-lg text-sm shadow-md hover:bg-gray-50 transition">
                    Kelola Sekarang
                </a>
            </div>
        </div>

    </div>
</x-app-layout>