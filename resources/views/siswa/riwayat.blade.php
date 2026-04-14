<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Riwayat Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi peminjaman buku Anda</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 bg-gray-50/50 border-b border-gray-100 uppercase">
                        <tr>
                            <th class="px-6 py-4 font-medium">No</th>
                            <th class="px-6 py-4 font-medium">Judul Buku</th>
                            <th class="px-6 py-4 font-medium">Tanggal Pinjam</th>
                            <th class="px-6 py-4 font-medium">Tanggal Kembali</th>
                            <th class="px-6 py-4 font-medium text-center">Aksi / Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($myTransactions as $index => $trx)
                        <tr class="hover:bg-gray-50 bg-white">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900">{{ $trx->book->title ?? 'Buku Dihapus' }}</p>
                                <p class="text-[11px] text-gray-500">{{ $trx->book->author ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($trx->borrow_date ?? $trx->created_at)->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ $trx->status == 'dikembalikan' ? \Carbon\Carbon::parse($trx->return_date ?? $trx->updated_at)->format('d M Y') : 'Belum Kembali' }}</td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($trx->status === 'menunggu')
                                    <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-3 py-1 rounded-md border border-yellow-200">Menunggu ACC Pinjam</span>
                                @elseif($trx->status === 'dipinjam')
                                    <form action="{{ route('transactions.return', $trx->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="bg-blue-100 text-blue-700 hover:bg-blue-200 text-[11px] font-bold px-3 py-1.5 rounded-md border border-blue-200 transition" onclick="return confirm('Yakin ingin mengembalikan buku ini sekarang? Jangan lupa serahkan fisik buku ke Admin ya!')">
                                            Kembalikan
                                        </button>
                                    </form>
                                @elseif($trx->status === 'menunggu_pengembalian')
                                    <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-3 py-1 rounded-md border border-orange-200">Menunggu ACC Kembali</span>
                                @elseif($trx->status === 'dikembalikan')
                                    <span class="bg-green-100 text-green-700 text-[10px] font-bold px-3 py-1 rounded-md border border-green-200">Dikembalikan</span>
                                @elseif($trx->status === 'ditolak')
                                    <span class="bg-red-100 text-red-700 text-[10px] font-bold px-3 py-1 rounded-md border border-red-200">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>