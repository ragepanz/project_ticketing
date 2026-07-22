# EventFlow & Tixia Ticketing Platform 2026

EventFlow & Tixia adalah platform pendaftaran tiket seminar, kajian akbar, dan konferensi modern dengan antarmuka Tixia Royal Blue Admin UI dan Bento Grid Public Landing Page.

---

## Fitur Utama

### Web Peserta (Public Portal)
- Bento Grid Hero & Live Countdown Timer: Tampilan beranda interaktif dengan visual bento cyber-emerald dan hitung mundur waktu acara secara real-time.
- Galeri Highlights & Lightbox Modal: Dokumentasi foto kegiatan interaktif yang dapat diperbesar.
- Jadwal Sesi & Poster Event: Daftar sesi kajian/konferensi lengkap dengan foto poster, nama pemateri, tanggal, waktu, lokasi, serta sisa kuota.
- Form Pendaftaran & QRIS Gateway: Formulir pemesanan cepat dengan simulasi pembayaran QRIS dan rincian harga.
- E-Tiket Instant (Boarding Pass Style): Penerbitan e-tiket digital lengkap dengan Kode Transaksi Unik dan QR Code untuk verifikasi.
- Pencarian Tiket Saya: Halaman cek pesanan berdasarkan email, nama, atau kode transaksi (TRX-XXXX).

### Admin Dashboard (Tixia Theme)
- Tixia Royal Blue Sidebar: Navigation bar bergaya royal blue dengan white active pill state dan rute navigasi 1-to-1 yang bersih.
- Stat Summary Banner: Kartu metrik pendapatan (Total Income), jumlah pendaftar (Customer), dan persentase presensi (Check-in Rate %).
- Schedule Event Dropdown: Menu dropdown interaktif pada topbar header untuk mengintip jadwal event aktif dan aksi cepat penambahan event.
- Manajemen Event & Poster: CRUD event lengkap dengan fitur Upload File Foto Poster atau URL Gambar beserta Live Preview.
- Data Peserta & Order List: Tabel data pendaftar dengan filter pencarian instan dan status bayar (LUNAS / PENDING / REFUND).
- Scan QR Check-in: Halaman verifikasi dan simulasi scan QR Code / kode tiket peserta saat hari H event.
- Analytics & Export CSV: Grafik rekap presensi check-in, status pembayaran, dan fitur unduh data peserta format CSV (.csv).
- **Manajemen Admin**: Superadmin dapat mengelola (tambah, edit, hapus) akun admin lainnya.
- **Ubah Password**: Setiap admin/superadmin dapat mengganti password masing-masing.

### Role System
| Role | Akses |
|---|---|
| Superadmin | Full akses dashboard + kelola admin (tambah/edit/hapus admin lain) |
| Admin | Akses dashboard (CRUD event, scan QR, laporan), tidak bisa kelola admin lain |
| Client | Penyelenggara event / Klien (mempunyai login, register, dan dashboard client) |

---

## Teknologi yang Digunakan

- Framework Backend: Laravel 12.x (PHP 8.2+)
- Frontend Assets: Vite 8, Tailwind CSS v4, Vanilla CSS Design System (Cyber Bento & Tixia Theme)
- Database: MySQL / SQLite
- Testing: PHPUnit / Laravel Feature & Unit Testing (100% Passed)
- Fonts: Google Fonts (Space Grotesk, Inter, IBM Plex Mono)

---

## Panduan Instalasi & Penggunaan

### 1. Prasyarat System
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL (untuk production) atau SQLite (untuk development)

### 2. Cloning Repository
```bash
git clone https://github.com/ragepanz/project_ticketing.git
cd project_ticketing
```

### 3. Instalasi Dependensi PHP & JS
```bash
composer install
npm install
```

### 4. Konfigurasi Environment & Storage Link
```bash
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

### 5. Migrasi & Seeding Database
```bash
php artisan migrate --seed
```

### 6. Menjalankan Server Lokal
Jalankan dev server Vite dan Laravel Artisan:
```bash
npm run dev
# Pada terminal lain:
php artisan serve
```
Akses aplikasi melalui browser:
- Web Peserta: `http://127.0.0.1:8000/peserta`
- Login Client: `http://127.0.0.1:8000/client/login`
- Panel Admin: `http://127.0.0.1:8000/admin/login`

---

## Kredensial Akun (Default Demo)

### Superadmin
| Nama | Email | Password |
|---|---|---|
| Ivan Superadmin | `ivan@superadmin.com` | `admin123` |
| Angga Superadmin | `angga@superadmin.com` | `admin123` |
| Meyze Superadmin | `meyze@superadmin.com` | `admin123` |

### Admin (dikelola oleh superadmin)
| Nama | Email | Password |
|---|---|---|
| Sari | `sari@eventflow.id` | `admin123` |
| Jaja | `jaja@eventflow.id` | `admin123` |
| Fajri | `fajri@eventflow.id` | `admin123` |
| Rizky | `rizky@eventflow.id` | `admin123` |

### Client (Penyelenggara Event)
| Nama | Email | Password |
|---|---|---|
| Ahmad Client | `client@eventflow.id` | `client123` |

---

## Pengujian Otomatis (Testing)

Proyek ini telah dilengkapi dengan suite pengujian otomatis menyeluruh:

```bash
php artisan test
```

### Hasil Test:
- 8 Tests Passed (100% Lulus)
- 36 Assertions Passed

---

## Struktur Direktori Utama

```
project_ticketing/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php     # Controller Panel Admin (CRUD Event, Scan, Reports, Users)
│   │   └── PesertaController.php   # Controller Web Peserta (Booking, Payment, E-Ticket)
│   └── Models/
│       ├── Event.php               # Model Event
│       ├── Participant.php         # Model Peserta & transaksi tiket
│       ├── Payment.php             # Model Pembayaran
│       └── User.php                # Model User dengan role (superadmin/admin/client)
├── database/
│   ├── migrations/                 # Skema tabel users, events, participants, payments
│   └── seeders/                    # Seeder data awal
├── resources/
│   └── views/
│       ├── admin/                  # Template Blade Admin (dashboard, events, users, password)
│       ├── peserta/                # Template Blade Web Peserta
│       └── layouts/                # Master layout App & Admin
├── routes/
│   └── web.php                     # Rute navigasi publik & admin
└── tests/
    └── Feature/TicketingTest.php   # Automated Feature Tests
```

---

## Lisensi
MIT License (c) 2026 EventFlow & Tixia Ticketing Team.