<?php

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\SocialLoginController;
use Carbon\Carbon;

// ==================================================================
// RUTE LOGIN GOOGLE & FACEBOOK
// ==================================================================
Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');

Route::get('/', function () {
    return redirect('/login');
});

// ==================================================================
// 1. RUTE DASHBOARD (Admin & Siswa)
// ==================================================================
Route::get('/dashboard', function (Request $request) {
    
    // --- JIKA ADMIN ---
    if (Auth::user()->role === 'admin') {
        $totalBooks = Book::sum('stock');
        $totalMembers = User::where('role', 'siswa')->count();
        $borrowedBooks = Transaction::where('status', 'dipinjam')->count();
        $transactionsToday = Transaction::whereDate('created_at', Carbon::today())->count();
        
        $recentTransactions = Transaction::with(['user', 'book'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBooks', 'totalMembers', 'borrowedBooks', 'transactionsToday', 'recentTransactions'
        ));
    }
    
    // --- JIKA SISWA ---
    // Di dashboard utama siswa, tampilkan sedikit buku (preview 8 buku terbaru)
    $books = Book::where('stock', '>', 0)->latest()->take(8)->get();
    $myTransactions = Transaction::where('user_id', Auth::id())->with('book')->latest()->get();

    return view('dashboard', compact('books', 'myTransactions'));
    
})->middleware(['auth', 'verified'])->name('dashboard');

// ==================================================================
// 2. RUTE MENU SISWA BARU (Katalog & Riwayat)
// ==================================================================
Route::middleware('auth')->group(function () {
    
    // Halaman Katalog Buku Full
    Route::get('/katalog', function (\Illuminate\Http\Request $request) {
        // Panggil relasi kategori agar ringan di database
        $query = \App\Models\Book::with('category');
        
        // 1. Filter Pencarian Judul/Penulis
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }
        
        // 2. Filter Kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Ambil data buku dengan pagination (12 buku per halaman)
        $books = $query->latest()->paginate(12);
        $books->appends($request->all()); // Agar filter tidak hilang saat pindah halaman
        
        // Ambil semua daftar kategori untuk isi Dropdown
        $categories = \App\Models\Category::all();
        
        return view('siswa.buku', compact('books', 'categories'));
    });

    // ==================================================
    // FITUR BARU: Halaman Riwayat Pinjaman Siswa
    // ==================================================
    Route::get('/riwayat-saya', function () {
        $transactions = \App\Models\Transaction::with('book')
                            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                            ->latest()
                            ->paginate(10);
                            
        return view('siswa.riwayat', compact('transactions'));
    });

});

// ==================================================================
// 3. RUTE PROFIL BAWAAN BREEZE
// ==================================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================================================================
// 4. RUTE KHUSUS ADMIN (Kelola Buku, Anggota, Transaksi)
// ==================================================================
Route::middleware(['auth', RoleMiddleware::class.':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    
    // --- Rute Transaksi Admin ---
    Route::get('transactions', [TransactionController::class, 'adminIndex'])->name('transactions.index');
    Route::put('transactions/{id}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
    Route::put('transactions/{id}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');
    Route::put('transactions/{id}/approve-return', [TransactionController::class, 'approveReturn'])->name('transactions.approveReturn');
    Route::post('transactions/{id}/remind', [TransactionController::class, 'sendReminder'])->name('transactions.remind');
    
    // --- CRUD Kategori ---
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
});

// ==================================================================
// 5. RUTE TRANSAKSI PEMINJAMAN & PENGEMBALIAN (Siswa)
// ==================================================================
Route::middleware(['auth'])->group(function () {
    // Menampilkan halaman form pinjam
    Route::get('/katalog/{id}/pinjam', [TransactionController::class, 'borrowForm'])->name('transactions.borrowForm');
    
    // Memproses data dari form pinjam
    Route::post('/transactions/borrow', [TransactionController::class, 'borrow'])->name('transactions.borrow');
    
    // Mengembalikan buku
    Route::put('/transactions/return/{id}', [TransactionController::class, 'returnBook'])->name('transactions.return');
});
Route::get('/buat-symlink', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Symlink berhasil dibuat!';
});

require __DIR__.'/auth.php';