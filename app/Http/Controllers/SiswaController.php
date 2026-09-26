<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa.
     * Pencarian, sorting, dan pagination ditangani langsung oleh DataTables.
     */
    public function index()
    {
        $siswa = Siswa::latest()->get();

        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Menampilkan form untuk menambah siswa baru.
     */
    public function create()
    {
        return view('admin.siswa.form');
    }

    /**
     * Menampilkan form untuk mengedit siswa yang sudah ada.
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.siswa.form', compact('siswa'));
    }

    /**
     * Menyimpan data siswa (gabungan Tambah dan Ubah).
     */
    public function save(Request $request, $id = null)
    {
        // 1. Validasi input
        $request->validate([
            'nisn'          => 'required|digits:10|unique:siswa,nisn,' . ($id ?? 'NULL') . ',id',
            'nama_siswa'    => 'required|string|max:40',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tahun_masuk'   => 'required|digits:4|integer',
        ], [
            'nisn.required'          => 'NISN wajib diisi.',
            'nisn.digits'            => 'NISN harus 10 digit angka.',
            'nisn.unique'            => 'NISN sudah terdaftar pada siswa lain.',
            'nama_siswa.required'    => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'tahun_masuk.required'   => 'Tahun masuk wajib diisi.',
            'tahun_masuk.digits'     => 'Tahun masuk harus 4 digit angka (contoh: 2024).',
        ]);

        // 2. Tentukan model (Tambah atau Ubah)
        if ($id) {
            $siswa = Siswa::findOrFail($id);
        } else {
            $siswa = new Siswa();
        }

        // 3. Masukkan data ke model
        $siswa->nisn          = $request->nisn;
        $siswa->nama_siswa    = $request->nama_siswa;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->tahun_masuk   = $request->tahun_masuk;

        // 4. Simpan ke database
        $siswa->save();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', $id ? 'Data siswa berhasil diperbarui.' : 'Data siswa berhasil disimpan.');
    }

    /**
     * Menampilkan detail seorang siswa.
     */
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Menghapus data siswa dari database.
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
