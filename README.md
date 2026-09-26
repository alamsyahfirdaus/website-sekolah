# Website Sekolah — Media Pembelajaran Siswa SMK

Project ini adalah website administrasi sekolah berbasis **Laravel + AdminLTE v4** yang dirancang khusus sebagai materi praktik dan modul pembelajaran bagi siswa SMK jurusan PPLG / RPL / SIJA.

Kode dibuat dengan pola standar Laravel yang **sederhana, bersih, dan mudah dipahami** tanpa arsitektur kompleks (seperti Repository Pattern atau Service Layer yang berlebihan).

---

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 12
- **Bahasa Pemrograman**: PHP ^8.2
- **Basis Data**: MySQL
- **Template Admin**: AdminLTE v4.9.1 (Bootstrap 5.3 + Bootstrap Icons)
- **Templating Engine**: Laravel Blade

---

## 🚀 Fitur Sistem

1. **Autentikasi Admin**:
   - Login admin & operator (`/login`).
   - Logout sistem aman dengan proteksi session token.
2. **Dashboard Statistik**:
   - Widget Small Box AdminLTE (Total Guru, Total Siswa, Total Berita, Total Ekstrakurikuler, Total Galeri).
   - Ringkasan profil sekolah dan daftar berita terbaru.
3. **Profil Sekolah (Bukan CRUD)**:
   - Menampilkan satu data profil sekolah lengkap (NPSN, Kepala Sekolah, Alamat, Visi Misi, Logo).
   - Form update profil sekolah dan upload logo / foto gedung.
4. **Kelola Guru (CRUD Lengkap)**:
   - Tambah data guru beserta foto.
   - Tabel data guru dengan thumbnail foto, NIP, mapel.
   - Pencarian data & pagination.
   - Detail data guru beserta ekskul yang dibina.
   - Edit data guru dan konfirmasi hapus data.
5. **Kelola Siswa (CRUD Lengkap)**:
   - Tambah, lihat, edit, dan hapus data siswa.
   - Validasi NISN 10 digit, nama, jenis kelamin, dan angkatan.
   - Pencarian siswa & pagination.
6. **Kelola Berita (CRUD Lengkap)**:
   - Tulis berita baru dengan foto sampul (cover).
   - Relasi otomatis ke user yang sedang login sebagai penulis.
   - Detail artikel berita, edit, hapus, dan pagination.
7. **Kelola Ekstrakurikuler (CRUD Lengkap)**:
   - Tambah ekskul dengan relasi ke guru pembina (`belongsTo`).
   - Jadwal latihan, deskripsi, foto kegiatan, edit, dan hapus.
8. **Kelola Galeri (CRUD Lengkap)**:
   - Tampilan Card / Grid dokumentasi foto dan video.
   - Upload file media (foto/video), kategori, tanggal kegiatan, edit, dan hapus.

---

## 📚 Konsep Laravel yang Dipelajari

1. **Route (`routes/web.php`)**:
   - Mendefinisikan URL dan menghubungkannya ke Controller yang bersangkutan.
2. **Controller (`app/Http/Controllers/`)**:
   - Mengatur logika alur data: memproses request, validasi, memanggil model, dan mengirim data ke Blade View.
3. **Model & Eloquent ORM (`app/Models/`)**:
   - Representasi tabel database, `$fillable` untuk mass assignment, dan relasi (`belongsTo`, `hasMany`).
4. **Migration (`database/migrations/`)**:
   - Merancang skema tabel database dengan kode PHP terstruktur.
5. **Blade View (`resources/views/`)**:
   - Menyajikan antarmuka pengguna, templating inheritance (`@extends`, `@section`, `@yield`).
6. **CRUD & Validasi**:
   - Create, Read, Update, Delete menggunakan method HTTP (`GET`, `POST`, `PUT`, `DELETE`).
   - Validasi input form `$request->validate()` dan pesan error `@error`.
7. **Upload & Manajemen File**:
   - Menyimpan gambar menggunakan Laravel Storage (`public` disk) dan menghapus file lama saat diupdate.
8. **Pagination & Pencarian**:
   - Membatasi jumlah baris per halaman (`paginate(10)`) dan filter query `where(...)`.
9. **Flash Messages**:
   - Menampilkan notifikasi sukses/gagal operasi menggunakan `session('success')`.

---

## 🔄 Alur Pembelajaran (Request-Response Lifecycle)

Siswa SMK dapat memahami alur kerja fitur dengan urutan mudah berikut:

```text
DATABASE ➔ MODEL ➔ CONTROLLER ➔ ROUTE ➔ BLADE VIEW ➔ USER
```

### Contoh Alur: Menampilkan Data Guru (`/admin/guru`)

1. **User** membuka URL browser: `http://localhost:8000/admin/guru`.
2. **Route** (`routes/web.php`) mendeteksi request dan memanggil:
   ```php
   Route::get('/admin/guru', [GuruController::class, 'index'])->name('admin.guru');
   ```
3. **Controller** (`GuruController@index`) menjalankan query Model:
   ```php
   $gurus = Guru::latest()->paginate(10);
   ```
4. **Model** (`App\Models\Guru`) mengambil data dari tabel `guru` di MySQL.
5. **Controller** mengirim data `$gurus` ke view:
   ```php
   return view('admin.guru.index', ['gurus' => $gurus]);
   ```
6. **Blade View** (`resources/views/admin/guru/index.blade.php`) merender tabel HTML dan komponen AdminLTE.
7. **User** melihat daftar guru di layar browser.

---

## 🔑 Akun Default untuk Pengujian

- **Email**: `admin@sekolah.sch.id`
- **Password**: `password`
- **Role**: `Admin`

---

## 💻 Panduan Menjalankan Project

1. Pastikan server web dan database MySQL telah berjalan (XAMPP / Laragon / Native).
2. Salin file `.env.example` menjadi `.env` dan sesuaikan koneksi database (`DB_DATABASE=db_profil_sekolah`).
3. Jalankan migrasi dan seeder awal:
   ```bash
   php artisan migrate --seed
   ```
4. Hubungkan folder storage publik:
   ```bash
   php artisan storage:link
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
6. Buka di browser: `http://127.0.0.1:8000`.
