# SCRA-Nightly

## Judul Proyek

SCRA-Nightly

---

## Deskripsi Proyek

SCRA-Nightly adalah Sistem Manajemen Peminjaman Ruang Kelas berbasis web untuk universitas yang membantu mengelola reservasi ruang kelas secara efisien. Sistem ini dirancang untuk mengurangi penjadwalan manual, mencegah pemesanan ganda, dan menyederhanakan proses reservasi di seluruh mahasiswa, dosen, staf, dan administrator.

Sistem ini memungkinkan:

- Mahasiswa mengajukan permintaan peminjaman ruang kelas
- Dosen atau staf memverifikasi peminjaman
- Administrator mengelola ruang kelas, pengguna, peminjaman, laporan, dan log aktivitas

Tujuan utama sistem ini adalah menyediakan alur kerja pemesanan ruang kelas yang terstruktur, transparan, dan dapat diandalkan untuk lingkungan akademik.

Proyek ini juga mencakup modul integrasi IoT opsional untuk kontrol pintu ruang kelas otomatis di masa depan. Namun, aplikasi berfungsi dengan sempurna tanpa perangkat IoT apa pun.


---

## Fitur

- Autentikasi Pengguna 🔐
- Kontrol Akses Berbasis Peran
- Manajemen Ruang Kelas
- Peminjaman Ruang Kelas
- Alur Kerja Persetujuan Peminjaman
- Riwayat Peminjaman
- Manajemen Jadwal Ruang Kelas
- Pencatatan Aktivitas
- Dashboard Administrator
- Antarmuka Responsif
- Integrasi Pintu IoT Opsional

---

## Stack Teknologi

**Backend**

- Laravel 11
- PHP 8.2+

**Frontend**

- Blade
- Tailwind CSS

**Panel Admin**

- Filament 3

**Database**

- MySQL

**Autentikasi**

- Autentikasi Laravel

**Arsitektur**

- MVC

---

## Peran Pengguna

### Admin

- Mengelola ruang kelas
- Mengelola pengguna
- Mengelola peminjaman
- Melihat log aktivitas
- Membuat laporan

### Dosen / Staf

- Meninjau permintaan peminjaman
- Menyetujui atau menolak peminjaman
- Melihat jadwal ruang kelas

### Mahasiswa

- Menjelajahi ruang kelas
- Memeriksa ketersediaan
- Mengajukan permintaan peminjaman
- Melihat riwayat peminjaman
- Mengelola profil

---

## Alur Kerja Sistem

### Alur Penggunaan Langkah demi Langkah dengan Tangkapan Layar

---

## 1️⃣ **ALUR KERJA MAHASISWA**

### Langkah 1: Login ke Aplikasi
Mahasiswa mengakses halaman login dan memasukkan kredensial mereka.

![Login Mahasiswa](docs/images/SCRA-DOCS/LOGIN-PAGE/userLogin.png)

---

### Langkah 2: Melihat Dashboard
Setelah login, mahasiswa melihat dashboard yang dipersonalisasi dengan status peminjaman mereka.

![Dashboard Mahasiswa](docs/images/SCRA-DOCS/ALL-PAGE/Mahasiswa/Dashboard.png)

---

### Langkah 3: Melihat Status Ruang Kelas
Mahasiswa dapat memeriksa status ruang kelas yang tersedia.

![Status Ruang Kelas](docs/images/SCRA-DOCS/ALL-PAGE/Mahasiswa/classroomStatus.png)

---

### Langkah 4: Melihat Detail Ruang Kelas
Mahasiswa memilih ruang kelas untuk melihat informasi detail (kapasitas, fasilitas, lokasi, dll.).

![Detail Ruang Kelas](docs/images/SCRA-DOCS/ALL-PAGE/Mahasiswa/classroomDetails.png)

---

### Langkah 5: Periksa Jadwal & Ketersediaan
Mahasiswa melihat jadwal kelas dan jadwal mata kuliah untuk menemukan slot waktu yang tersedia.

![Jadwal Kelas](docs/images/SCRA-DOCS/ALL-PAGE/Mahasiswa/jadwalKelas.png)

![Jadwal Mata Kuliah](docs/images/SCRA-DOCS/ALL-PAGE/Mahasiswa/jadwalMataKuliah.png)

---

