<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Menampilkan daftar buku beserta fitur pencarian & pagination.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Logika Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        // Logika Pagination
        $books = $query->latest()->paginate(10);
        $books->appends(['search' => $request->search]);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Menampilkan halaman form tambah buku.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Menyimpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'title.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Nama penulis wajib diisi.',
            'stock.required' => 'Jumlah stok wajib diisi.',
        ]);

        $data = $request->all();

        // Logika Upload Gambar
        if ($request->hasFile('image')) {
        // Simpan file ke folder storage/app/public/books
        $imagePath = $request->file('image')->store('books', 'public');
        $data['image'] = $imagePath;
    }

        // 2. Simpan ke database
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'stock' => $request->stock,
        ]);

        // 3. Kembalikan ke halaman daftar buku dengan pesan sukses
        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku baru berhasil ditambahkan ke katalog!');
    }

    /**
     * Menampilkan halaman form edit buku.
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Menyimpan perubahan data buku ke database.
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'author' => $request->author,
            'stock' => $request->stock,
        ];

        // 2. Cek apakah Admin mengunggah gambar baru saat Edit
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada (agar server tidak penuh)
            if ($book->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($book->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->image);
            }
            
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        // 3. Update database
        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui!');
    }
    /**
     * Menghapus buku dari database.
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku berhasil dihapus dari katalog!');
    }
}