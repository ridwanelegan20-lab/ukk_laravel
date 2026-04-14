<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola Buku</h1>
            <p class="text-sm text-gray-500 mt-1">Katalog buku yang tersedia di perpustakaan digital</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-white">
                <div class="relative w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Cari judul buku..." class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50">
                </div>
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
                            <th class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($books as $index => $book)
                        <tr class="hover:bg-gray-50 bg-white">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
    @if($book->image)
        <img src="{{ asset('storage/' . $book->image) }}" alt="Sampul" class="w-10 h-14 rounded object-cover shadow-sm border border-gray-200">
    @else
        <div class="w-10 h-14 bg-gray-100 rounded flex items-center justify-center border border-gray-200">
            <span class="text-[9px] text-gray-400 font-bold uppercase">{{ substr($book->title, 0, 3) }}</span>
        </div>
    @endif
</td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $book->title }}</td>
                            <td class="px-6 py-4">{{ $book->author }}</td>
                            <td class="px-6 py-4">
    <span class="bg-blue-50 text-blue-600 text-[10px] px-2 py-1 rounded border border-blue-100">
        {{ $book->category->name ?? 'Tanpa Kategori' }}
    </span>
</td>
<td class="px-6 py-4">{{ $book->year ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('transactions.borrowForm', $book->id) }}" class="inline-block text-xs font-medium text-white bg-[#1e4ed8] px-4 py-1.5 rounded-lg hover:bg-blue-800 transition text-center">
                                    Pinjam
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>