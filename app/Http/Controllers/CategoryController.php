<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan halaman Kategori (Form + Tabel)
    public function index()
    {
        $categories = Category::withCount('books')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Menyimpan Kategori Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kategori ini sudah ada di database.'
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    // Menghapus Kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}