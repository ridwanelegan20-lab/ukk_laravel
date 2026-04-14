<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto min-h-screen">
        
        <div class="mb-8 flex items-center gap-3">
            <a href="{{ url('/katalog') }}" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Konfirmasi Peminjaman</h1>
                <p class="text-sm text-gray-500 mt-0.5">Periksa kembali detail buku sebelum mengajukan peminjaman</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex flex-col md:flex-row">
                
                <div class="w-full md:w-1/3 p-6 bg-gray-50/50 flex items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                    <div class="relative w-48 aspect-[3/4] rounded-lg overflow-hidden shadow-md border border-gray-200">
                        @if($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" alt="Sampul {{ $book->title }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                                <span class="text-2xl text-gray-400 font-bold uppercase tracking-widest">{{ substr($book->title, 0, 3) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="w-full md:w-2/3 p-8 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2.5 py-1 rounded-md border border-blue-100">
                                {{ $book->category->name ?? 'Tanpa Kategori' }}
                            </span>
                            <span class="bg-green-50 text-green-600 text-xs font-bold px-2.5 py-1 rounded-md border border-green-100">
                                Stok: {{ $book->stock }} Tersedia
                            </span>
                        </div>
                        
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $book->title }}</h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 mt-6 border-t border-gray-100 pt-6">
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Penulis</p>
                                <p class="text-sm font-bold text-gray-900">{{ $book->author }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Tahun Terbit</p>
                                <p class="text-sm font-bold text-gray-900">{{ $book->year ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Durasi Peminjaman</p>
                                <p class="text-sm font-bold text-gray-900">7 Hari</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Status Pengajuan</p>
                                <p class="text-sm font-bold text-orange-600">Perlu ACC Admin</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <form action="{{ route('transactions.borrow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#1e4ed8] hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Ajukan Peminjaman Sekarang
                            </button>
                        </form>
                        <p class="text-center text-[11px] text-gray-500 mt-3">
                            Dengan menekan tombol di atas, Anda akan mengirimkan notifikasi ke WhatsApp untuk menunggu persetujuan Admin.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>