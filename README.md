# InventarisPro — Inventory Management System

Aplikasi manajemen inventaris berbasis Laravel untuk mengelola produk, kategori, pemasok, persediaan, serta transaksi barang masuk dan keluar.

## 1. Teknologi

- PHP 8.2+
- Laravel 12
- MySQL
- Blade Template Engine
- Eloquent ORM
- HTML dan CSS

## 2. Fitur Aplikasi

### Autentikasi dan Hak Akses
- Login dan logout pengguna.
- Dua peran pengguna: Admin dan Staff.
- Pembatasan akses pengelolaan data master berdasarkan peran.

### Dashboard
- Total produk.
- Nilai persediaan.
- Jumlah produk dengan stok rendah dan stok habis.
- Total kuantitas barang masuk dan barang keluar.
- Pergerakan stok terbaru.

### Pengelolaan Data Master
- CRUD kategori.
- CRUD produk.
- CRUD pemasok.
- Relasi banyak-ke-banyak antara produk dan pemasok.
- Pencarian, filter, dan paginasi sesuai halaman.

### Transaksi Persediaan
- Pencatatan barang masuk.
- Pencatatan barang keluar.
- Riwayat pergerakan stok.
- Penyimpanan informasi stok sebelum dan sesudah transaksi.
- Validasi jumlah transaksi dan perlindungan dari stok negatif.
- Transaksi database untuk menjaga konsistensi perubahan stok.

## 3. Struktur Laravel

- `app/Models/` — model dan relasi data.
- `app/Http/Controllers/` — autentikasi, dashboard, data master, dan transaksi stok.
- `database/migrations/` — struktur tabel database.
- `database/factories/` — factory untuk data contoh.
- `database/seeders/` — pengisian data awal dan akun demo.
- `resources/views/` — halaman antarmuka menggunakan Blade.
- `routes/web.php` — definisi rute aplikasi.
- `tests/` — pengujian otomatis.

## 4. Persiapan Instalasi

Pastikan PHP, Composer, dan MySQL tersedia. Untuk lingkungan lokal Windows, XAMPP dapat digunakan.

1. Buat database MySQL bernama `inventory_db` melalui phpMyAdmin.
2. Buka terminal pada folder proyek.
3. Pasang dependency:

   ```bash
   composer install
   ```

4. Salin `.env.example` menjadi `.env` jika file `.env` belum tersedia.
5. Sesuaikan konfigurasi database pada `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Sesuaikan username dan password dengan konfigurasi MySQL lokal.

6. Buat application key:

   ```bash
   php artisan key:generate
   ```

7. Jalankan migrasi dan seeder:

   ```bash
   php artisan migrate --seed
   ```

8. Jalankan server pengembangan:

   ```bash
   php artisan serve
   ```

9. Buka `http://127.0.0.1:8000` di browser.

> Catatan: langkah instalasi di atas ditujukan untuk database baru. Jangan menjalankan `php artisan migrate:fresh` pada database yang berisi data penting karena perintah tersebut menghapus tabel sebelum membuatnya kembali.

## 5. Akun Demo Lokal

| Peran | Username | Password |
|---|---|---|
| Admin | `admin` | `admin123` |
| Staff | `staff` | `staff123` |

Akun tersebut hanya untuk pengembangan dan demonstrasi lokal. Ganti password sebelum aplikasi digunakan di lingkungan nyata.

## 6. Pengujian Otomatis

Jalankan pengujian menggunakan perintah:

```bash
php artisan test
```

Pengujian otomatis mencakup:

- Pengalihan pengunjung yang belum login ke halaman login.
- Login menggunakan kredensial valid dan penolakan password yang salah.
- Logout pengguna.
- Hak akses Admin dan Staff terhadap halaman pengelolaan data master.
- Akses Staff ke halaman operasional stok.
- Transaksi barang masuk dan pencatatan riwayat stok.
- Transaksi barang keluar dan pencatatan riwayat stok.
- Penolakan transaksi barang keluar yang melebihi stok tersedia.
- Pembuatan produk dengan beberapa pemasok.
- Perubahan relasi pemasok tanpa mengubah stok produk.

**Hasil pengujian otomatis terakhir: 13 passed, 0 failed (49 assertions).**

Pengujian ini mencakup alur yang disebutkan di atas, bukan seluruh kemungkinan kasus pada setiap fitur aplikasi.

## 7. Catatan Keamanan

- Jangan membagikan file `.env` yang berisi konfigurasi rahasia.
- Jangan mengunggah password atau kredensial database ke repositori publik.
- Gunakan password yang kuat pada lingkungan produksi.
- Verifikasi konfigurasi dan pengujian sebelum deployment.
