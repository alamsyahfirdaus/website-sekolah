<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna (Admin & Operator).
     * DataTables menangani pencarian, pengurutan, dan pagination.
     */
    public function index()
    {
        // Ambil semua data user terbaru tanpa filter search manual di controller
        $users = User::latest()->get();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Menampilkan form untuk menambah pengguna baru.
     */
    public function create()
    {
        return view('admin.user.form');
    }

    /**
     * Menampilkan form untuk mengedit pengguna yang sudah ada.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.form', compact('user'));
    }

    /**
     * Menyimpan data pengguna (gabungan Tambah dan Ubah).
     * Jika $id ada -> Ubah (Edit)
     * Jika $id kosong -> Tambah Baru
     */
    public function save(Request $request, $id = null)
    {
        // 1. Validasi input
        $request->validate([
            'name'     => 'required|string|max:50',
            'username' => 'nullable|string|max:30|unique:users,username,' . ($id ?? 'NULL') . ',id',
            'email'    => 'required|email|unique:users,email,' . ($id ?? 'NULL') . ',id',
            'role'     => 'required|in:Admin,Operator,admin,operator',
            'password' => $id ? 'nullable|min:6' : 'required|min:6',
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'username.unique'   => 'Username sudah digunakan oleh akun lain.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar pada akun lain.',
            'role.required'     => 'Pilih role pengguna (Admin atau Operator).',
            'role.in'           => 'Pilihan role tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal terdiri dari 6 karakter.',
        ]);

        // 2. Tentukan model (Tambah atau Ubah)
        if ($id) {
            $user = User::findOrFail($id);
        } else {
            $user = new User();
        }

        // 3. Masukkan data ke model
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = ucfirst(strtolower($request->role)); // Disimpan rapi: 'Admin' atau 'Operator'

        // 4. Pengaturan username: jika diisi gunakan input, jika kosong buat dari email
        if ($request->filled('username')) {
            $user->username = $request->username;
        } elseif (!$id) {
            // Otomatis buat username dari bagian depan email jika belum ada
            $baseUsername = strtolower(explode('@', $request->email)[0]);
            $username = $baseUsername;
            $counter = 1;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }
            $user->username = $username;
        }

        // 5. Password: hanya diubah jika diisi oleh pengguna
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 6. Simpan ke database
        $user->save();

        return redirect()
            ->route('admin.user.index')
            ->with('success', $id ? 'Data pengguna berhasil diperbarui.' : 'Data pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail informasi pengguna.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.show', compact('user'));
    }

    /**
     * Menghapus pengguna dari database.
     * Mencegah admin menghapus akun dirinya sendiri yang sedang login.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Proteksi: jangan izinkan menghapus diri sendiri
        if ($user->id == auth()->id()) {
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Data pengguna berhasil dihapus.');
    }
}
