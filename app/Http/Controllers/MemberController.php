<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // Menampilkan daftar anggota/siswa
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        // Filter berdasarkan nama atau email siswa
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->get();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Tetapkan role secara eksplisit
        $validated['role'] = 'siswa';
        // Enkripsi kata sandi
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.members.index')
                         ->with('success', 'Anggota baru berhasil didaftarkan.');
    }

    public function edit(User $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $member->id,
        ];

        // Validasi password opsional saat update
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // Jangan ubah password jika kosong
        }

        $member->update($validated);

        return redirect()->route('admin.members.index')
                         ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(User $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')
                         ->with('success', 'Data anggota berhasil dihapus.');
    }
}
