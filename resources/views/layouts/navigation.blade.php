<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->role === 'siswa')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard Peminjaman') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')">
                            {{ __('Kelola Buku') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')">
                            {{ __('Kelola Anggota') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.*')">
                            {{ __('Riwayat Transaksi') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                
                @php
                    $notifCount = 0;
                    $recentNotifs = collect();

                    if(Auth::check()) {
                        if(Auth::user()->role === 'admin') {
                            // LOGIKA ADMIN: Munculkan yang butuh ACC dan Terlambat
                            $recentNotifs = \App\Models\Transaction::with(['user', 'book'])
                                ->whereIn('status', ['menunggu', 'menunggu_pengembalian'])
                                ->orWhere(function($query) {
                                    $query->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])
                                          ->whereDate('return_date', '<', \Carbon\Carbon::today());
                                })
                                ->latest()->take(5)->get();
                            $notifCount = $recentNotifs->count();
                        } else {
                            // LOGIKA SISWA: Munculkan 5 aktivitas terakhir apapun statusnya
                            $recentNotifs = \App\Models\Transaction::with('book')
                                ->where('user_id', Auth::id())
                                ->latest()->take(5)->get();
                            
                            // TITIK MERAH SISWA: Hanya nyala jika Ditolak atau Terlambat
                            $notifCount = \App\Models\Transaction::where('user_id', Auth::id())
                                ->where(function($query) {
                                    $query->where('status', 'ditolak')
                                          ->orWhere(function($q) {
                                              $q->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])
                                                ->whereDate('return_date', '<', \Carbon\Carbon::today());
                                          });
                                })
                                ->count();
                        }
                    }
                @endphp

                <div class="relative" x-data="{ openNotif: false }" @click.outside="openNotif = false">
                    <button @click="openNotif = !openNotif" class="relative p-2 text-gray-400 hover:text-blue-600 focus:outline-none transition ease-in-out duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        
                        @if($notifCount > 0)
                            <span class="absolute top-1 right-1.5 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                            </span>
                        @endif
                    </button>

                    <div x-show="openNotif"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-100 z-50 overflow-hidden"
                         style="display: none;">
                        
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <p class="text-sm font-bold text-gray-700">Aktivitas Anda</p>
                            @if($notifCount > 0)
                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded">{{ $notifCount }} Perlu Perhatian</span>
                            @endif
                        </div>

                        <div class="max-h-[300px] overflow-y-auto">
                            @forelse($recentNotifs as $notif)
                                @php
                                    $isOverdue = in_array($notif->status, ['dipinjam', 'menunggu_pengembalian']) && \Carbon\Carbon::parse($notif->return_date)->isPast();
                                @endphp
                                <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50 {{ $isOverdue || $notif->status == 'ditolak' ? 'bg-red-50/30' : '' }}">
                                    @if(Auth::user()->role === 'admin')
                                        <p class="text-sm text-gray-800 leading-tight">
                                            <strong>{{ $notif->user->name }}</strong> 
                                            @if($notif->status === 'menunggu') mengajukan pinjaman
                                            @elseif($notif->status === 'menunggu_pengembalian') ingin menyerahkan
                                            @elseif($isOverdue) <span class="text-red-600">terlambat kembalikan</span>
                                            @endif
                                            "{{ $notif->book->title }}"
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-800 leading-tight">
                                            @if($notif->status === 'menunggu')
                                                <span class="text-yellow-600 font-medium">Menunggu ACC:</span>
                                            @elseif($notif->status === 'dipinjam' && !$isOverdue)
                                                <span class="text-blue-600 font-medium">Sedang dipinjam:</span>
                                            @elseif($notif->status === 'menunggu_pengembalian')
                                                <span class="text-purple-600 font-medium">Menyerahkan:</span>
                                            @elseif($notif->status === 'dikembalikan')
                                                <span class="text-green-600 font-medium">Selesai:</span>
                                            @elseif($notif->status === 'ditolak')
                                                <span class="text-red-600 font-medium">Ditolak:</span>
                                            @elseif($isOverdue)
                                                <span class="text-red-600 font-bold">Terlambat:</span>
                                            @endif
                                            "{{ $notif->book->title }}"
                                        </p>
                                    @endif
                                    <p class="text-[10px] text-gray-400 mt-1">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</p>
                                </div>
                            @empty
                                <div class="px-4 py-6 text-center">
                                    <p class="text-sm text-gray-500">Belum ada aktivitas.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'siswa')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard Peminjaman') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')">
                    {{ __('Kelola Buku') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')">
                    {{ __('Kelola Anggota') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.*')">
                    {{ __('Riwayat Transaksi') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>