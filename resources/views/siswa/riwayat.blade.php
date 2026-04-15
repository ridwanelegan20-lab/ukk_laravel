<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Riwayat Pinjaman Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar semua buku yang pernah dan sedang Anda pinjam.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-white">
                <h3 class="text-lg font-bold text-gray-800">Daftar Transaksi</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 bg-gray-50/50 border-b border-gray-100 uppercase">
                        <tr>
                            <th class="px-6 py-4 font-medium">No</th>
                            <th class="px-6 py-4 font-medium">Buku</th>
                            <th class="px-6 py-4 font-medium">Tgl Pengajuan</th>
                            <th class="px-6 py-4 font-medium">Batas Kembali</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium text-center">Aksi</th> </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $index => $trx)
                            <tr class="hover:bg-gray-50 transition-colors bg-white">
                                <td class="px-6 py-4 text-gray-500">{{ $transactions->firstItem() + $index }}</td>
                                
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900">{{ $trx->book->title ?? 'Buku Dihapus' }}</p>
                                    <p class="text-[11px] text-gray-500">{{ $trx->book->author ?? '-' }}</p>
                                </td>
                                
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($trx->created_at)->format('d F Y') }}</td>
                                
                                <td class="px-6 py-4">
                                    @if($trx->status === 'dikembalikan')
                                        <span class="text-gray-400 italic">Selesai</span>
                                    @elseif($trx->status === 'ditolak')
                                        <span class="text-gray-400 italic">-</span>
                                    @else
                                        @if(\Carbon\Carbon::parse($trx->return_date)->isPast())
                                            <span class="text-red-600 font-bold">{{ \Carbon\Carbon::parse($trx->return_date)->format('d F Y') }}</span>
                                        @else
                                            <span class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($trx->return_date)->format('d F Y') }}</span>
                                        @endif
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4">
                                    @if(in_array($trx->status, ['dipinjam', 'menunggu_pengembalian']) && \Carbon\Carbon::parse($trx->return_date)->isPast())
                                        <span class="bg-red-100 text-red-700 text-[11px] font-bold px-3 py-1.5 rounded-md border border-red-200">TERLAMBAT</span>
                                    @elseif($trx->status === 'menunggu')
                                        <span class="bg-yellow-100 text-yellow-700 text-[11px] font-bold px-3 py-1.5 rounded-md border border-yellow-200">Menunggu ACC</span>
                                    @elseif($trx->status === 'menunggu_pengembalian')
                                        <span class="bg-purple-100 text-purple-700 text-[11px] font-bold px-3 py-1.5 rounded-md border border-purple-200">Proses Kembali</span>
                                    @elseif($trx->status === 'dipinjam')
                                        <span class="bg-blue-100 text-blue-700 text-[11px] font-bold px-3 py-1.5 rounded-md border border-blue-200">Sedang Dipinjam</span>
                                    @elseif($trx->status === 'dikembalikan')
                                        <span class="bg-green-100 text-green-700 text-[11px] font-bold px-3 py-1.5 rounded-md border border-green-200">Dikembalikan</span>
                                    @elseif($trx->status === 'ditolak')
                                        <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-3 py-1.5 rounded-md border border-gray-200">Ditolak</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($trx->status === 'dipinjam')
                                        <form action="{{ route('transactions.return', $trx->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-[11px] font-bold text-white bg-purple-600 hover:bg-purple-700 px-3 py-1.5 rounded-md transition-colors shadow-sm" onclick="return confirm('Yakin ingin mengembalikan buku ini sekarang? Pastikan Anda juga menyerahkan fisik bukunya ke Admin.')">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs italic">-</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p>Anda belum memiliki riwayat peminjaman buku.</p>
                                        <a href="{{ url('/katalog') }}" class="mt-4 text-sm text-[#1e4ed8] hover:underline font-medium">Jelajahi Katalog Buku</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="p-5 border-t border-gray-100 bg-gray-50/30">
                    {{ $transactions->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>