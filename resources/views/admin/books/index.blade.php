<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('admin.books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Buku Baru
                        </a>
                    </div>

                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">Judul</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Penulis</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Stok</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $book->title }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $book->author }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $book->stock }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                        
                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada data buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>