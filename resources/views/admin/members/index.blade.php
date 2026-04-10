<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola Anggota</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data anggota perpustakaan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-50/50 rounded-2xl p-5 border border-blue-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Total Anggota</p>
                    <h3 class="text-xl font-bold text-gray-900">356</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Semua anggota</p>
                </div>
            </div>

            <div class="bg-green-50/50 rounded-2xl p-5 border border-green-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Aktif</p>
                    <h3 class="text-xl font-bold text-gray-900">342</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Anggota aktif</p>
                </div>
            </div>

            <div class="bg-orange-50/50 rounded-2xl p-5 border border-orange-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-orange-400 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Nonaktif</p>
                    <h3 class="text-xl font-bold text-gray-900">14</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Akses diblokir</p>
                </div>
            </div>

            <div class="bg-purple-50/50 rounded-2xl p-5 border border-purple-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Role Akun</p>
                    <h3 class="text-xl font-bold text-gray-900">2</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Admin & Siswa</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <form method="GET" action="{{ route('admin.members.index') }}" class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 transition-colors">
                    </form>
                    
                    <select class="block w-full sm:w-40 py-2 px-3 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-600 cursor-pointer">
                        <option>Status: Semua</option>
                        <option>Aktif</option>
                        <option>Nonaktif</option>
                    </select>
                </div>

                <a href="{{ route('admin.members.create') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-[#1e4ed8] hover:bg-blue-800 text-white font-medium py-2 px-5 rounded-lg text-sm transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Anggota Baru
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 bg-gray-50/50 border-b border-gray-100 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">No</th>
                            <th scope="col" class="px-6 py-4 font-medium">Nama</th>
                            <th scope="col" class="px-6 py-4 font-medium">Email</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                            <th scope="col" class="px-6 py-4 font-medium">Tgl Terdaftar</th>
                            <th scope="col" class="px-6 py-4 font-medium">Buku Dipinjam</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($members ?? [] as $index => $member)
                            <tr class="hover:bg-gray-50/50 transition-colors bg-white">
                                <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                                
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900">{{ $member->name }}</p>
                                    <p class="text-[11px] text-gray-500 capitalize">{{ $member->role }} Perpustakaan</p>
                                </td>
                                
                                <td class="px-6 py-4">{{ $member->email }}</td>
                                
                                <td class="px-6 py-4">
                                    <span class="bg-green-50 text-green-600 text-[11px] font-bold px-2.5 py-1 rounded-md border border-green-100">Aktif</span>
                                </td>
                                
                                <td class="px-6 py-4">{{ $member->created_at->format('d M Y') ?? '10 Apr 2026' }}</td>
                                
                                <td class="px-6 py-4 font-medium">0</td> <td class="px-6 py-4 flex items-center justify-center gap-2 mt-2">
                                    <a href="{{ route('admin.members.edit', $member->id) }}" class="text-[11px] font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-md border border-blue-100 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[11px] font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md border border-red-100 transition-colors" onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <p>Belum ada data anggota siswa.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-5 border-t border-gray-100 bg-gray-50/30">
                @if(isset($members) && $members->hasPages())
                    {{ $members->links() }}
                @else
                    <p class="text-xs text-gray-500">Menampilkan seluruh data anggota terdaftar.</p>
                @endif
            </div>
            
        </div>
    </div>
</x-app-layout>