<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Menampilkan daftar buku beserta fitur pencarian & pagination.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Book::with('category');

        // Filter pencarian Admin
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter kategori Admin
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $books = $query->latest()->get();

        // PASTIKAN BARIS INI MENGARAH KE ADMIN, BUKAN KATALOG
        return view('admin.books.index', compact('books')); 
    }
    /**
     * Menampilkan halaman form tambah buku.
     */
    public function create()
    {
        $categories = Category::all(); 
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Menyimpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Inputan
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'year' => 'nullable|integer',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Ambil semua data kecuali gambar
        $data = $request->except('image');

        // 3. Logika Menyimpan Gambar
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder storage/app/public/books
            // File akan otomatis diberi nama unik oleh Laravel
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        // 4. Simpan ke database
        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku baru dan sampulnya berhasil ditambahkan!');
    }
    /**
     * Menampilkan halaman form edit buku.
     */
    public function edit($id)
    {
        $book = \App\Models\Book::findOrFail($id);
        $categories = \App\Models\Category::all(); 

        return view('admin.books.edit', compact('book', 'categories'));
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