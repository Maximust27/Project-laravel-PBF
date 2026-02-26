# Panduan Instalasi Kampus Marketplace (Laravel 12)

Panduan lengkap untuk menginstall dan menjalankan aplikasi Kampus Marketplace dengan Laravel 12.

## Prasyarat

Pastikan komputer Anda sudah terinstall:

1. **PHP** >= 8.2
2. **Composer** 2.x - Dependency Manager untuk PHP
3. **MySQL** >= 8.0 atau **MariaDB** >= 10.3
4. **Web Server** (Apache/Nginx) - Opsional, bisa menggunakan `php artisan serve`

### Cara Cek Prasyarat

```bash
# Cek PHP (harus >= 8.2)
php --version

# Cek Composer
composer --version

# Cek MySQL
mysql --version
```

## Langkah Instalasi

### 1. Extract Project

Extract file `kampus-marketplace.tar.gz` ke folder web server Anda.

```bash
tar -xzvf kampus-marketplace.tar.gz
cd kampus-marketplace
```

### 2. Install Dependencies

```bash
composer install
```

Tunggu hingga proses instalasi selesai. Ini akan menginstall Laravel 12 dan semua dependency yang dibutuhkan.

### 3. Setup Environment File

```bash
cp .env.example .env
```

Edit file `.env` dengan text editor dan sesuaikan konfigurasi:

```env
APP_NAME="Kampus Marketplace"
APP_URL=http://localhost:8000
APP_LOCALE=id
APP_TIMEZONE=Asia/Jakarta

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kampus_marketplace
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan**: Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan konfigurasi MySQL Anda. ??(Terakhir sampai sini)??

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Buat Database

Buka terminal/command prompt dan login ke MySQL:

```bash
mysql -u root -p
```

Buat database baru:

```sql
CREATE DATABASE kampus_marketplace;
EXIT;
```

### 6. Jalankan Migration

```bash
php artisan migrate
```

### 7. Buat Storage Link

```bash
php artisan storage:link
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## Troubleshooting

### Error: "Your Composer dependencies require a PHP version >= 8.2.0"

**Solusi**: Upgrade PHP ke versi 8.2 atau lebih tinggi.

### Error: "No application encryption key has been specified"

**Solusi**: Jalankan `php artisan key:generate`

### Error: "Access denied for user"

**Solusi**: Periksa konfigurasi database di file `.env`.

### Error: "Database not found"

**Solusi**: Buat database manual melalui phpMyAdmin atau command line MySQL.

### Error: "Class not found" saat migration

**Solusi**: Jalankan `composer dump-autoload` kemudian coba migration lagi.

### Foto produk tidak tampil

**Solusi**: Pastikan sudah menjalankan `php artisan storage:link`.

### Error: "Permission denied" pada storage (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Testing dengan Pest

Laravel 12 menggunakan Pest sebagai default testing framework:

```bash
# Run all tests
./vendor/bin/pest

# Run with coverage report
./vendor/bin/pest --coverage

# Run specific test file
./vendor/bin/pest tests/Feature/ExampleTest.php
```

## Fitur Baru Laravel 12

- **Pest Testing**: Framework testing modern sebagai default
- **Improved Routing**: Sistem routing yang lebih efisien
- **Better Performance**: Optimasi performa yang lebih baik
- **Simplified Structure**: Struktur folder yang lebih sederhana
- **PHP 8.2+ Features**: Memanfaatkan fitur terbaru PHP 8.2

## Update dari Laravel 10/11

Jika Anda mengupdate dari versi sebelumnya, perhatikan perubahan:

1. **PHP Requirement**: Minimal PHP 8.2
2. **Bootstrap Structure**: File `bootstrap/app.php` diperbarui
3. **Middleware Configuration**: Konfigurasi middleware di `bootstrap/app.php`
4. **RouteServiceProvider**: Lebih sederhana
5. **Testing**: Pest sebagai default testing framework

## Dukungan

Jika mengalami kendala, silakan:
1. Periksa log error di `storage/logs/laravel.log`
2. Pastikan semua prasyarat terpenuhi
3. Ikuti langkah instalasi dengan benar

---

**Selamat menggunakan Kampus Marketplace dengan Laravel 12!**
