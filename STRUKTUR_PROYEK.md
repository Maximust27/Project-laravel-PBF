# Struktur Proyek Kampus Marketplace (Laravel 12)

Dokumen ini menjelaskan struktur folder dan file dalam proyek Kampus Marketplace dengan Laravel 12.

## Struktur Folder Utama

```
kampus-marketplace/
├── app/                    # Kode aplikasi utama
├── bootstrap/              # Bootstrap aplikasi (diperbarui untuk Laravel 12)
├── config/                 # Konfigurasi
├── database/               # Database migrations dan seeders
├── public/                 # Document root (CSS, JS, images)
├── resources/              # Views (Blade templates)
├── routes/                 # Route definitions
├── storage/                # Storage (logs, cache, uploads)
├── tests/                  # Tests (Pest - default Laravel 12)
├── composer.json           # Dependency PHP (Laravel 12)
├── .env.example            # Contoh konfigurasi environment
└── README.md               # Dokumentasi utama
```

## Perubahan di Laravel 12

### 1. Bootstrap Structure

Laravel 12 menyederhanakan struktur bootstrap:

```
bootstrap/
├── app.php                 # Konfigurasi aplikasi utama
└── providers.php           # Service providers
```

File `app.php` sekarang berisi:
- Routing configuration
- Middleware configuration
- Exception handling

### 2. Middleware Configuration

Middleware sekarang dikonfigurasi di `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [...]);
    $middleware->api(prepend: [...]);
    $middleware->alias([...]);
})
```

### 3. Testing Framework

Laravel 12 menggunakan **Pest** sebagai default testing framework:

```
tests/
├── Feature/                # Feature tests
├── Unit/                   # Unit tests
└── Pest.php                # Pest configuration
```

## Detail Struktur

### Folder `app/`

```
app/
├── Http/
│   ├── Controllers/           # Controller aplikasi
│   │   ├── Auth/
│   │   ├── CartController.php
│   │   ├── HomeController.php
│   │   ├── MessageController.php
│   │   ├── OrderController.php
│   │   └── ProductController.php
│   └── Requests/
│       └── Auth/
├── Models/                    # Model Eloquent
│   ├── Cart.php
│   ├── Message.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Product.php
│   └── User.php
└── Providers/
    ├── AppServiceProvider.php
    └── RouteServiceProvider.php
```

### Folder `bootstrap/` (Laravel 12)

```
bootstrap/
├── app.php                    # Konfigurasi aplikasi
└── providers.php              # Service providers
```

**File `bootstrap/app.php`** berisi:
- Route configuration
- Middleware configuration
- Exception handling

### Folder `database/migrations/`

```
database/migrations/
├── 2014_10_12_000000_create_users_table.php
├── 2024_01_15_000001_create_products_table.php
├── 2024_01_15_000002_create_carts_table.php
├── 2024_01_15_000003_create_orders_table.php
├── 2024_01_15_000004_create_order_items_table.php
└── 2024_01_15_000005_create_messages_table.php
```

### Folder `resources/views/`

```
resources/views/
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── cart/
│   └── index.blade.php
├── layouts/
│   └── app.blade.php
├── messages/
│   ├── create.blade.php
│   ├── index.blade.php
│   └── show.blade.php
├── orders/
│   ├── checkout.blade.php
│   ├── index.blade.php
│   └── show.blade.php
├── products/
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── index.blade.php
│   ├── my-products.blade.php
│   └── show.blade.php
└── home.blade.php
```

### Folder `routes/`

```
routes/
├── api.php                    # API routes
├── console.php                # Console commands
└── web.php                    # Web routes (utama)
```

### Folder `public/`

```
public/
├── css/
│   └── app.css
├── js/
│   └── app.js
├── images/
│   └── no-image.png
├── .htaccess
└── index.php                  # Entry point (diperbarui untuk Laravel 12)
```

## Alur Request (Laravel 12)

```
Browser Request
    ↓
public/index.php (simplified)
    ↓
bootstrap/app.php
    ↓
routes/web.php
    ↓
Controller
    ↓
Model (Eloquent)
    ↓
Database
    ↓
View (Blade)
    ↓
Browser Response
```

## Konfigurasi Middleware (Laravel 12)

Middleware dikonfigurasi di `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    // Web middleware group
    $middleware->web(append: [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    // API middleware group
    $middleware->api(prepend: [
        // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    ]);

    // Middleware aliases
    $middleware->alias([
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
        // ...
    ]);
})
```

## File Konfigurasi Penting (Laravel 12)

| File | Keterangan |
|------|------------|
| `.env` | Konfigurasi environment |
| `bootstrap/app.php` | Konfigurasi aplikasi utama |
| `composer.json` | Dependency PHP (Laravel 12) |
| `routes/web.php` | Definisi route web |

## Environment Variables Baru (Laravel 12)

```env
APP_TIMEZONE=UTC
APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

SESSION_ENCRYPT=false
```

## Testing dengan Pest

Laravel 12 menggunakan Pest sebagai default:

```bash
# Run tests
./vendor/bin/pest

# Run with coverage
./vendor/bin/pest --coverage

# Run specific test
./vendor/bin/pest tests/Feature/ProductTest.php
```

## PHP 8.2+ Features

Laravel 12 memanfaatkan fitur PHP 8.2:

- **Readonly classes**
- **Null, false, true standalone types**
- **Sensitive parameter attribute**
- **Constants in traits**
- **Enum properties**

---

**Catatan**: Laravel 12 menyederhanakan banyak konfigurasi yang sebelumnya ada di `app/Providers/` sekarang dipindahkan ke `bootstrap/app.php`.
