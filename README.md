# Kampus Marketplace

Aplikasi web marketplace sederhana berbasis **Laravel 12** untuk lingkungan kampus. Memungkinkan mahasiswa, dosen, dan staf kampus untuk melakukan jual beli barang yang berkaitan dengan kebutuhan akademik.

## Fitur Utama

- **Authentication**: Register, Login, Logout dengan role (mahasiswa, dosen, staf)
- **CRUD Produk**: Tambah, edit, hapus, dan lihat produk
- **Pencarian Produk**: Cari produk berdasarkan nama
- **Keranjang Belanja**: Tambah produk ke keranjang dan kelola quantity
- **Checkout & Order**: Buat pesanan sederhana (tanpa payment gateway)
- **Chat**: Kirim pesan ke penjual (non-realtime)

## Tech Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Template Engine**: Blade
- **CSS Framework**: Bootstrap 5
- **Database**: MySQL 8.0+ / MariaDB 10.3+
- **Icons**: Bootstrap Icons

## Persyaratan Sistem

- PHP >= 8.2
- Composer 2.x
- MySQL >= 8.0 atau MariaDB >= 10.3
- Node.js & NPM (opsional)

## Instalasi

### 1. Extract Repository

```bash
cd kampus-marketplace
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kampus_marketplace
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Database

```bash
mysql -u root -p
CREATE DATABASE kampus_marketplace;
exit
```

### 5. Jalankan Migration

```bash
php artisan migrate
```

### 6. Buat Storage Link

```bash
php artisan storage:link
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## Struktur Database

### Tabel Users
- id, name, email, password, role (mahasiswa/dosen/staf), timestamps

### Tabel Products
- id, user_id, nama_barang, deskripsi, harga, foto, kondisi (baru/bekas), timestamps

### Tabel Carts
- id, user_id, product_id, quantity, timestamps

### Tabel Orders
- id, user_id, total_harga, status (pending/selesai), timestamps

### Tabel Order_Items
- id, order_id, product_id, quantity, harga, timestamps

### Tabel Messages
- id, sender_id, receiver_id, product_id, message, is_read, timestamps

## Role User

1. **Mahasiswa**: Dapat jual dan beli barang
2. **Dosen**: Dapat jual dan beli barang
3. **Staf**: Dapat jual dan beli barang

Role hanya untuk identitas, tidak ada permission kompleks.

## Alur Penggunaan

### Sebagai Penjual:
1. Register/Login
2. Klik "Tambah Produk"
3. Isi detail produk dan upload foto
4. Produk akan tampil di halaman utama
5. Tunggu pembeli menghubungi atau memesan

### Sebagai Pembeli:
1. Register/Login
2. Cari produk yang diinginkan
3. Klik "Tambah ke Keranjang"
4. Buka halaman Keranjang
5. Klik "Checkout" untuk membuat pesanan
6. Hubungi penjual untuk pembayaran

### Chat:
1. Dari halaman produk, klik "Chat Penjual"
2. Tulis pesan dan kirim
3. Lihat inbox untuk melihat percakapan

## Perubahan Laravel 12

Proyek ini menggunakan Laravel 12 dengan fitur-fitur baru:

- **PHP 8.2+** requirement
- **Pest** sebagai default testing framework
- **Simplified bootstrap** structure
- **New middleware** configuration
- **Improved routing** system
- **Better performance** optimizations

## Catatan Penting

- Tidak ada payment gateway (pembayaran manual)
- Tidak ada realtime chat (refresh untuk update pesan)
- Tidak ada notifikasi
- Foto produk disimpan di `storage/app/public/products`

## Testing dengan Pest

Laravel 12 menggunakan Pest sebagai default testing framework:

```bash
# Run tests
./vendor/bin/pest

# Run with coverage
./vendor/bin/pest --coverage
```

## Lisensi

Open source untuk keperluan pembelajaran.

## Kontribusi

Silakan fork dan submit pull request untuk perbaikan atau fitur baru.
