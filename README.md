# SIPAT - Sistem Peminjaman Alat

Sistem berbasis web untuk mengelola peminjaman alat laboratorium/sekolah dengan alur persetujuan dan pengembalian yang jelas. Dilengkapi tracking 3 tanggal penting untuk memantau keterlambatan.

Dibangun menggunakan **Laravel 11** dengan fokus pada kejelasan status data dan alur sistem yang realistis.

---

## ✨ Fitur

### 👤 **User**
- Lihat katalog alat + stok tersedia
- Ajukan peminjaman alat
- Lihat riwayat peminjaman pribadi
- Ajukan pengembalian alat

### 👑 **Admin**
- Kelola data alat (CRUD + foto)
- Lihat semua peminjaman dengan filter status
- Setujui/tolak peminjaman
- Tentukan deadline pengembalian (durasi/tanggal)
- Konfirmasi penerimaan alat kembali
- Pantau keterlambatan

### 📊 **Manajemen Status**
- `pending` - Menunggu persetujuan admin
- `approved` - Disetujui, alat sedang dipinjam
- `pending_return` - User mengajukan pengembalian
- `returned` - Dikembalikan & dikonfirmasi admin
- `rejected` - Ditolak admin

### 📅 **Tracking 3 Tanggal Penting**
- `tgl_pinjam` - Tanggal admin menyetujui & menyerahkan alat
- `tgl_kembali_admin` - Deadline yang ditentukan admin
- `tgl_pengembalian_user` - Tanggal real user mengembalikan
- ✅ Deteksi otomatis: **Tepat waktu / Telat**

### 🔄 **Sistem Otomatis**
- Stok berkurang otomatis saat admin approve
- Stok bertambah otomatis saat admin konfirmasi pengembalian
- Status berubah sesuai alur yang ditentukan

---

## 🎯 Alur Peminjaman

```
1. User ajukan peminjaman → status: pending
2. Admin review:
   - Setujui + pilih durasi (1/3/7/14/30 hari) → status: approved, stok berkurang
   - Tolak → status: rejected
3. User pakai alat, setelah selesai ajukan pengembalian → status: pending_return
4. Admin terima alat fisik, konfirmasi di sistem → status: returned, stok bertambah
5. Sistem otomatis catat tgl_pengembalian_user & deteksi telat
```

---

## 🛠 Teknologi yang Digunakan

- **Laravel 11** - Framework PHP
- **MySQL** - Database
- **Blade Template** - Templating engine
- **Bootstrap 5** - Styling & UI
- **Carbon** - Manajemen tanggal

---

## 📦 Instalasi

```bash
# Clone repository
git clone https://github.com/dhitoafrian/peminjaman-alat-sekolah.git
cd peminjaman-alat-sekolah

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database (sesuaikan .env)
php artisan migrate

# Jalankan aplikasi
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

---

## 📝 Catatan

- Akun admin default: `admin@example.com` / `password`
- Akun user default: `user@example.com` / `password`
- Role otomatis terisi saat register (default: user)

---

## 🤝 Kontributor

- **Dhito Afrian Pramudhitia** - [GitHub](https://github.com/dhitoafrian)

---

## 📄 Lisensi

Proyek ini dibuat untuk tujuan **tugas sekolah/presentasi**.
