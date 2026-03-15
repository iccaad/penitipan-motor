# Penitipan Motor — Dokumentasi Proyek

Dokumentasi lengkap untuk proyek Penitipan Motor (Laravel 11 + PostgreSQL). Dokumen ini menjelaskan struktur proyek, cara menyiapkan lingkungan pengembangan, menjalankan aplikasi, dan ringkasan fitur serta arsitektur utama.

Catatan: panduan berikut ditulis dalam bahasa Indonesia dengan gaya profesional untuk memudahkan developer lain atau tim operasi.

---

## Ringkasan Proyek

Proyek ini adalah aplikasi web sederhana untuk manajemen penitipan motor. Fitur utama:
- Form publik untuk mendaftarkan penitipan motor (dengan unggah foto motor dan kompresi gambar).
- Halaman sukses yang menampilkan nomor kode penitipan unik.
- Panel admin untuk mengelola data penitipan: daftar, pencarian/filter, pagination, detail, edit, verifikasi pengambilan, dan penghapusan.
- Statistik dasar (Chart.js) untuk status penitipan.

Teknologi utama: Laravel 11 (PHP), PostgreSQL, Tailwind CSS, Chart.js, Intervention Image (untuk pemrosesan gambar).

---

## Prasyarat

- PHP 8.1+ (sesuaikan dengan requirement Laravel 11)
- Composer
- Node.js + npm / pnpm (untuk build asset)
- PostgreSQL (atau DB lain jika dikonfigurasi ulang)
- Ekstensi PHP umum: pdo, pdo_pgsql, mbstring, openssl, fileinfo, gd atau imagick (Intervention Image membutuhkan GD/Imagick)

Pastikan juga `storage` memiliki permission yang sesuai agar file uploaded dapat disimpan.

---

## Instalasi & Setup (Pengembangan)

1. Kloning repository dan buka folder proyek:

```bash
git clone <repo-url>
cd penitipan-motor
```

2. Pasang dependensi PHP:

```bash
composer install
```

3. Pasang dependensi Node dan build asset (opsional selama dev):

```bash
npm install
npm run dev
# atau untuk produksi
npm run build
```

4. Salin file environment dan atur konfigurasi database di `.env`:

```bash
cp .env.example .env
# edit .env -> sesuaikan DB_CONNECTION=pgsql, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD, dll.
```

5. Buat key aplikasi Laravel:

```bash
php artisan key:generate
```

6. Jalankan migrasi database:

```bash
php artisan migrate
```

7. Buat symbolic link untuk storage agar gambar bisa diakses publik:

```bash
php artisan storage:link
```

8. (Opsional) Pasang package tambahan jika belum ada (Intervention Image):

```bash
composer require intervention/image
```

9. Jalankan server development:

```bash
php artisan serve
```

Setelah langkah-langkah ini, buka http://127.0.0.1:8000 untuk mengakses aplikasi.

---

## Struktur Folder Penting

Berikut poin-poin penting pada struktur proyek (hanya folder/file yang relevan untuk fitur penitipan):

- `app/Models/PenitipanMotor.php` — Eloquent model untuk tabel `penitipan_motor`. Memiliki method statis `generateKodeTitip()` untuk membuat kode penitipan unik.
- `database/migrations/*create_penitipan_motor_table.php` — Migrasi yang membuat tabel `penitipan_motor` dengan field seperti `kode_penitipan`, `nama_penitip`, `nomor_polisi`, `foto_motor`, `tanggal_titip`, `tanggal_rencana_ambil`, `tanggal_ambil`, `waktu_ambil`, `status`, dll.
- `app/Http/Controllers/PenitipanController.php` — Controller publik yang meng-handle form penitipan, validasi, pemrosesan gambar (Intervention Image), penyimpanan file ke `storage/app/public/motor`, dan halaman sukses.
- `app/Http/Controllers/AdminController.php` — Controller untuk area admin: login/auth, dashboard (statistik + preview terbaru), daftar penitipan (search/filter/pagination), detail, edit, update, verifikasi ambil, dan hapus.
- `app/Http/Middleware/AdminAuthMiddleware.php` — Middleware sederhana untuk mengamankan rute admin (cek session login admin).
- `routes/web.php` — Semua rute frontend dan admin (dengan prefix `/admin` dan middleware `admin`). Gunakan nama rute seperti `penitipan.form`, `penitipan.store`, `admin.dashboard`, `admin.penitipan.index`, dll.
- `resources/views/` — Blade views: public (landing, form, sukses) dan admin (layout, login, dashboard, penitipan/index, penitipan/detail, penitipan/edit).
- `public/` — Assets publik; build hasil Vite berada di `public/build` (tergantung konfigurasi Vite).
- `storage/app/public/motor` — Folder tempat foto motor disimpan (akses publik via `storage` symlink).

---

## Rute Penting (Ringkasan)

