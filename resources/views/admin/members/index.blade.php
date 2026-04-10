<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Anggota (Siswa)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-4 flex flex-col md:flex-row justify-between items-center gap-4">
                        <form method="GET" action="{{ route('admin.members.index') }}" class="flex w-full md:w-1/2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email siswa..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-l-md shadow-sm w-full">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-r-md transition">
                                Cari
                            </button>
                        </form>

                        <a href="{{ route('admin.members.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded whitespace-nowrap">
                            + Tambah Anggota Baru
                        </a>
                    </div>

                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">Nama Siswa</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Tgl Terdaftar</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $member->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $member->email }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $member->created_at->format('d M Y') }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('admin.members.edit', $member->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                        
                                        <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus anggota ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada data anggota.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>