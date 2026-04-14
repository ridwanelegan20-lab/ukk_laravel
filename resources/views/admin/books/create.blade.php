<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto min-h-screen">
        
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Buku Baru</h1>
                <p class="text-sm text-gray-500 mt-1">Masukkan detail informasi buku ke dalam katalog.</p>
            </div>
            <a href="{{ route('admin.books.index') }}" class="flex items-center gap-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 px-4 py-2 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('admin.books.store') }}" method="POST" class="p-6 sm:p-8" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    
                    <div class="sm:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Contoh: Laskar Pelangi" class="block w-full px-4 py-2.5 text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="author" class="block text-sm font-semibold text-gray-700 mb-1">Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="author" id="author" value="{{ old('author') }}" placeholder="Contoh: Andrea Hirata" class="block w-full px-4 py-2.5 text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        @error('author') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="block w-full px-4 py-2.5 text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors cursor-pointer" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-semibold text-gray-700 mb-1">Tahun Terbit</label>
                        <input type="number" name="year" id="year" placeholder="Contoh: 2005" class="block w-full px-4 py-2.5 text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}" min="0" placeholder="0" class="block w-full px-4 py-2.5 text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        @error('stock') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2 mt-2">
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Sampul Buku (Opsional)</label>
                        <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 transition-colors file:mr-4 file:py-2.5 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 cursor-pointer">
                        <p class="mt-1 text-[11px] text-gray-400">Format yang didukung: JPG, JPEG, PNG. Maksimal ukuran 2MB.</p>
                        @error('image') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                </div>

                <div class="my-8 border-t border-gray-100"></div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.books.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>