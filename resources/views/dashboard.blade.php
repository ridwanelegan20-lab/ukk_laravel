<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-sm text-gray-500 mt-1">Dashboard utama perpustakaan digital</p>
        </div>

        @php
            $bukuTerlambat = $myTransactions->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])->where('return_date', '<', now());
        @endphp

        @if($bukuTerlambat->count() > 0)
            <div class="mb-8 bg-red-50 border-l-4 border-red-600 p-5 rounded-r-xl shadow-sm flex items-start gap-4 animate-pulse">
                <div class="bg-red-100 p-2 rounded-full shrink-0">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-red-900">Perhatian! Anda memiliki {{ $bukuTerlambat->count() }} buku yang terlambat dikembalikan.</h3>
                    <div class="mt-2 text-xs text-red-700 font-medium bg-red-100/50 p-3 rounded-lg border border-red-100">
                        <ul class="list-disc pl-5 space-y-1.5">
                            @foreach($bukuTerlambat as $telat)
                                <li>
                                    <strong>{{ $telat->book->title }}</strong> 
                                    (Batas waktu: {{ \Carbon\Carbon::parse($telat->return_date)->format('d F Y') }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <p class="mt-3 text-[11px] text-red-800 italic">Harap segera hubungi admin atau datang ke perpustakaan untuk menyerahkan fisik buku guna menghindari sanksi.</p>
                </div>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            
            <div class="bg-blue-50/70 rounded-2xl p-5 border border-blue-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Buku Tersedia</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ \App\Models\Book::sum('stock') }}</h3>
                </div>
            </div>

            <div class="bg-green-50/70 rounded-2xl p-5 border border-green-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Buku Dipinjam</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $myTransactions->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])->count() }}</h3>
                </div>
            </div>

            <div class="bg-orange-50/70 rounded-2xl p-5 border border-orange-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-orange-400 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Buku Terlambat</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $myTransactions->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])->where('return_date', '<', now())->count() }}</h3>
                </div>
            </div>
            
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-900">Rekomendasi Bacaan</h2>
                <a href="{{ url('/katalog') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($books->take(4) as $book)
                <div class="group cursor-pointer">
                    <div class="relative aspect-[3/4] bg-gray-100 rounded-xl overflow-hidden mb-3 border border-gray-200 flex items-center justify-center">
                        @if($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <span class="text-gray-400 font-bold uppercase tracking-widest text-xs">{{ substr($book->title, 0, 3) }}</span>
                        @endif
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 line-clamp-1 group-hover:text-blue-600">{{ $book->title }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $book->author }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>