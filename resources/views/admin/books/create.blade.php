<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.books.store') }}" class="max-w-xl">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Judul Buku')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="author" :value="__('Penulis')" />
                            <x-text-input id="author" class="block mt-1 w-full" type="text" name="author" :value="old('author')" required />
                            <x-input-error :messages="$errors->get('author')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="stock" :value="__('Stok Buku')" />
                            <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock')" required min="0" />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.books.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Data') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>