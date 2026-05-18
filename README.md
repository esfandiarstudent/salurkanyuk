# 🤝 SalurkanYuk — Platform Donasi Barang Berbasis Web

Platform web yang menghubungkan **donatur** dan **penerima** donasi barang secara langsung, cepat, dan transparan.
Dibangun dengan **Laravel 11** + **Tailwind CSS** (CDN).

---

## ✨ Fitur Aplikasi

| Fitur                  | Donatur | Penerima | Admin |
|------------------------|---------|----------|-------|
| Register & Login       | ✅      | ✅       | ✅    |
| Posting Barang Donasi  | ✅      | —        | —     |
| Upload Foto Barang     | ✅      | —        | —     |
| Lihat Semua Barang     | ✅      | ✅       | ✅    |
| Ajukan Klaim Barang    | —       | ✅       | —     |
| Setujui / Tolak Klaim  | ✅      | —        | —     |
| Riwayat Donasi         | ✅      | ✅       | ✅    |
| Manajemen Kategori     | —       | —        | ✅    |
| Edit Profil & Foto     | ✅      | ✅       | ✅    |
| Ubah Password          | ✅      | ✅       | ✅    |

---

## 🚀 Cara Instalasi & Menjalankan

### Prasyarat
- PHP 8.2+
- Composer
- MySQL
- Node.js (opsional)

---

### Langkah 1 — Buat Project Laravel Baru

```bash
composer create-project laravel/laravel salurkanyuk
cd salurkanyuk
```

---

### Langkah 2 — Salin File dari ZIP Ini

Ekstrak ZIP ini, lalu salin semua file ke dalam folder project Laravel. Timpa file yang sudah ada.

```
SalurkanYuk/
├── app/Http/Controllers/     → salin ke app/Http/Controllers/
├── app/Models/               → salin ke app/Models/
├── database/migrations/      → salin ke database/migrations/
├── database/seeders/         → salin ke database/seeders/
├── resources/views/          → salin ke resources/views/
├── routes/web.php            → timpa routes/web.php
└── .env.example              → timpa .env.example
```

---

### Langkah 3 — Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan sesuaikan bagian database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=salurkanyuk
DB_USERNAME=root
DB_PASSWORD=           ← isi password MySQL kamu
```

---

### Langkah 4 — Buat Database MySQL

```bash
mysql -u root -p -e "CREATE DATABASE salurkanyuk;"
```

Atau lewat phpMyAdmin: klik **New** → ketik `salurkanyuk` → **Create**

---

### Langkah 5 — Hapus Migration Duplikat

> ⚠️ Penting! Laravel sudah punya migration `0001_01_01_000000_create_users_table.php` bawaan.
> Kita harus hapus agar tidak konflik dengan migration kita.

```bash
rm database/migrations/0001_01_01_000000_create_users_table.php
rm database/migrations/0001_01_01_000001_create_cache_table.php
rm database/migrations/0001_01_01_000002_create_jobs_table.php
```

---

### Langkah 6 — Migrasi & Seed

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

---

### Langkah 7 — Jalankan Server

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 🔑 Akun Demo (setelah seeder berhasil)

| Role     | Email                      | Password   |
|----------|----------------------------|------------|
| Admin    | admin@salurkanyuk.id       | password   |
| Donatur  | donatur@salurkanyuk.id     | password   |
| Penerima | penerima@salurkanyuk.id    | password   |

---

## 📁 Struktur File Penting

```
app/
├── Http/Controllers/
│   ├── AuthController.php           # Login, Register, Logout
│   ├── DashboardController.php      # Dashboard tiap role
│   ├── DonationItemController.php   # CRUD barang donasi
│   ├── CategoryController.php       # CRUD kategori (admin)
│   ├── DonationRequestController.php# Pengajuan klaim
│   ├── DonationHistoryController.php# Riwayat donasi
│   └── ProfileController.php        # Edit profil & password
├── Models/
│   ├── User.php
│   ├── Category.php
│   ├── DonationItem.php
│   ├── DonationRequest.php
│   └── DonationHistory.php

database/
├── migrations/                      # 5 tabel utama
└── seeders/DatabaseSeeder.php       # Data awal

resources/views/
├── layouts/
│   ├── app.blade.php               # Layout utama (sidebar)
│   └── auth.blade.php              # Layout login/register
├── auth/                           # Login & Register
├── dashboard.blade.php             # Dashboard
├── donations/                      # CRUD barang
├── categories/                     # Kelola kategori
├── requests/                       # Pengajuan klaim
├── history/                        # Riwayat donasi
└── profile/                        # Profil pengguna

routes/web.php                      # Semua route aplikasi
```

---

## 🎨 Teknologi yang Digunakan

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade Template + Tailwind CSS CDN
- **Icons**: Font Awesome 6.5
- **Font**: Plus Jakarta Sans (Google Fonts)
- **Database**: MySQL

---

## 🐛 Troubleshooting

| Error | Solusi |
|-------|--------|
| `Access denied for user` | Cek `DB_USERNAME` dan `DB_PASSWORD` di `.env` |
| `Table users already exists` | Hapus migration duplikat (lihat Langkah 5) |
| `No application encryption key` | Jalankan `php artisan key:generate` |
| Foto tidak muncul | Jalankan `php artisan storage:link` |
| `Class not found` | Jalankan `composer dump-autoload` |
| Port 8000 sudah dipakai | Gunakan `php artisan serve --port=8080` |

---

## 👨‍💻 Dibuat untuk

Tugas Proyek Akhir — Mata Kuliah Pemrograman Website
**SalurkanYuk** — Aplikasi Donasi Barang Berbasis Web
