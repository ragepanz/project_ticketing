# Catatan Pengembangan & Percakapan

File ini untuk menyimpan catatan penting dari percakapan (keputusan, ide fitur, temuan, dll).

---

## Status Tes (2026-08-08)

- Semua test hijau: **14 tests, 66 assertions passed** (`vendor/bin/phpunit`).
- Tes mencakup: scope status event di halaman peserta, email tiket (queue), audit log admin, dan caching event.

---

## Fitur yang Sudah Ada

- Manajemen Event (CRUD admin, status: draft/published/closed/completed)
- Auth Client & Admin (role: client, admin, superadmin)
- Registrasi Peserta (form -> review -> payment -> confirm)
- Payment (simulasi/manual, status lunas)
- E-Ticket PDF (DomPDF) + QR
- Email tiket via Queue (`SendTicketEmail`)
- Audit Log aktivitas admin
- Cari Pesanan / Cek Tiket Saya (TRX / email / WhatsApp)
- Caching event published

---

## Fitur Tambahan yang Direkomendasikan

1. **Check-in / QR Code Scanner (Admin)** — Validasi tiket di lokasi event via scan QR.
2. **Payment Gateway Integration** — Midtrans / Xendit / Tripay (VA, QRIS, E-Wallet).
3. **Ekspor Data Peserta (CSV/Excel/PDF)** — Unduh daftar peserta lunas untuk panitia.
4. **Kategori Tiket / Tier Pricing** — Early Bird, VIP, Regular, On the Spot.
5. **Refund & Pembatalan Pesanan** — Alur pembatalan tiket & pengembalian dana.
6. **Sistem Promo / Kode Diskon (Voucher)** — Potongan harga saat registrasi.
7. **Notifikasi WhatsApp (Fonnte / Wablas)** — Pengingat H-1 / kirim e-ticket via WA.
