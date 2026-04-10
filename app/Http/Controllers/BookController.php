<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Menampilkan daftar buku (Read)
   public function index(Request $request)
    {
        $query = Book::query();

        // Jika ada input pencarian, filter berdasarkan judul atau penulis
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        $books = $query->latest()->get(); 
        return view('admin.books.index', compact('books'));
    }

    // Menampilkan formulir tambah buku
    public function create()
    {
        return view('admin.books.create');
    }

    // Menyimpan data buku baru (Create)
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        Book::create($validated);

        return redirect()->route('admin.books.index')
                         ->with('success', 'Data buku berhasil ditambahkan.');
    }

    // Menampilkan formulir ubah data buku
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    // Menyimpan perubahan data buku (Update)
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $book->update($validated);

        return redirect()->route('admin.books.index')
                         ->with('success', 'Data buku berhasil diperbarui.');
    }

    // Menghapus data buku (Delete)
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')
                         ->with('success', 'Data buku berhasil dihapus.');
    }
}
