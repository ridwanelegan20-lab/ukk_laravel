<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Katalog Buku</h1>
            <p class="text-sm text-gray-500 mt-1">Jelajahi koleksi buku yang tersedia di perpustakaan digital kami</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
                <form method="GET" action="{{ url('/katalog') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto" id="katalogFilterForm">
                    
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku..." class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 transition-colors">
                    </div>
                    
                    <select name="category" onchange="document.getElementById('katalogFilterForm').submit();" class="block w-full sm:w-48 py-2 px-3 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-600 cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @if(isset($categories))
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 bg-gray-50/50 border-b border-gray-100 uppercase">
                        <tr>
                            <th class="px-6 py-4 font-medium">No</th>
                            <th class="px-6 py-4 font-medium">Sampul</th>
                            <th class="px-6 py-4 font-medium">Judul Buku</th>
                            <th class="px-6 py-4 font-medium">Penulis</th>
                            <th class="px-6 py-4 font-medium">Kategori</th>
                            <th class="px-6 py-4 font-medium">Tahun</th>
                            <th class="px-6 py-4 font-medium text-center">Stok</th> <th class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($books as $index => $book)
                        <tr class="hover:bg-gray-50 bg-white transition-colors">
                            <td class="px-6 py-4">{{ method_exists($books, 'firstItem') ? $books->firstItem() + $index : $index + 1 }}</td>
                            <td class="px-6 py-4">
                                @if($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="Sampul" class="w-10 h-14 rounded object-cover shadow-sm border border-gray-200">
                                @else
                                    <div class="w-10 h-14 bg-gray-100 rounded flex items-center justify-center border border-gray-200 shadow-sm">
                                        <span class="text-[9px] text-gray-400 font-bold uppercase">{{ substr($book->title, 0, 3) }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $book->title }}</td>
                            <td class="px-6 py-4">{{ $book->author }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-medium px-2 py-1 rounded-md border border-blue-100">
                                    {{ $book->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $book->year ?? '-' }}</td>
                            
                            <td class="px-6 py-4 text-center font-bold">
                                @if($book->stock > 0)
                                    <span class="text-green-600">{{ $book->stock }}</span>
                                @else
                                    <span class="text-red-500">0</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 flex justify-center mt-2">
                                @if($book->stock > 0)
                                    <a href="{{ route('transactions.borrowForm', $book->id) }}" class="inline-block text-[11px] font-medium text-white bg-[#1e4ed8] px-4 py-2 rounded-lg hover:bg-blue-800 transition shadow-sm text-center">
                                        Pinjam Buku
                                    </a>
                                @else
                                    <button disabled class="inline-block text-[11px] font-medium text-gray-400 bg-gray-100 border border-gray-200 px-4 py-2 rounded-lg cursor-not-allowed text-center">
                                        Stok Habis
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        <p>Maaf, buku dengan kriteria tersebut tidak ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($books, 'hasPages') && $books->hasPages())
            <div class="p-5 border-t border-gray-100 bg-gray-50/30">
                {{ $books->links() }}
            </div>
            @endif

        </div>
    </div>
</x-app-layout>