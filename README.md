# Tutorial Frontend Laravel Sistem Bimbingan Tugas AKhir(CRUD API CodeIgniter 4)
Sistem ini dibuat untuk memudahkan proses bimbingan Tugas Akhir antara mahasiswa dan dosen secara terintegrasi. Aplikasi ini dibangun menggunakan framework Laravel untuk sisi frontend dan mengonsumsi data dari REST API backend.

---

## 🛠️ Teknologi

- **Laravel 12**
- **PHP 8.2**
- **Tailwind CSS**
- **Laravel HTTP Client**
- **REST API (backend terpisah)**

---

## 🖥️ Database
**Buat Database**
```php
CREATE DATABASE db_perpus_[NIM_ANDA];
USE db_perpus_[NIM_ANDA];

CREATE TABLE buku (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(100),
  pengarang VARCHAR(100),
  penerbit VARCHAR(100),
  tahun_terbit INT
);

CREATE TABLE peminjaman (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_peminjam VARCHAR(100),
  judul_buku VARCHAR(100),
  tanggal_pinjam DATE,
  tanggal_kembali DATE
);

```

### 📦 BACKEND
#### 1. Persiapan Awal
   Pastikan perangkat Anda telah terinstal:
   - PHP >= 8.1
   - Composer
   - MySQL/MariaDB
   - Git
     
#### 2. Buat Proyek CodeIgniter 4 Baru

   composer create-project codeigniter4/appstarter backend_perpustakaan 
    cd backend_perpustakaan

#### 3. Konfigurasi Database


**Salin file .env**

```php

cp env .env

```

b. Edit konfigurasi database di .env

```php
database.default.hostname = localhost
database.default.database = db_perpus_230102038
database.default.username = root
database.default.password =
```
#### 4. Buat Database dan Tabel
Login ke phpMyAdmin atau terminal SQL, lalu jalankan query berikut:
```php
CREATE DATABASE db_perpus_230102038;
USE db_perpus_230102038;

CREATE TABLE buku (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(100),
  pengarang VARCHAR(100),
  penerbit VARCHAR(100),
  tahun_terbit INT
);

CREATE TABLE peminjaman (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_peminjam VARCHAR(100),
  judul_buku VARCHAR(100),
  tanggal_pinjam DATE,
  tanggal_kembali DATE
);
```

### 🛠️ Pembuatan Model
#### 📁 app/Models/BukuModel.php
```php
<?php namespace App\Models;
use CodeIgniter\Model;

class BukuModel extends Model {
    protected $table = 'buku';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'pengarang', 'penerbit', 'tahun_terbit'];
    protected $useTimestamps = false;
}
```
#### 📁 app/Models/PeminjamanModel.php
```php
<?php namespace App\Models;
use CodeIgniter\Model;

class PeminjamanModel extends Model {
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_peminjam', 'judul_buku', 'tanggal_pinjam', 'tanggal_kembali'];
    protected $useTimestamps = false;
}
```

### 🎮 Pembuatan Controller (REST API)
#### 📁 app/Controllers/Buku.php


```php <?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Buku extends ResourceController {
    protected $modelName = 'App\\Models\\BukuModel';
    protected $format    = 'json';
}

```
#### 📁 app/Controllers/Peminjaman.php
```php
<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Peminjaman extends ResourceController {
    protected $modelName = 'App\\Models\\PeminjamanModel';
    protected $format    = 'json';
}
```

### 🛣️ Routing
Tambahkan routing ke app/Config/Routes.php:
```php
$routes->resource('buku');
$routes->resource('peminjaman');
```

### 🚀 Menjalankan Server
```php
php spark serve
```
Akses melalui browser atau Postman:

- http://localhost:8080/buku
- http://localhost:8080/peminjaman

### 🎨 FRONTEND
#### 1.  Install Laravel
   Melalui Terminal
    composer create-priject laravel/laravel frontens-uas-230102038
   Melalui Laragon
    - Buka Laragon
    - Klik kanan
    - Quick app
    - Laravel
#### 2. Install Dependency Laravel
   ```php
   composer install
   ```
#### 3.Buat View, Model, dan Controller dalam file laravel

####  4. Menjalankan Laravel
   ```php
   php artisan serve
   ```

