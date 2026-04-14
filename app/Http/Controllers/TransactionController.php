<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

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
            'transactions', 'totalTransactions', 'activeBorrow', 'returnedBooks', 'todayTransactions'
        ));
    }

    // ====================================================================
    // BAGIAN SISWA: Logika Pinjam dan Kembali
    // ====================================================================
    public function borrowForm($id)
    {
        $book = Book::findOrFail($id);
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku ini sedang kosong.');
        }
        return view('siswa.pinjam-form', compact('book'));
    }

    public function borrow(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);
        $user = auth()->user();
        $book = \App\Models\Book::findOrFail($request->book_id);

        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok habis.');
        }

        $tanggalPinjam = Carbon::now();
        $batasKembali = Carbon::now()->addDays(7); 

        Transaction::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => $tanggalPinjam,
            'return_date' => $batasKembali,
            'status' => 'menunggu' 
        ]);

        $book->decrement('stock');

        $pesan = "Halo *{$user->name}*! 👋\n\nPengajuan peminjaman untuk buku *{$book->title}* telah masuk.\n\n⏳ *Status: MENUNGGU KONFIRMASI ADMIN*\n\nMohon ditunggu ya! 🚀";
        $this->kirimWA($user->phone_number, $pesan);

        return redirect()->route('dashboard')->with('success', 'Pengajuan berhasil dikirim! Menunggu persetujuan Admin.');
    }

    // UBAHAN BARU: Siswa minta kembalikan buku (Belum di-ACC Admin)
    public function returnBook($id)
    {
        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->where('status', 'dipinjam')->firstOrFail();

        // Status diubah jadi menunggu pengembalian (Stok BELUM bertambah)
        $transaction->update(['status' => 'menunggu_pengembalian']);

        $pesan = "Halo *{$transaction->user->name}*!\n\nAnda baru saja menekan tombol Kembalikan untuk buku *{$transaction->book->title}*.\n\n🚶‍♂️ Silakan bawa fisik buku tersebut dan serahkan kepada Admin/Petugas Perpustakaan agar statusnya diperbarui menjadi Selesai.";
        $this->kirimWA($transaction->user->phone_number, $pesan);

        return back()->with('success', 'Silakan serahkan buku fisik ke Admin untuk menyelesaikan pengembalian!');
    }

    // ====================================================================
    // BAGIAN ADMIN: Logika ACC Pinjam, Tolak, dan Terima Pengembalian
    // ====================================================================
    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'dipinjam']);

        $pesan = "HORE! 🎉\n\nPengajuan peminjaman buku *{$transaction->book->title}* Anda telah *DISETUJUI*.\n\nSilakan datang ke perpustakaan untuk mengambil bukunya. Selamat membaca!";
        $this->kirimWA($transaction->user->phone_number, $pesan);

        return back()->with('success', 'Peminjaman di-ACC!');
    }

    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'ditolak']);
        $transaction->book->increment('stock');

        $pesan = "Mohon maaf 🙏\n\nPengajuan peminjaman buku *{$transaction->book->title}* *DITOLAK* oleh Admin. Silakan temui petugas.";
        $this->kirimWA($transaction->user->phone_number, $pesan);

        return back()->with('success', 'Peminjaman ditolak!');
    }

    // UBAHAN BARU: Admin menerima fisik buku dan ACC Pengembalian
    public function approveReturn($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $transaction->update([
            'return_date' => Carbon::now(), // Catat tanggal pengembalian aslinya
            'status' => 'dikembalikan'
        ]);
        
        // Stok buku baru dikembalikan ke rak
        $transaction->book->increment('stock');

        $pesan = "Terima kasih! 🌟\n\nBuku *{$transaction->book->title}* telah diterima oleh Admin. Proses peminjaman Anda telah *SELESAI*.\n\nJangan lupa pinjam buku lainnya ya!";
        $this->kirimWA($transaction->user->phone_number, $pesan);

        return back()->with('success', 'Pengembalian buku berhasil dikonfirmasi!');
    }

    // FUNGSI BANTUAN UNTUK MENGIRIM WA AGAR KODE LEBIH RAPI
    private function kirimWA($nomorTujuan, $pesan) {
        if (!empty($nomorTujuan)) {
            try {
                Http::withHeaders(['Authorization' => 'vcxXUhLf2yRFFRUYS2Fp'])
                    ->post('https://api.fonnte.com/send', ['target' => $nomorTujuan, 'message' => $pesan]);
            } catch (\Exception $e) { \Log::error('WA Gagal: ' . $e->getMessage()); }
        }
    }
    // ====================================================================
    // FITUR BARU: Admin Mengirim Peringatan Keterlambatan
    // ====================================================================
    public function sendReminder($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Hitung sudah terlambat berapa hari
        $batasWaktu = Carbon::parse($transaction->return_date);
        $terlambatHari = $batasWaktu->diffInDays(Carbon::now());

        $pesan = "⚠️ *PERINGATAN KETERLAMBATAN* ⚠️\n\n";
        $pesan .= "Halo *{$transaction->user->name}*,\n\n";
        $pesan .= "Sistem kami mencatat bahwa masa peminjaman buku *{$transaction->book->title}* telah habis pada " . $batasWaktu->format('d M Y') . ".\n\n";
        $pesan .= "Buku ini telah terlambat selama *{$terlambatHari} hari*.\n\n";
        $pesan .= "Harap SEGERA mengembalikan buku tersebut ke perpustakaan hari ini juga untuk menghindari denda atau sanksi lebih lanjut. Terima kasih!";

        // Gunakan fungsi kirimWA yang sudah kita buat sebelumnya
        $this->kirimWA($transaction->user->phone_number, $pesan);

        return back()->with('success', 'Pesan peringatan WhatsApp berhasil dikirim ke siswa!');
    }
}