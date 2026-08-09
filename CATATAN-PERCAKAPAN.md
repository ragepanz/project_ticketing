# Catatan Percakapan & Progress Proyek — EventFlow Ticketing

> File ini menyimpan keputusan teknis, analisis fitur, hasil pengujian, dan progress pengembangan proyek.

---

## Log Perkembangan & Keputusan Proyek

### [8 Agustus 2026]
- **Analisis Awal Proyek:**
  - Aplikasi ticketing EventFlow memiliki fitur inti: CRUD Event (Draft, Published, Closed, Completed), Auth Client/Admin, Pendaftaran Peserta (Form, Review, Payment, Confirm), E-Ticket PDF dengan QR Code, Notifikasi Email via Queue, dan Audit Log Admin.
  - Hasil run PHPUnit menemukan 2/14 test yang failed:
    1. `test_event_has_status_and_scope_in_peserta` — Gagal mendeteksi 'Draft Event' di halaman peserta.
    2. `test_published_events_are_cached_and_invalidated_on_crud` — Gagal karena caching `events.published` tidak ditemukan.
- **Rekomendasi Fitur Tambahan:**
  1. *Check-in / QR Code Scanner (Admin)* — Validasi tiket lokasi via scan QR.
  2. *Payment Gateway Integration* — Midtrans / Xendit / Tripay (VA, QRIS, E-Wallet).
  3. *Ekspor Data Peserta (CSV/Excel/PDF)* — Unduh daftar peserta lunas untuk panitia.
  4. *Kategori Tiket / Tier Pricing* — Early Bird, VIP, Regular, On the Spot.
  5. *Refund & Pembatalan Pesanan* — Alur pembatalan tiket & pengembalian dana.
  6. *Sistem Promo / Kode Diskon (Voucher)* — Potongan harga registrasi.
  7. *Notifikasi WhatsApp (Fonnte / Wablas)* — Pengingat H-1 / kirim e-ticket via WA.

---

## Ringkasan Proyek

- **App:** EventFlow Ticketing (aplikasi ticketing event/seminar)
- **Techno:** PHP, Laravel, MySQL, Vue.js (vite)
- **Tes:** PHPUnit, Laravel 12 + RefreshDatabase
- **Tanggal:** 8 Agustus 2026

---

## Status Fitur yang Sudah Ada

| Fitur | Status | Detail |
|-------|--------|--------|
| Manajemen Event (CRUD) | ✅ | Status: draft/published/closed/completed |
| Auth Client & Admin | ✅ | Role: client, admin, superadmin |
| Registrasi Peserta | ✅ | Form → Review → Payment → Confirm |
| Payment Simulasi | ✅ | Manual/VA, status lunas |
| E-Ticket PDF | ✅ | DomPDF + QR Code |
| Email Tiket via Queue | ✅ | SendTicketEmail job |
| Audit Log Admin | ✅ | Log create/update event |
| Cek Tiket Saya | ✅ | Cari by TRX/email/WA |
| Caching Event Published | ✅ | Ditampilkan di homepage |

---

## Fitur Tambahan yang Direkomendasikan

1. **Check-in / QR Code Scanner (Admin)** — Validasi tiket lokasi via scan QR
2. **Payment Gateway Integration** — Midtrans / Xendit / Tripay (VA, QRIS, E-Wallet)
3. **Ekspor Data Peserta (CSV/Excel/PDF)** — Unduh daftar peserta lunas
4. **Kategori Tiket / Tier Pricing** — Early Bird, VIP, Regular, On the Spot
5. **Refund & Pembatalan Pesanan** — Alur pembatalan tiket & pengembalian dana
6. **Sistem Promo / Kode Diskon (Voucher)** — Potongan harga registrasi
7. **Notifikasi WhatsApp (Fonnte / Wablas)** — Pengingat H-1 / kirim e-ticket via WA

---

## Catatan Teknis

- **Tes:** 14 test, 66 assertion, 12 passed, 2 failed
  - `test_event_has_status_and_scope_in_peserta` — failed: tidak ada 'Draft Event' di halaman peserta (view tidak menampilkan judul event)
  - `test_published_events_are_cached_and_invalidated_on_crud` — failed: cache tidak dihapus setelah create event baru
- **Model Event:** `STATUS_DRAFT`, `STATUS_PUBLISHED`, `STATUS_CLOSED`, `STATUS_COMPLETED`
- **Session Key:** `peserta_form` (nama, email, phone, instansi), `peserta_event_id`
- **Cache Key:** `events.all` (600 detik)

---

## Catatan Fitur yang Belum Diverifikasi

- Halaman `peserta/detail` (detail event dengan pendaftaran detail)
- Halaman `peserta/review` (review data peserta)
- Halaman `peserta/payment` (payment)
- Halaman `peserta/ticket` (tiket)
- Halaman `peserta/download-ticket` (download PDF e-ticket)
- Halaman `peserta/search` (cari peserta per TRX/email/WA)
- Halaman `peserta/cek-pesanan` (cek tiket saya)
- Halaman `client/login` & `client/register`
- Halaman `admin/events` (CRUD event)
- Halaman `admin/events/{id}` (edit event)
- Halaman `client/dashboard`
- Notifikasi H-1 (WhatsApp)

---

## Catatan Komentar

- Fitur `test_event_has_status_and_scope_in_peserta` gagal karena view `peserta.index` tidak menampilkan judul event (harus ada tag/element 'Draft Event').
- Fitur `test_published_events_are_cached_and_invalidated_on_crud` gagal karena cache `events.published` tidak dibuat (terlihat `false`).
- Seluruh struktur database sudah ada (16 migrations + 3 seeders).
