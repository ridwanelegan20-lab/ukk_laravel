<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Riwayat Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Riwayat peminjaman buku perpustakaan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-50/50 rounded-2xl p-5 border border-blue-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Total Transaksi</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ number_format($totalTransactions) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Semua riwayat</p>
                </div>
            </div>

            <div class="bg-orange-50/50 rounded-2xl p-5 border border-orange-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-orange-400 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Sedang Dipinjam</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ number_format($activeBorrow) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Buku di tangan siswa</p>
                </div>
            </div>

            <div class="bg-green-50/50 rounded-2xl p-5 border border-green-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Selesai</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ number_format($returnedBooks) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Telah dikembalikan</p>
                </div>
            </div>

            <div class="bg-purple-50/50 rounded-2xl p-5 border border-purple-100 flex items-center gap-4 transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Hari Ini</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ number_format($todayTransactions) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5">Aktivitas tanggal {{ date('d M') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
                <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau Judul Buku..." class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 transition-colors">
                    </div>
                    
                    <select name="status" onchange="this.form.submit()" class="block w-full sm:w-40 py-2 px-3 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-600 cursor-pointer">
                        <option value="Semua Status" {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </form>

                <button type="button" onclick="window.print()" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-[#1e4ed8] hover:bg-blue-800 text-white font-medium py-2 px-5 rounded-lg text-sm transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 bg-gray-50/50 border-b border-gray-100 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">No</th>
                            <th scope="col" class="px-6 py-4 font-medium">Nama Peminjam</th>
                            <th scope="col" class="px-6 py-4 font-medium">Judul Buku</th>
                            <th scope="col" class="px-6 py-4 font-medium">Tanggal Pinjam</th>
                            <th scope="col" class="px-6 py-4 font-medium">Tanggal Kembali</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $index => $trx)
                            <tr class="hover:bg-gray-50/50 transition-colors bg-white">
                                <td class="px-6 py-4 text-gray-500">{{ $transactions->firstItem() + $index }}</td>
                                
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900">{{ $trx->user->name ?? 'User Terhapus' }}</p>
                                    <p class="text-[11px] text-gray-500">{{ $trx->user->email ?? '-' }}</p>
                                </td>
                                
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $trx->book->title ?? 'Buku Terhapus' }}</td>
                                
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($trx->created_at)->format('d F Y') }}</td>
                                
                                <td class="px-6 py-4">
                                    @if($trx->status === 'dikembalikan')
                                        {{ \Carbon\Carbon::parse($trx->updated_at)->format('d F Y') }}
                                    @else
                                        <span class="text-orange-500">{{ \Carbon\Carbon::parse($trx->created_at)->addDays(7)->format('d F Y') }}</span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4">
                                    @if($trx->status === 'dipinjam')
                                        <span class="bg-orange-100 text-orange-700 text-[11px] font-bold px-3 py-1 rounded-md border border-orange-200">Dipinjam</span>
                                    @else
                                        <span class="bg-green-100 text-green-700 text-[11px] font-bold px-3 py-1 rounded-md border border-green-200">Dikembalikan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        <p>Belum ada riwayat transaksi peminjaman.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-5 border-t border-gray-100 bg-gray-50/30">
                @if(isset($transactions) && $transactions->hasPages())
                    {{ $transactions->links() }}
                @else
                    <p class="text-xs text-gray-500">Menampilkan seluruh data transaksi.</p>
                @endif
            </div>
            
        </div>
    </div>
</x-app-layout>