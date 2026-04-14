<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar anggota beserta fitur pencarian & pagination.
     */
    public function index(Request $request)
    {
        $query = \App\Models\User::query();

        // Fitur Pencarian Nama/Email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Fitur Filter Role (Admin/Siswa)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $members = $query->latest()->paginate(10);
        $members->appends($request->all());

        return view('admin.members.index', compact('members'));
    }

    /**
     * Menampilkan halaman form tambah anggota.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Menyimpan data anggota baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Simpan ke database dengan role default 'siswa'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa', // Otomatis jadikan siswa
        ]);

        return redirect()->route('admin.members.index')
                         ->with('success', 'Anggota baru berhasil didaftarkan!');
    }

    /**
     * Menampilkan halaman form edit anggota.
     */
    public function edit($id)
    {
        $member = User::findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Menyimpan perubahan data anggota ke database.
     */
    public function update(Request $request, $id)
    {
        $member = User::findOrFail($id);

        // Validasi input (email boleh sama dengan emailnya sendiri, tapi tidak boleh sama dengan orang lain)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$member->id],
        ]);

        // Siapkan data yang akan diupdate
        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika form password diisi, berarti admin ingin mereset password siswa tersebut
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $member->update($dataToUpdate);

        return redirect()->route('admin.members.index')
                         ->with('success', 'Data anggota berhasil diperbarui!');
    }

    /**
     * Menghapus anggota dari database.
     */
    public function destroy($id)
    {
        $member = User::findOrFail($id);
        
        // Opsional: Pastikan admin tidak bisa menghapus dirinya sendiri dari halaman ini
        if ($member->role === 'admin') {
            return back()->with('error', 'Akun Administrator tidak boleh dihapus dari sini!');
        }

        $member->delete();

        return redirect()->route('admin.members.index')
                         ->with('success', 'Anggota berhasil dihapus dari sistem!');
    }
}