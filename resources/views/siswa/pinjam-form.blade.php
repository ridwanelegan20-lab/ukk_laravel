<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto min-h-screen">
        
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Formulir Peminjaman</h1>
                <p class="text-sm text-gray-500 mt-1">Lengkapi data di bawah ini untuk meminjam buku.</p>
            </div>
            <a href="{{ url()->previous() }}" class="text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 px-4 py-2 rounded-lg transition-colors">
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
            
            <div class="w-full md:w-1/3 bg-gray-50 p-6 md:p-8 border-b md:border-b-0 md:border-r border-gray-100 flex flex-col items-center text-center">
                <div class="w-32 h-44 bg-gray-200 rounded-xl shadow-md mb-4 flex items-center justify-center border border-gray-300">
                    <span class="text-gray-400 font-bold uppercase tracking-widest text-sm">{{ substr($book->title, 0, 3) }}</span>
                </div>
                <h2 class="text-lg font-bold text-gray-900 leading-tight mb-1">{{ $book->title }}</h2>
                <p class="text-sm text-gray-500 mb-4">oleh {{ $book->author }}</p>
                <div class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-blue-100">
                    Sisa Stok: {{ $book->stock }} Buku
                </div>
            </div>

            <div class="w-full md:w-2/3 p-6 md:p-8">
                <form action="{{ route('transactions.borrow') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed" readonly>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Peminjam</label>
                            <input type="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed" readonly>
                        </div>

                        <div>
                            <label for="kelas" class="block text-sm font-semibold text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                            <input type="text" name="kelas" id="kelas" placeholder="Cth: XII RPL 1" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 bg-white" required>
                        </div>

                        <div>
                            <label for="nomor_hp" class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <input type="number" name="nomor_hp" id="nomor_hp" placeholder="0812xxxxxx" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 bg-white" required>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="return_date" class="block text-sm font-semibold text-gray-700 mb-1">Rencana Dikembalikan Pada <span class="text-red-500">*</span></label>
                            <input type="date" name="return_date" id="return_date" 
                                   min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" 
                                   max="{{ \Carbon\Carbon::today()->addDays(7)->format('Y-m-d') }}" 
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 bg-white cursor-pointer" required>
                            <p class="text-[11px] text-orange-500 mt-1">* Waktu maksimal peminjaman adalah 7 hari dari hari ini.</p>
                            @error('return_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="pt-4 mt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm transition-colors w-full sm:w-auto">
                            Konfirmasi Pinjaman
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>