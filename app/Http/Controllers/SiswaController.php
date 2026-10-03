<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SiswaController extends Controller
{
    /**
     * Menampilkan semua data siswa.
     */
    public function index()
    {
        $siswa = Siswa::latest()->get();

        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Menampilkan form tambah atau ubah siswa.
     */
    public function addEdit($id = null)
    {
        try {
            $siswa = $id
                ? Siswa::findOrFail(Crypt::decrypt($id))
                : null;

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.siswa.index')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

    return view('admin.siswa.form', compact('siswa'));
    }

    /**
     * Menyimpan data baru atau mengubah data siswa.
     */
    public function save(Request $request, $id = null)
    {
        // Jika ada ID, berarti sedang mengubah data.
        if ($id) {
            try {
                $id = Crypt::decrypt($id);
                $siswa = Siswa::findOrFail($id);

            } catch (\Exception $e) {
                return redirect()
                    ->route('admin.siswa.index')
                    ->with('error', 'Data siswa tidak ditemukan.');
            }

        } else {
            // Jika tidak ada ID, berarti menambah data baru.
            $siswa = new Siswa();
        }

        // Validasi input.
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
            'tahun_masuk.digits'     => 'Tahun masuk harus 4 digit angka.',
        ]);

        // Masukkan data ke model.
        $siswa->nisn = $request->nisn;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->tahun_masuk = $request->tahun_masuk;

        // Simpan data.
        $siswa->save();

        return redirect()
            ->route('admin.siswa.index')
            ->with(
                'success',
                $id
                    ? 'Data siswa berhasil diperbarui.'
                    : 'Data siswa berhasil disimpan.'
            );
    }

    /**
     * Menampilkan detail siswa.
     */
    public function show($id)
    {
        try {
            $siswa = Siswa::findOrFail(Crypt::decrypt($id));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.siswa.index')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Menghapus data siswa.
     */
    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail(Crypt::decrypt($id));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.siswa.index')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $siswa->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}