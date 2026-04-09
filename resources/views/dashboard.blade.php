<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Peminjaman Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 border-b border-gray-200 bg-gray-50 font-bold">
                        Katalog Buku Tersedia
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($books as $book)
                                <div class="border rounded-lg p-4 flex justify-between items-center shadow-sm">
                                    <div>
                                        <h3 class="font-bold text-lg">{{ $book->title }}</h3>
                                        <p class="text-sm text-gray-600">Oleh: {{ $book->author }}</p>
                                        <p class="text-sm text-blue-600 mt-1">Stok: {{ $book->stock }}</p>
                                    </div>
                                    
                                    <form action="{{ route('transactions.borrow') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded text-sm transition" onclick="return confirm('Pinjam buku {{ $book->title }}?')">
                                            Pinjam Buku
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Yah, saat ini tidak ada buku yang tersedia untuk dipinjam.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 border-b border-gray-200 bg-gray-50 font-bold">
                        Buku yang Saya Pinjam
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($myTransactions as $trx)
                                <div class="border rounded-lg p-4 shadow-sm {{ $trx->status == 'dikembalikan' ? 'bg-gray-100 opacity-75' : 'bg-white' }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-bold">{{ $trx->book->title }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">Dipinjam: {{ \Carbon\Carbon::parse($trx->borrow_date)->format('d M Y') }}</p>
                                            
                                            @if($trx->status == 'dipinjam')
                                                <span class="inline-block mt-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">Sedang Dipinjam</span>
                                            @else
                                                <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Dikembalikan pada: {{ \Carbon\Carbon::parse($trx->return_date)->format('d M Y') }}</span>
                                            @endif
                                        </div>

                                        @if($trx->status == 'dipinjam')
                                            <form action="{{ route('transactions.return', $trx->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-green-600 hover:bg-green-800 text-white font-bold py-1 px-3 rounded text-sm transition" onclick="return confirm('Kembalikan buku ini sekarang?')">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Kamu belum pernah meminjam buku apapun.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>