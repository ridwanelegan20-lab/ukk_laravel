<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-sm text-gray-500 mt-1">Dashboard utama perpustakaan digital</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-blue-50/70 rounded-2xl p-5 border border-blue-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Buku Tersedia</p>
                    <h3 class="text-xl font-bold text-gray-900">1,245</h3>
                </div>
            </div>
            <div class="bg-green-50/70 rounded-2xl p-5 border border-green-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Buku Dipinjam</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $myTransactions->where('status', 'dipinjam')->count() ?? 0 }}</h3>
                </div>
            </div>
            <div class="bg-orange-50/70 rounded-2xl p-5 border border-orange-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-orange-400 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Buku Terlambat</p>
                    <h3 class="text-xl font-bold text-gray-900">0</h3>
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