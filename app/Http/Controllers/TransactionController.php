<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // ====================================================================
    // BAGIAN ADMIN: Melihat Riwayat, Statistik, dan Pencarian
    // ====================================================================
    public function adminIndex(Request $request)
    {
        $query = Transaction::with(['user', 'book']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $status = strtolower($request->status);
            $query->where('status', $status);
        }

        $transactions = $query->latest()->paginate(10);
        $transactions->appends($request->all());

        $totalTransactions = Transaction::count();
        $activeBorrow = Transaction::where('status', 'dipinjam')->count();
        $returnedBooks = Transaction::where('status', 'dikembalikan')->count();
        $todayTransactions = Transaction::whereDate('created_at', Carbon::today())->count();

        return view('admin.transactions.index', compact(
            'transactions', 
            'totalTransactions', 
            'activeBorrow', 
            'returnedBooks', 
            'todayTransactions'
        ));
    }

    // ====================================================================
    // BAGIAN SISWA: Logika Pinjam dan Kembali
    // ====================================================================

    // 1. Menampilkan Halaman Form Pinjam
    public function borrowForm($id)
    {
        $book = Book::findOrFail($id);

        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku ini sedang kosong.');
        }

        return view('siswa.pinjam-form', compact('book'));
    }

    // 2. Memproses Data Peminjaman dari Form
    public function borrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'kelas' => 'required|string|max:50',
            'nomor_hp' => 'required|string|max:20',
            'return_date' => 'required|date|after_or_equal:today|before_or_equal:+7 days',
        ], [
            'return_date.before_or_equal' => 'Maksimal waktu peminjaman adalah 7 hari.',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock <= 0) {
            return redirect('/katalog')->with('error', 'Maaf, stok buku sedang kosong.');
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrow_date' => Carbon::now(),
            'return_date' => $request->return_date,
            'status' => 'dipinjam'
        ]);

        $book->decrement('stock');

        return redirect('/riwayat-saya')->with('success', 'Form berhasil dikirim. Buku siap diambil!');
    }

    // 3. Fungsi untuk Siswa mengembalikan buku (Ini yang sebelumnya hilang)
    public function returnBook($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->firstOrFail();

        // Update status transaksi
        $transaction->update([
            'return_date' => Carbon::now(),
            'status' => 'dikembalikan'
        ]);

        // Kembalikan stok buku
        $transaction->book->increment('stock');

        return back()->with('success', 'Buku berhasil dikembalikan!');
    }
}