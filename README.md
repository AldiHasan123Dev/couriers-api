# Courier API — Laravel

REST API untuk mengelola master data kurir (*Courier*) menggunakan Laravel. Project ini dibuat untuk memenuhi technical test dengan fokus pada CRUD, pagination, sorting, pencarian multi-kata, filter level kurir, validasi input, dan automated testing.

## Fitur

- CRUD data kurir: Create, Read, Update, Delete.
- Pagination untuk daftar kurir.
- Pengurutan default berdasarkan nama kurir secara ascending.
- Pengurutan berdasarkan tanggal pendaftaran.
- Pencarian nama dengan beberapa kata kunci.
- Filter berdasarkan level kurir 1–5.
- Validasi input pada proses tambah dan ubah data.
- Feature test untuk memverifikasi respons API dan perubahan database.
- Seeder untuk membuat 100 data dummy kurir.

## Teknologi

- PHP
- Laravel
- MySQL / MariaDB
- PHPUnit / Laravel Testing

## Persyaratan

Pastikan perangkat sudah memiliki:

- PHP sesuai persyaratan versi Laravel yang digunakan.
- Composer.
- MySQL atau MariaDB.
- Git.

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/USERNAME/courier-api.git
cd courier-api
```

Ganti `USERNAME` dengan username GitHub pemilik repository dan sesuaikan nama repository jika berbeda.

### 2. Instal dependensi

```bash
composer install
```

### 3. Konfigurasi environment

Salin file konfigurasi contoh:

```bash
cp .env.example .env
```

Jika menggunakan Windows Command Prompt:

```cmd
copy .env.example .env
```

Buat application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi database

Buat database, misalnya `courier_api`, lalu sesuaikan konfigurasi berikut di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=courier_api
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan nama database, username, dan password dengan konfigurasi lokal.

### 5. Jalankan migration

```bash
php artisan migrate
```

### 6. Isi data dummy (opsional)

Untuk memasukkan 100 data dummy kurir:

```bash
php artisan db:seed --class=CourierSeeder
```

### 7. Jalankan aplikasi

```bash
php artisan serve
```

Secara default, aplikasi dapat diakses melalui `http://127.0.0.1:8000`.

## API Endpoints

Base URL:

```text
http://127.0.0.1:8000/api
```

| Method | Endpoint | Deskripsi |
|---|---|---|
| GET | `/api/couriers` | Mendapatkan daftar kurir |
| POST | `/api/couriers` | Menambahkan kurir |
| GET | `/api/couriers/{id}` | Mendapatkan detail kurir |
| PUT | `/api/couriers/{id}` | Memperbarui data kurir |
| PATCH | `/api/couriers/{id}` | Memperbarui sebagian data, jika didukung validasi |
| DELETE | `/api/couriers/{id}` | Menghapus kurir |

## Query Parameters

### Pagination

Mengatur jumlah data per halaman:

```http
GET /api/couriers?per_page=10
```

### Sorting

Secara default, daftar kurir diurutkan berdasarkan nama secara ascending.

Untuk mengurutkan berdasarkan tanggal pendaftaran terbaru:

```http
GET /api/couriers?sort=registered_at&direction=desc
```

Untuk urutan tanggal pendaftaran terlama:

```http
GET /api/couriers?sort=registered_at&direction=asc
```

### Pencarian

Pencarian mendukung beberapa kata kunci dalam satu parameter:

```http
GET /api/couriers?search=budi+agung
```

Pencarian tersebut dirancang untuk menemukan nama seperti `Budiono Hadi Agung` jika implementasi pencarian memeriksa setiap kata kunci secara terpisah.

### Filter level

Menampilkan kurir level 2 atau 3:

```http
GET /api/couriers?level=2,3
```

### Kombinasi parameter

Parameter dapat digunakan bersamaan:

```http
GET /api/couriers?search=budi+agung&level=2,3&sort=registered_at&direction=desc&per_page=10
```

## Contoh Request

### Menambahkan kurir

```http
POST /api/couriers
Content-Type: application/json
Accept: application/json
```

Body JSON:

```json
{
    "name": "Budiono Hadi Agung",
    "email": "budiono@example.com",
    "phone": "081234567890",
    "address": "Surabaya, Jawa Timur",
    "level": 2,
    "is_active": true
}
```

### Memperbarui kurir

```http
PUT /api/couriers/1
Content-Type: application/json
Accept: application/json
```

Body JSON:

```json
{
    "name": "Budiono Hadi Agung",
    "email": "budiono.updated@example.com",
    "phone": "081234567891",
    "address": "Sidoarjo, Jawa Timur",
    "level": 3,
    "is_active": true
}
```

Sesuaikan field wajib dengan aturan validasi yang diterapkan pada controller.

## Validasi Data

Data kurir menggunakan validasi input, termasuk:

- Nama wajib diisi.
- Email harus memiliki format valid dan unik.
- Nomor telepon harus sesuai aturan validasi.
- Level kurir hanya boleh bernilai 1 sampai 5.
- Status aktif harus berupa boolean.
- Field alamat dapat diisi sesuai aturan yang diterapkan.

Request yang tidak valid akan mendapatkan respons error validasi dari Laravel.

## Testing

Jalankan seluruh automated test:

```bash
php artisan test
```

Atau jalankan test khusus Courier API:

```bash
php artisan test --filter=CourierApiTest
```

Test mencakup endpoint CRUD, pagination, sorting, pencarian, filter level, validasi input, serta verifikasi penyimpanan, pembaruan, dan penghapusan data pada database, sesuai kasus yang tersedia dalam test suite.

## Struktur Project

```text
app/
├── Http/
│   └── Controllers/
│       └── Api/
│           └── CourierController.php
└── Models/
    └── Courier.php

database/
├── migrations/
└── seeders/
    └── CourierSeeder.php

routes/
└── api.php

tests/
└── Feature/
    └── CourierApiTest.php
```

## Catatan

- Project ini berfokus pada REST API dan tidak menyediakan antarmuka HTML, CSS, atau JavaScript.
- Data dummy hanya digunakan untuk kebutuhan pengujian.
- Jangan mengunggah file `.env` atau kredensial database ke repository publik.

## Author

Dibuat sebagai implementasi technical test Laravel Courier API.
