<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-left">Nama Peminjam</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Judul Buku</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Tanggal Pinjam</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Tanggal Kembali</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr class="{{ $trx->status == 'dikembalikan' ? 'bg-gray-50 text-gray-500' : '' }}">
                                    <td class="border border-gray-300 px-4 py-2 font-semibold">{{ $trx->user->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $trx->book->title }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ \Carbon\Carbon::parse($trx->borrow_date)->format('d M Y') }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        {{ $trx->return_date ? \Carbon\Carbon::parse($trx->return_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        @if($trx->status == 'dipinjam')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">Dipinjam</span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada riwayat transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>