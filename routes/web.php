<?php
use App\Models\Book;
use App\Models\Transaction;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Rute khusus untuk Admin
Route::middleware(['auth', RoleMiddleware::class.':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
    // Menghasilkan rute: admin.books.index, create, store, edit, update, destroy
    Route::resource('books', BookController::class);
    
    // Menghasilkan rute: admin.members.index, create, store, edit, update, destroy
    Route::resource('members', MemberController::class);
});
Route::get('/dashboard', function () {
    // Jika admin nyasar ke sini, kembalikan ke habitatnya
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.books.index');
    }

    // Ambil data buku yang stoknya masih ada (> 0)
    $books = Book::where('stock', '>', 0)->latest()->get();
    
    // Ambil data transaksi milik siswa yang sedang login
    $myTransactions = Transaction::where('user_id', Auth::id())
                                 ->with('book') // Load relasi buku agar query lebih efisien
                                 ->latest()
                                 ->get();

    return view('dashboard', compact('books', 'myTransactions'));
})->middleware(['auth', 'verified'])->name('dashboard');


// 2. Rute Aksi Peminjaman dan Pengembalian (Khusus Siswa yang Login)
Route::middleware(['auth'])->group(function () {
    Route::post('/transactions/borrow', [TransactionController::class, 'borrow'])->name('transactions.borrow');
    Route::put('/transactions/return/{id}', [TransactionController::class, 'returnBook'])->name('transactions.return');
});

require __DIR__.'/auth.php';
