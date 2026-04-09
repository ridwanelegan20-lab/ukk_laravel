<?php

// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // Fungsi untuk Siswa meminjam buku
    public function borrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $book = Book::findOrFail($request->book_id);

        // Validasi stok buku
        if ($book->stock <= 0) {
            return back()->with('error', 'Maaf, stok buku sedang kosong.');
        }

        // Buat transaksi peminjaman
        Transaction::create([
            'user_id' => Auth::id(), // ID Siswa yang sedang login
            'book_id' => $book->id,
            'borrow_date' => Carbon::now(),
            'status' => 'dipinjam'
        ]);

        // Kurangi stok buku
        $book->decrement('stock');

        return back()->with('success', 'Buku berhasil dipinjam!');
    }

    // Fungsi untuk Siswa mengembalikan buku
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
