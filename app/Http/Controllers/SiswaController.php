<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar seluruh siswa dengan pencarian dan pagination.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi query model Siswa
        $query = Siswa::query();

        // 2. Filter pencarian berdasarkan nama, NISN, atau tahun masuk
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_siswa', 'like', "%{$keyword}%")
                  ->orWhere('nisn', 'like', "%{$keyword}%")
                  ->orWhere('tahun_masuk', 'like', "%{$keyword}%")
                  ->orWhere('jenis_kelamin', 'like', "%{$keyword}%");
            });
        }

        // 3. Ambil data dengan pagination 10 item per halaman
        $siswas = $query->latest()->paginate(10)->withQueryString();

        return view('admin.siswa.index', [
            'title'  => 'Kelola Siswa',
            'siswas' => $siswas,
            'search' => $request->search,
        ]);
    }

    /**
     * Menampilkan form untuk menambah data siswa.
     */
    public function create()
    {
        return view('admin.siswa.create', [
            'title' => 'Tambah Siswa',
        ]);
    }

    /**
     * Menyimpan data siswa baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nisn'          => 'required|digits:10|unique:siswa,nisn',
            'nama_siswa'    => 'required|string|max:40',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tahun_masuk'   => 'required|digits:4|integer',
        ], [
            'nisn.required'          => 'NISN wajib diisi.',
            'nisn.digits'            => 'NISN harus terdiri dari 10 digit angka.',
            'nisn.unique'            => 'NISN sudah terdaftar.',
            'nama_siswa.required'    => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'tahun_masuk.required'   => 'Tahun masuk wajib diisi.',
            'tahun_masuk.digits'     => 'Tahun masuk harus 4 digit tahun (contoh: 2024).',
        ]);

        // 2. Simpan ke database
        Siswa::create($validated);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail informasi seorang siswa.
     */
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.siswa.show', [
            'title' => 'Detail Siswa',
            'siswa' => $siswa,
        ]);
    }

    /**
     * Menampilkan form edit data siswa.
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.siswa.edit', [
            'title' => 'Edit Siswa',
            'siswa' => $siswa,
        ]);
    }

    /**
     * Memperbarui data siswa di database.
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        // 1. Validasi input
        $validated = $request->validate([
            'nisn'          => 'required|digits:10|unique:siswa,nisn,' . $siswa->id,
            'nama_siswa'    => 'required|string|max:40',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tahun_masuk'   => 'required|digits:4|integer',
        ], [
            'nisn.required'          => 'NISN wajib diisi.',
            'nisn.digits'            => 'NISN harus terdiri dari 10 digit angka.',
            'nisn.unique'            => 'NISN sudah terdaftar pada siswa lain.',
            'nama_siswa.required'    => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'tahun_masuk.required'   => 'Tahun masuk wajib diisi.',
            'tahun_masuk.digits'     => 'Tahun masuk harus 4 digit tahun (contoh: 2024).',
        ]);

        // 2. Update database
        $siswa->update($validated);

        // 3. Redirect kembali dengan notifikasi sukses
        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa dari database.
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil dihapus.');
    }
}
