# Sistem Manajemen Peminjaman Perpustakaan

Sistem berbasis web untuk mengelola peminjaman buku perpustakaan dengan alur persetujuan dan pengembalian yang jelas.  
Dibangun menggunakan **Laravel** dengan fokus pada kejelasan status data dan alur sistem.



## Fitur

- Pengajuan peminjaman buku oleh user
- Persetujuan dan penolakan oleh admin
- Manajemen status peminjaman:
  - `pending` (menunggu persetujuan)
  - `approved` (disetujui)
  - `rejected` (ditolak)
  - `returned` (dikembalikan)
- Sistem otomatis selesai saat buku dikembalikan
- Riwayat peminjaman buku
- Hak akses berdasarkan peran (Admin & User)


## Alur Peminjaman

1. User mengajukan peminjaman buku
2. Status peminjaman menjadi **pending**
3. Admin melakukan review:
   - Setujui → status menjadi **approved**
   - Tolak → status menjadi **rejected**
4. User mengembalikan buku
5. Status berubah menjadi **returned** (peminjaman selesai)


## Teknologi yang Digunakan

- Laravel
- MySQL
- Blade Template
- Bootstrap (opsional)

---

## Instalasi

```bash
git clone https://github.com/dhitoafrian/peminjaman-alat-sekolah.git
cd peminjaman-alat-sekolah
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

