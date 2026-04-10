<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-gray-50 min-h-screen">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola Buku</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data koleksi buku perpustakaan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-50/50 rounded-2xl p-5 border border-blue-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Total Buku</p>
                    <h3 class="text-xl font-bold text-gray-900">1,245</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Semua koleksi</p>
                </div>
            </div>

            <div class="bg-green-50/50 rounded-2xl p-5 border border-green-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Tersedia</p>
                    <h3 class="text-xl font-bold text-gray-900">1,120</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Siap dipinjam</p>
                </div>
            </div>

            <div class="bg-orange-50/50 rounded-2xl p-5 border border-orange-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-orange-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Dipinjam</p>
                    <h3 class="text-xl font-bold text-gray-900">125</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Sedang dipinjam</p>
                </div>
            </div>

            <div class="bg-purple-50/50 rounded-2xl p-5 border border-purple-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Kategori</p>
                    <h3 class="text-xl font-bold text-gray-900">12</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Jenis kategori</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <form method="GET" action="{{ route('admin.books.index') }}" class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau penulis buku..." class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 transition-colors">
                    </form>
                    
                    <select class="block w-full sm:w-40 py-2 px-3 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-600 cursor-pointer">
                        <option>Semua Kategori</option>
                        <option>Fiksi</option>
                        <option>Sejarah</option>
                    </select>
                </div>

                <a href="{{ route('admin.books.create') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-[#1e4ed8] hover:bg-blue-800 text-white font-medium py-2 px-5 rounded-lg text-sm transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Buku Baru
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 bg-gray-50/50 border-b border-gray-100 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">No</th>
                            <th scope="col" class="px-6 py-4 font-medium">Sampul</th>
                            <th scope="col" class="px-6 py-4 font-medium">Judul Buku</th>
                            <th scope="col" class="px-6 py-4 font-medium">Penulis</th>
                            <th scope="col" class="px-6 py-4 font-medium">Kategori</th>
                            <th scope="col" class="px-6 py-4 font-medium">Tahun</th>
                            <th scope="col" class="px-6 py-4 font-medium">Stok</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($books as $index => $book)
                            <tr class="hover:bg-gray-50/50 transition-colors bg-white">
                                <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                                
                                <td class="px-6 py-4">
                                    @if($book->image)
                                        <img src="{{ asset('storage/' . $book->image) }}" alt="Sampul" class="w-10 h-14 rounded object-cover shadow-sm border border-gray-200">
                                    @else
                                        <div class="w-10 h-14 bg-gradient-to-br from-gray-200 to-gray-300 rounded shadow-sm flex items-center justify-center">
                                            <span class="text-[9px] text-gray-500 font-bold uppercase">{{ substr($book->title, 0, 3) }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $book->title }}</td>
                                <td class="px-6 py-4">{{ $book->author }}</td>
                                
                                <td class="px-6 py-4">
                                    <span class="bg-blue-50 text-blue-600 text-[11px] font-medium px-2.5 py-1 rounded-md border border-blue-100">Fiksi</span>
                                </td>
                                
                                <td class="px-6 py-4">2023</td> <td class="px-6 py-4 font-medium">{{ $book->stock }}</td>
                                
                                <td class="px-6 py-4 flex items-center justify-center gap-2 mt-2">
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="text-[11px] font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-md border border-blue-100 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[11px] font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md border border-red-100 transition-colors" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        <p>Belum ada data buku.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-5 border-t border-gray-100 bg-gray-50/30">
                <p class="text-xs text-gray-500">Menampilkan seluruh data koleksi buku.</p>
            </div>
            
        </div>
    </div>
</x-app-layout>