<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-gray-50 min-h-screen">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Master Kategori</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola jenis kategori buku di perpustakaan</p>
            </div>
            <a href="{{ route('admin.books.index') }}" class="text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 px-4 py-2 rounded-lg transition-colors shadow-sm">
                Kembali ke Buku
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Kategori
                    </h2>
                    
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                            <input type="text" name="name" placeholder="Cth: Teknologi, Fiksi" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-[#2563eb] focus:border-[#2563eb] outline-none transition-colors" required>
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="w-full py-2.5 text-sm font-bold text-white bg-[#1e4ed8] rounded-lg hover:bg-blue-800 transition-colors shadow-sm">
                            Simpan Kategori
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-500 bg-gray-50/50 border-b border-gray-100 uppercase">
                                <tr>
                                    <th class="px-6 py-4 font-medium w-16 text-center">No</th>
                                    <th class="px-6 py-4 font-medium">Nama Kategori</th>
                                    <th class="px-6 py-4 font-medium text-center">Jumlah Buku</th>
                                    <th class="px-6 py-4 font-medium text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($categories as $index => $category)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 text-center text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-bold text-gray-900">{{ $category->name }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="bg-blue-50 text-blue-700 font-medium px-3 py-1 rounded-full text-xs">
                                                {{ $category->books_count }} Buku
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors" onclick="return confirm('Hapus kategori ini? (Buku dengan kategori ini akan kehilangan label kategorinya)')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada kategori yang dibuat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>