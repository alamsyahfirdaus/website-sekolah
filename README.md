# Website Sekolah

Project website administrasi sekolah berbasis **Laravel + AdminLTE + DataTables** yang dirancang sebagai materi pembelajaran praktis, sederhana, dan mudah dipelajari untuk siswa SMK.

---

## Teknologi

- **Laravel**: Framework backend MVC PHP
- **PHP**: ^8.2
- **MySQL**: Basis data relasional
- **Blade**: Templating engine Laravel
- **AdminLTE**: Template antarmuka admin responsif (Bootstrap 5)
- **DataTables**: Plugin tabel interaktif (Search, Sort, Pagination sisi klien)

---

## Fitur

1. **Login & Logout**: Sistem autentikasi aman dengan session dan proteksi CSRF.
2. **Dashboard**: Menampilkan statistik hitungan data langsung dari database menggunakan AdminLTE Small Box.
3. **Profil Sekolah**: Mengelola satu data profil sekolah, visi misi, serta unggah logo dan foto gedung sekolah (bukan CRUD biasa).
4. **Guru**: CRUD tenaga pendidik dengan foto, NIP, nama, dan mapel.
5. **Siswa**: CRUD data siswa dengan NISN, nama, jenis kelamin, dan tahun masuk.
6. **Berita**: CRUD berita dan artikel sekolah dengan unggah foto sampul.
7. **Ekstrakurikuler**: CRUD kegiatan ekskul sekolah beserta guru pembinanya.
8. **Galeri**: CRUD dokumentasi kegiatan sekolah berupa foto dan video.

---

## Konsep yang Dipelajari

- **Routing**: Pengelompokan rute admin dengan middleware auth (`Route::middleware('auth')->prefix('admin')`).
- **Middleware**: Membatasi akses pengguna yang belum login agar diarahkan ke halaman login.
- **Controller**: Mengatur alur logika data dengan metode sederhana (`index`, `save`, `show`, `destroy`).
- **Model**: Representasi tabel database dan mass assignment (`$fillable`).
- **Migration**: Pembuatan struktur tabel dan tipe data secara terstruktur.
- **Eloquent**: Relasi antar tabel (`belongsTo`, `hasMany`).
- **Blade**: Master layout, pemisahan komponen (`@extends`, `@section`, `@yield`).
- **CRUD**: Pola gabungan Tambah dan Ubah dalam satu metode `save(Request $request, $id = null)` dan satu tampilan `form.blade.php`.
- **Validation**: Memvalidasi input pengguna secara deklaratif (`$request->validate()`) dan menampilkan pesan error di form.
- **Upload File**: Mengunggah foto/gambar ke direktori publik (`storage`) dan menghapus file lama saat diperbarui.
- **DataTables**: Mengelola pencarian instan, pengurutan kolom, dan pagination secara otomatis di sisi browser tanpa query manual di Controller.
- **Authentication**: Manajemen otentikasi login, regenerasi session, dan logout.

---

## Alur CRUD

Proses pengelolaan data berjalan dengan alur:

```text
Form
 ↓
Route
 ↓
Controller
 ↓
Model
 ↓
Database
```

### Penjelasan Alur:
1. **Form (`form.blade.php`)**: Pengguna mengisi data pada form HTML (Tambah atau Ubah).
2. **Route (`routes/web.php`)**: Menerima request HTTP POST dan meneruskannya ke Controller yang sesuai.
3. **Controller (`*Controller@save`)**: Melakukan validasi input, menentukan apakah data baru atau data lama berdasarkan parameter ID, mengunggah file jika ada, dan menyimpan data.
4. **Model (`App\Models\*`)**: Menyediakan akses manipulasi ke tabel database menggunakan Eloquent ORM.
5. **Database (MySQL)**: Menyimpan record data secara persisten.

---

## Akun Default untuk Praktik Siswa

- **URL Login**: `http://localhost:8000/login`
- **Email**: `admin@sekolah.sch.id`
- **Password**: `password`

---

## Panduan Menjalankan Project

1. Pastikan server web dan database MySQL telah berjalan (XAMPP / Laragon).
2. Salin `.env.example` ke `.env` dan sesuaikan koneksi database:
   ```env
   DB_DATABASE=db_profil_sekolah
   ```
3. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate --seed
   ```
4. Hubungkan storage publik:
   ```bash
   php artisan storage:link
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
6. Buka aplikasi di browser pada: `http://127.0.0.1:8000`.
