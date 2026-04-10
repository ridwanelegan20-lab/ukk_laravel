<?php

use App\Models\Book;
use App\Models\Transaction;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// TAMBAHKAN DUA BARIS INI:
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// ------------------------------------------------------------------
// 1. RUTE DASHBOARD SISWA (Sudah digabung & ditambah fitur Search)
// ------------------------------------------------------------------
Route::get('/dashboard', function (Request $request) {
    // Jika admin nyasar ke sini, kembalikan ke dashboard admin
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.books.index');
    }

    // Query dasar: Ambil data buku yang stoknya masih ada (> 0)
    $bookQuery = Book::where('stock', '>', 0);
    
    // Fitur pencarian untuk katalog siswa
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $bookQuery->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%");
        });
    }
    
    // Eksekusi query buku (tampilkan yang terbaru)
    $books = $bookQuery->latest()->get();
    
    // Ambil data transaksi milik siswa yang sedang login
    $myTransactions = Transaction::where('user_id', Auth::id())
                                 ->with('book') // Load relasi buku
                                 ->latest()
                                 ->get();

    return view('dashboard', compact('books', 'myTransactions'));
})->middleware(['auth', 'verified'])->name('dashboard');


// ------------------------------------------------------------------
// 2. RUTE PROFIL BAWAAN BREEZE
// ------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ------------------------------------------------------------------
// 3. RUTE KHUSUS ADMIN (Kelola Buku, Anggota, Transaksi)
// ------------------------------------------------------------------
Route::middleware(['auth', RoleMiddleware::class.':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
    // Menghasilkan rute: admin.books.index, create, store, edit, update, destroy
    Route::resource('books', BookController::class);
    
    // Menghasilkan rute: admin.members.index, create, store, edit, update, destroy
    Route::resource('members', MemberController::class);
    
    // Rute riwayat transaksi untuk admin
    Route::get('transactions', [TransactionController::class, 'adminIndex'])->name('transactions.index');
});


// ------------------------------------------------------------------
// 4. RUTE TRANSAKSI PEMINJAMAN & PENGEMBALIAN (Siswa)
// ------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {
    Route::post('/transactions/borrow', [TransactionController::class, 'borrow'])->name('transactions.borrow');
    Route::put('/transactions/return/{id}', [TransactionController::class, 'returnBook'])->name('transactions.return');
});

require __DIR__.'/auth.php';