Catatan: gunakan `php artisan route:list` untuk daftar rute lengkap. Beberapa rute utama:

- Publik:
	- `GET /` -> landing
	- `GET /penitipan/form` -> formulir penitipan
	- `POST /penitipan` -> simpan penitipan
	- `GET /penitipan/sukses/{kode}` -> halaman sukses/struk

- Admin (prefix `/admin`):
	- `GET /admin/login` -> halaman login admin
	- `POST /admin/login` -> autentikasi admin
	- `GET /admin/dashboard` -> dashboard statistik
	- `GET /admin/penitipan` -> daftar penitipan (search/filter/pagination)
	- `GET /admin/penitipan/{id}` -> detail penitipan
	- `GET /admin/penitipan/{id}/edit` -> edit
	- `PUT /admin/penitipan/{id}` -> update
	- `DELETE /admin/penitipan/{id}` -> hapus
	- `POST /admin/penitipan/{id}/ambil` -> verifikasi pengambilan
	- `GET /admin/statistik` -> endpoint JSON statistik untuk Chart.js

---

## Model & Migrasi (Detail singkat)

Tabel `penitipan_motor` menyimpan informasi penitipan motor. Field penting antara lain:
- `id` (PK)
- `kode_penitipan` (string, unik) — dibuat oleh `PenitipanMotor::generateKodeTitip()`
- `nama_penitip`, `no_hp`, `nomor_polisi`, `merk_motor`, `tipe_motor`, `cc_motor`, `warna_motor`
- `foto_motor` (path file pada storage)
- `tanggal_titip`, `tanggal_rencana_ambil`, `tanggal_ambil`, `waktu_ambil` (nullable jika belum diambil)
- `status` (int, default 0: dititip, 1: sudah diambil)

Untuk migrasi dan modifikasi skema, gunakan mekanisme migrasi Laravel.

---

## Controller & Alur Kerja

- `PenitipanController@showForm` — menampilkan form penitipan kepada publik.
- `PenitipanController@storePenitipan` — memvalidasi input, menggunakan Intervention Image untuk resize/kompresi gambar, menyimpan gambar di `storage/app/public/motor`, membuat record di DB, lalu redirect ke halaman sukses dengan kode.
- `AdminController` — mengelola login/admin session, menampilkan dashboard, mengambil data statistik (JSON), dan CRUD penitipan.

Tip: pastikan package `intervention/image` terpasang dan PHP memiliki ekstensi GD atau Imagick.

---

## Views & Layout

- `resources/views/admin/layout.blade.php` — layout utama admin dengan sidebar dan topbar (topbar menggunakan ikon menu pada viewport kecil dan title dynamic).
- Semua view admin (index/detail/edit/dashboard) sudah refactored untuk `@extends('admin.layout')`.

---

## Menjalankan Test & Lint (Jika Ada)

Proyek ini tidak menyertakan test suite khusus, tetapi Anda dapat menambahkan test Laravel biasa dan menjalankannya:

```bash
php artisan test
```

---

## Deployment (Catatan Singkat)

- Pastikan environment produksi menggunakan konfigurasi database yang benar.
- Jalankan `composer install --optimize-autoloader --no-dev`.
- Jalankan `npm run build` untuk aset produksi.
- Jalankan migrasi: `php artisan migrate --force`.
- Atur hak akses direktori `storage` dan `bootstrap/cache`.
- Pastikan `storage:link` dibuat jika Anda mengandalkan file storage publik.

Jika menggunakan web server seperti Nginx/Apache, arahkan document root ke folder `public/`.

---

## Troubleshooting Umum

- Error upload/gambar: pastikan `storage/app/public` writable dan `php artisan storage:link` sudah dijalankan.
- Error DB: cek konfigurasi `.env` dan koneksi PostgreSQL.
- Jika Chart.js tidak tampil: buka console browser untuk melihat request ke `GET /admin/statistik`.

---

## Keamanan & Perbaikan

- Saat ini middleware admin sederhana menggunakan session; untuk produksi pertimbangkan gunakan sistem autentikasi Laravel yang lengkap (`laravel/ui`, `sanctum`, atau `breeze`) dan aturan RBAC.
- Selalu validasi dan sanitasi input dari frontend. Gunakan `Illuminate\\Validation` untuk aturan yang lebih ketat.

---

## Kontribusi

Jika Anda ingin berkontribusi:

1. Fork repository
2. Buat branch fitur/bugfix
3. Buat PR dengan deskripsi perubahan

Pastikan perubahan mengikuti standar kode Laravel dan diuji secara lokal.

---

Jika Anda memerlukan dokumentasi lebih rinci pada bagian tertentu (mis. flow login admin, seeder admin, atau skrip deploy), beri tahu saya bagian mana yang ingin diperluas dan saya akan tambahkan.

Terima kasih.

