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
    Route::get('/katalog', function (Request $request) {
        $query = Book::where('stock', '>', 0);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }
        
        $books = $query->latest()->get();
        return view('siswa.buku', compact('books'));
    });

    // Halaman Riwayat Pinjaman Saya
    Route::get('/riwayat-saya', function () {
        $myTransactions = Transaction::where('user_id', Auth::id())
                                     ->with('book')
                                     ->latest()
                                     ->get();
        return view('siswa.riwayat', compact('myTransactions'));
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
    Route::get('transactions', [TransactionController::class, 'adminIndex'])->name('transactions.index');
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

require __DIR__.'/auth.php';