### Langkah 6: Ajukan Permintaan Peminjaman
Mahasiswa mengisi formulir peminjaman dengan:
- Pemilihan ruang kelas
- Tanggal dan waktu peminjaman
- Tujuan peminjaman
- Informasi mata kuliah

![Formulir Detail Peminjaman](docs/images/SCRA-DOCS/ALL-PAGE/Mahasiswa/reservDetails.png)

![Detail Peminjaman Terpilih](docs/images/SCRA-DOCS/ALL-PAGE/Mahasiswa/detailReservasi.png)

---

### Langkah 7: Lihat Status & Riwayat
Mahasiswa dapat melacak status peminjaman mereka dan melihat riwayat peminjaman lengkap mereka.

![Status Dashboard](docs/images/SCRA-DOCS/ALL-PAGE/Mahasiswa/dashboardStatusMahasiswa.png)

![Riwayat Peminjaman](docs/images/SCRA-DOCS/ALL-PAGE/Mahasiswa/reservHistory.png)

---

### Ringkasan Alur Mahasiswa
```
Login → Dashboard → Jelajahi Ruang Kelas → Lihat Detail → Periksa Jadwal → Ajukan Permintaan → Lacak Status
```

---

## 2️⃣ **ALUR KERJA DOSEN/STAF**

### Langkah 1: Login ke Aplikasi
Dosen dan staf mengakses halaman login dengan kredensial mereka.

![Login Dosen](docs/images/SCRA-DOCS/LOGIN-PAGE/userLogin.png)

---

### Langkah 2: Melihat Dashboard
Dosen melihat dashboard mereka yang dipersonalisasi dengan permintaan peminjaman yang tertunda.

![Dashboard Dosen](docs/images/SCRA-DOCS/ALL-PAGE/Dosen/dashboardDosen.png)

---

### Langkah 3: Melihat Status Ruang Kelas
Dosen dapat memeriksa status semua ruang kelas.

![Status Ruang Kelas Dosen](docs/images/SCRA-DOCS/ALL-PAGE/Dosen/dashboardStatusDosen.png)

---

### Langkah 4: Melihat Detail Ruang Kelas
Dosen meninjau informasi detail tentang ruang kelas sebelum menyetujui peminjaman.

![Detail Ruang Kelas Dosen](docs/images/SCRA-DOCS/ALL-PAGE/Dosen/classroomDetailDosen.png)

---

### Langkah 5: Tinjau Peminjaman yang Tertunda
Dosen melihat semua permintaan peminjaman yang tertunda dari mahasiswa.

![Peminjaman Dosen](docs/images/SCRA-DOCS/ALL-PAGE/Dosen/dosenReservation.png)

---

### Langkah 6: Verifikasi & Setujui/Tolak Permintaan
Dosen meninjau permintaan mahasiswa dan membuat keputusan persetujuan berdasarkan:
- Ketersediaan ruang kelas
- Konflik waktu
- Informasi mahasiswa
- Keselarasan mata kuliah

![Verifikasi Dosen](docs/images/SCRA-DOCS/ALL-PAGE/Dosen/dosenVerif.png)

---

### Langkah 7: Lihat Jadwal Mata Kuliah & Kelas
Dosen dapat merujuk jadwal mata kuliah dan jadwal kelas saat membuat keputusan.

![Jadwal Mata Kuliah Dosen](docs/images/SCRA-DOCS/ALL-PAGE/Dosen/jadwalMataKuliahDosen.png)

![Jadwal Kelas Dosen](docs/images/SCRA-DOCS/ALL-PAGE/Dosen/jadwalKelasDosen.png)

---

### Ringkasan Alur Dosen/Staf
```
Login → Dashboard → Tinjau Permintaan Tertunda → Periksa Ruang Kelas & Jadwal → Setujui/Tolak → Mahasiswa Diberitahu
```

---

## 3️⃣ **ALUR KERJA ADMINISTRATOR**

### Langkah 1: Login ke Panel Admin
Administrator mengakses sistem dengan kredensial admin.

![Login Admin](docs/images/SCRA-DOCS/LOGIN-PAGE/adminLogin.png)

---

### Langkah 2: Lihat Dashboard Admin
Administrator melihat dashboard utama dengan statistik sistem dan ikhtisar.

![Dashboard Admin](docs/images/SCRA-DOCS/ADMIN-PAGE/adminDashboard.png)

---

