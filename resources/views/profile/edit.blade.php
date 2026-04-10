<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto min-h-screen">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Profil Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi data diri akun Anda</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6 sm:p-10">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                
                <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center shrink-0 border-4 border-white shadow-lg mx-auto md:mx-0 relative">
                    <span class="text-4xl font-bold text-blue-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    <button class="absolute bottom-0 right-0 w-8 h-8 bg-[#1e4ed8] text-white rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </button>
                </div>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}"></form>
                <form method="post" action="{{ route('profile.update') }}" class="flex-1 w-full space-y-4">
                    @csrf @method('patch')
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Profil Anda (Nama Lengkap)</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 bg-gray-50 text-gray-900" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 bg-gray-50 text-gray-900" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-4 mt-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Terdaftar Sejak</label>
                            <p class="text-gray-900">{{ Auth::user()->created_at->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#1e4ed8] rounded-lg hover:bg-blue-800 shadow-sm">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>