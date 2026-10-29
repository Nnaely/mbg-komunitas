# Pondasi Laravel MBG

Kerangka awal Laravel 12 untuk Mini Project Proyek 3 Kasus A MBG.
Saat ini tersedia struktur Laravel dan pondasi data sekolah.
Tampilan tetap halaman welcome bawaan Laravel. Belum ada halaman pengelolaan sekolah,
login, distribusi makanan, atau pelaporan MBG.

## Kebutuhan

- PHP dan ekstensi sesuai `composer.lock` (diuji pada PHP 8.5).
- Composer 2.
- MySQL/MariaDB untuk tahap pengembangan data berikutnya.
- Node.js dan npm jika ingin menjalankan Vite.

## Menjalankan

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan serve
```

Buka http://127.0.0.1:8000. Pada Linux/macOS, gunakan
`cp .env.example .env` untuk menyalin konfigurasi.

Halaman welcome dapat dibuka tanpa database karena session dan cache memakai file.
Untuk frontend dengan Vite, jalankan `npm install` lalu `npm run dev` di terminal lain.

## Database

Contoh konfigurasi MySQL tersedia di `.env.example`. Buat database
`mbg_komunitas` dan sesuaikan kredensial di `.env` saat diperlukan.
Kemudian jalankan `php artisan migrate`.

Migration dan model User masih bawaan Laravel. Seeder utama sekarang hanya mengisi
data sekolah; login dan akun demo peran MBG belum tersedia.

## Pondasi data sekolah

- Migration membuat tabel `schools` dengan `id`, `name`, `address`, dan timestamps.
- Model `App\Models\School` digunakan untuk menyimpan dan membaca data sekolah.
- `SchoolSeeder` mengisi tiga sekolah fiktif. Menjalankannya kembali tidak menggandakan
  data contoh yang nama dan alamatnya masih sama, serta tidak menghapus data lain.

Setelah database MySQL/MariaDB tersedia dan kredensial `.env` sesuai, jalankan:

```powershell
php artisan migrate
php artisan db:seed
php artisan tinker
```

Di dalam Tinker, baca data sekolah dengan:

```php
\App\Models\School::all(['id', 'name', 'address']);
```

Seluruh nama dan alamat dalam seeder adalah data fiktif. Tahap ini belum menambahkan
controller, route, formulir, atau tampilan khusus sekolah.

## Pemeriksaan

```powershell
composer validate --strict
composer check-platform-reqs
php artisan test
```

Dua test bawaan Laravel memeriksa respons halaman welcome dan contoh unit test.
Tiga test sekolah memeriksa penyimpanan dan pembacaan melalui model, pengulangan
seeder tanpa duplikasi, serta pemanggilan seeder utama tanpa membuat akun.

Test database menggunakan SQLite di memori yang terpisah dari database aplikasi,
sehingga tidak mengubah data MySQL lokal. Pastikan ekstensi `pdo_sqlite` tersedia.
Pengujian ini belum memverifikasi koneksi atau perilaku khusus MySQL/MariaDB.
Jangan commit `.env`, token, atau kredensial pribadi.

## Commit pondasi

1. Kerangka Laravel
2. Konfigurasi Lingkungan
3. Kompatibilitas PHP
4. Panduan Instalasi

## Commit pondasi sekolah

1. Migrasi Sekolah
2. Model Sekolah
3. Data Contoh Sekolah
4. Pengujian Data Sekolah