### Langkah 3: Kelola Pengguna
Administrator dapat:
- Menambah pengguna baru
- Mengedit informasi pengguna
- Menetapkan peran (Mahasiswa, Dosen, Admin)
- Menghapus pengguna

![Manajemen Pengguna](docs/images/SCRA-DOCS/ADMIN-PAGE/adminUserManage.png)

![Buat Pengguna](docs/images/SCRA-DOCS/ADMIN-PAGE/createUser.png)

---

### Langkah 4: Kelola Ruang Kelas
Administrator menangani semua operasi ruang kelas:
- Menambah ruang kelas baru
- Memperbarui informasi ruang kelas
- Menetapkan kapasitas dan fasilitas
- Menghapus ruang kelas

![Manajemen Ruang Kelas](docs/images/SCRA-DOCS/ADMIN-PAGE/adminClassManage.png)

![Buat Ruang Kelas](docs/images/SCRA-DOCS/ADMIN-PAGE/createClass.png)

---

### Langkah 5: Kelola Peminjaman
Administrator memiliki kontrol penuh atas semua peminjaman:
- Melihat semua peminjaman
- Membuat peminjaman manual
- Mengganti pemesanan jika diperlukan
- Mengelola kasus khusus

![Manajemen Peminjaman](docs/images/SCRA-DOCS/ADMIN-PAGE/adminReservation.png)

![Buat Peminjaman](docs/images/SCRA-DOCS/ADMIN-PAGE/createReservation.png)

---

### Langkah 6: Kelola Jadwal
Administrator mengelola berbagai jadwal:
- Jadwal mata kuliah
- Jadwal kelas
- Jadwal hari libur

![Manajemen Jadwal Mata Kuliah](docs/images/SCRA-DOCS/ADMIN-PAGE/createJadwalMatkul.png)

![Jadwal Mata Kuliah](docs/images/SCRA-DOCS/ADMIN-PAGE/jadwalMatkul.png)

![Jadwal Kelas](docs/images/SCRA-DOCS/ADMIN-PAGE/jadwalSewa.png)

![Manajemen Hari Libur](docs/images/SCRA-DOCS/ADMIN-PAGE/createHariLibur.png)

![Jadwal Hari Libur](docs/images/SCRA-DOCS/ADMIN-PAGE/hariLibur.png)

---

### Langkah 7: Lihat Log Aktivitas
Administrator memantau semua aktivitas sistem untuk tujuan audit dan pemecahan masalah.

![Log Aktivitas](docs/images/SCRA-DOCS/ADMIN-PAGE/adminLog.png)

---

### Ringkasan Alur Administrator
```
Login → Dashboard → Kelola Pengguna → Kelola Ruang Kelas → Kelola Peminjaman → Kelola Jadwal → Lihat Log
```

---

## Pengembangan Masa Depan

- Akses pintu otomatis IoT
- Absensi dengan QR Code
- Notifikasi Email
- Integrasi Kalender
- Aplikasi Mobile
- Pelaporan Lanjutan
- Integrasi API

---

## Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT.

---

**GitHub:** https://github.com/ZuanPdana/SCRA  

## Instalasi

```bash
git clone <repository-url>
cd scara-alfa
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Untuk pengembangan lokal, Laravel merekomendasikan:

```bash
composer run dev
```

Ini memulai server aplikasi, worker antrian, dan server dev Vite.

## Konfigurasi Database

Proyek ini menggunakan MySQL secara default di `.env.example`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scra_classroom
DB_USERNAME=root
DB_PASSWORD=
```

Buat database sebelum menjalankan migrasi:

```sql
CREATE DATABASE scra_classroom CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Perbarui nilai yang sama di `.env` jika nama pengguna, kata sandi, atau nama database Anda berbeda.

## Migrasi

Jalankan semua migrasi database:

```bash
php artisan migrate
```

Jika Anda ingin membangun kembali database dari awal:

```bash
php artisan migrate:fresh
```

## Seed

Seeder default menjalankan:

- `RoleSeeder`
- `UserSeeder`
- `ClassroomSeeder`

Seed database:

```bash
php artisan db:seed
```

Reset dan seed dalam satu perintah:

```bash
php artisan migrate:fresh --seed
```

## Jalankan Secara Lokal

```bash
php artisan serve
```

Di terminal lain, jika Anda tidak menggunakan `composer run dev`, mulai Vite secara manual:

```bash
npm run dev
```

## Build Produksi

```bash
npm run build
php artisan optimize
```
