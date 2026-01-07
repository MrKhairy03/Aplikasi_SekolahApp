# Sekolah App (Laravel) — Project Based

Sekolah App adalah aplikasi manajemen sekolah berbasis **Laravel** yang digunakan untuk mengelola **Data Siswa, Guru, dan Kelas** secara terintegrasi.  
Aplikasi ini dirancang untuk membantu administrasi sekolah dalam mengelola data akademik dengan struktur relasi **User – Siswa – Guru – Kelas**, serta menyediakan **laporan data berbasis kelas** tanpa duplikasi.

---

## Fitur Utama

### Manajemen Data Akademik
- **Kelas**
  - CRUD data kelas (kode kelas, nama kelas, tingkat).
  - Satu kelas dapat memiliki banyak siswa dan guru.
- **Siswa**
  - CRUD data siswa.
  - Setiap siswa memiliki akun **User**.
  - Data siswa terhubung ke kelas.
- **Guru**
  - CRUD data guru.
  - Setiap guru memiliki akun **User**.
  - Data guru terhubung ke kelas.

---

### Relasi Data
- **User**
  - `hasOne(Siswa)`
  - `hasOne(Guru)`
- **Kelas**
  - `hasMany(Siswa)`
  - `hasMany(Guru)`
- **Siswa**
  - `belongsTo(User)`
  - `belongsTo(Kelas)`
- **Guru**
  - `belongsTo(User)`
  - `belongsTo(Kelas)`

---

## Laporan (Project Based)

Aplikasi menyediakan laporan data **tanpa filter** dan **tanpa duplikasi kelas** sesuai requirement project based:

1. **Laporan Siswa per Kelas**
   - Menampilkan daftar siswa berdasarkan kelas.
   - Nama kelas hanya muncul **1 kali** sebagai sub-judul.
   - Data siswa ditampilkan di bawah kelas masing-masing.

2. **Laporan Guru per Kelas**
   - Menampilkan daftar guru berdasarkan kelas.
   - Nama kelas tidak muncul lebih dari sekali.
   - Data guru ditampilkan di bawah kelas terkait.

3. **Laporan Gabungan Siswa & Guru per Kelas**
   - Menampilkan siswa dan guru dalam **1 tabel**.
   - Dikelompokkan berdasarkan kelas.
   - Setiap kelas hanya ditampilkan satu kali.

---

## Teknologi yang Digunakan
- Laravel (MVC)
- MySQL / MariaDB
- Bootstrap (SB Admin 2 Template)
- jQuery & DataTables
- Blade Template Engine

---

## Setup & Menjalankan Project

### 1. Clone Repository
git clone https://github.com/MrKhairy03/SekolahApp.git
cd SekolahApp

### 2) Install Dependency
composer install
npm install
npm run build

### 3) Buat Environment
cp .env.example .env
php artisan key:generate

### 4) Konfigurasi Database
DB_DATABASE=sekolah_app
DB_USERNAME=root
DB_PASSWORD=

### 5) Migrasi & Seeder
php artisan migrate --seed

### 6) Jalankan Aplikasi
php artisan serve

### Struktur Penyimpanan File Upload
Avatar User: storage/app/public/avatar → akses publik: public/storage/avatar
Image Product: storage/app/public/product → akses publik: public/storage/product
`Catatan: Pastikan php artisan storage:link sudah dijalankan.`

### Akun & Role (Seeder)
Role yang digunakan:
- Admin
- Seller
Seeder akan menyiapkan data sample (Seller & Product).
`Silakan cek file seeder di project untuk detail user/password yang tersedia.`

---

## Struktur Project

- `app/Http/Controllers/`
  - `SiswaController.php` → CRUD Siswa 
  - `GuruController.php` → CRUD Guru 
  - `KelasController.php` → CRUD Kelas 
  - `LaporanController.php` → Laporan Siswa, Guru dan Kelas 
- `app/Models/`
  - `User.php`
  - `Siswa.php`
  - `Guru.php`
  - `Kelas.php`
- `resources/views/environments/`
  - `siswa/`,  `guru/`, `kelas/` → halaman utama
  - `siswa-form/`, `guru-form/`, `kelas-form/` → form CRUD
  - `siswa-laporan/`, `guru-laporan/`, `kelas-laporan/` → Laporan Data

---

## Business Rule (Ringkas)

- Setiap Siswa dan Guru wajib memiliki akun User.
- NIS (Siswa) dan NIP (Guru) bersifat unik.
- Siswa dan Guru wajib terhubung ke Kelas.
- Laporan:
  - Tidak menggunakan filter.
  - Kelas tidak boleh tampil lebih dari satu kali.
  - Data ditampilkan terkelompok berdasarkan kelas.
    
---

## Testing & Analisis

Pengujian dilakukan menggunakan manual functional testing:
- CRUD Siswa, Guru, dan Kelas.
- Validasi input (email unik, NIS/NIP unik).
- Relasi User – Siswa – Guru – Kelas.
- Laporan:
  - Siswa per kelas
  - Guru per kelas
  - Gabungan siswa & guru per kelas
  - 
---

## Catatan

Project ini dibuat sebagai Project Based Laravel untuk menunjukkan:
- Penerapan MVC
- Relasi antar tabel
- Pengolahan data terstruktur
- Penyajian laporan akademik berbasis kelas
