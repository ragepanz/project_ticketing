@extends('layouts.app')

@section('title', 'EventFlow 2026 — Konferensi & Kajian Akbar')
@section('body_class', 'dark-mode')

@section('fullwidth')
<!-- 1. MODERN BENTO HERO SECTION -->
<section class="bento-hero">
  <div class="bento-hero-container">
    <!-- Left Hero Info -->
    <div class="hero-left">
      <div class="hero-pill-badge">
        <span class="dot"></span>
        <span>SPECIAL EVENT 2026 · JICC SENAYAN</span>
      </div>

      <h1 class="bento-hero-title">
        Konferensi & Kajian Akbar <span class="highlight">2026</span>
      </h1>

      <p class="bento-hero-sub">
        Platform pendaftaran resmi sesi kajian utama & seminar inspiratif. Dapatkan tiket Anda dan ikuti rangkaian acara spesial bersama para ilmuwan & ustadz ternama.
      </p>

      <!-- Live Countdown Timer -->
      <div class="hero-countdown-box">
        <div class="cd-unit">
          <div class="num" id="cdDays">00</div>
          <div class="label">Hari</div>
        </div>
        <div class="cd-unit">
          <div class="num" id="cdHours">00</div>
          <div class="label">Jam</div>
        </div>
        <div class="cd-unit">
          <div class="num" id="cdMins">00</div>
          <div class="label">Menit</div>
        </div>
        <div class="cd-unit">
          <div class="num" id="cdSecs">00</div>
          <div class="label">Detik</div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="hero-cta-group">
        <a href="#sessions" class="btn-bento-primary">
          <span>Eksplor Sesi & Tiket</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>

        <a href="{{ route('peserta.search-order') }}" class="btn-bento-secondary">
          <span>🔍 Cek Tiket Saya</span>
        </a>
      </div>
    </div>

    <!-- Right Side 3D Glass Stack Cards -->
    <div class="hero-right">
      <div class="hero-glass-stack">
        <!-- Main Front Card -->
        <div class="stack-card main-card">
          <div class="card-header-badge">
            <span class="tag">SESI UTAMA</span>
            <span class="quota-badge">⚡ Quota 500 Kursi</span>
          </div>

          <h3 style="font-size:22px; font-weight:800; color:#fff; margin-bottom:6px;">
            CINTA ITU Bernama Ta'at
          </h3>

          <p style="font-size:13px; color:var(--bento-muted); margin-bottom:20px;">
            Ustadz Dr. Khalid Basalamah · 10.00 - 11.30 WIB
          </p>

          <div style="display:flex; align-items:center; justify-content:space-between; border-top:1px solid rgba(255,255,255,0.1); padding-top:16px;">
            <div style="font-size:12px; color:rgba(255,255,255,0.7);">📍 JICC Senayan, Jakarta</div>
            <a href="#sessions" style="color:var(--bento-emerald); font-weight:700; font-size:13px;">Daftar Sesi →</a>
          </div>
        </div>

        <!-- Background Stack Card 1 -->
        <div class="stack-card bg-card-1">
          <div class="card-header-badge">
            <span class="tag">SESI SORE</span>
          </div>
          <h3 style="font-size:18px; color:#fff;">KETIKA Hati Memilih</h3>
          <p style="font-size:12px; color:var(--bento-muted);">Ustadz Dr. Syafiq Riza Basalamah</p>
        </div>

        <!-- Background Stack Card 2 -->
        <div class="stack-card bg-card-2">
          <div class="card-header-badge">
            <span class="tag">SESI PAGI</span>
          </div>
          <h3 style="font-size:18px; color:#fff;">SETIAP KITA, ADA MAHAKARYA</h3>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 2. BENTO GRID HIGHLIGHTS SECTION -->
<section class="bento-section" id="bento">
  <div class="section-title-wrap">
    <h2>Highlight & Fasilitas Event</h2>
    <p>Pengalaman konferensi & pendaftaran tiket yang cepat, transparan, dan modern</p>
  </div>

  <div class="bento-grid">
    <!-- Item 1: Speaker Spotlight (Span 2) -->
    <div class="bento-item span-2">
      <div>
        <div class="icon-glow">🎙️</div>
        <h3>Pemateri Terbaik & Berpengalaman</h3>
        <p>
          Menghadirkan narasumber utama berpengaruh untuk menyampaikan ilmu syar'i, kesehatan, dan inspirasi kehidupan dalam suasana yang khidmat di Jakarta International Convention Center.
        </p>
      </div>

      <div style="display:flex; gap:16px; margin-top:24px; flex-wrap:wrap;">
        <span style="background:rgba(255,255,255,0.06); padding:8px 16px; border-radius:999px; font-size:12px; border:1px solid rgba(255,255,255,0.1);">Ust. Dr. Khalid Basalamah</span>
        <span style="background:rgba(255,255,255,0.06); padding:8px 16px; border-radius:999px; font-size:12px; border:1px solid rgba(255,255,255,0.1);">Ust. Dr. Syafiq Riza Basalamah</span>
        <span style="background:rgba(255,255,255,0.06); padding:8px 16px; border-radius:999px; font-size:12px; border:1px solid rgba(255,255,255,0.1);">dr. Bobby Arfhan Anwar</span>
      </div>
    </div>

    <!-- Item 2: Lokasi & Akses -->
    <div class="bento-item">
      <div>
        <div class="icon-glow">📍</div>
        <h3>Lokasi Strategis</h3>
        <p>Jakarta International Convention Center (JICC) Senayan. Akses mudah dengan transportasi publik & fasilitas lengkap.</p>
      </div>
      <div style="font-size:12px; color:var(--bento-emerald); font-weight:600; margin-top:20px;">Sabtu, 20 Juni 2026</div>
    </div>

    <!-- Item 3: Parallel Fairs -->
    <div class="bento-item">
      <div>
        <div class="icon-glow">🎪</div>
        <h3>Parallel Events</h3>
        <p>Umroh & Hajj Fair, Halal Culinary Fair, dan Interactive Kids Corner.</p>
      </div>
      <div style="display:flex; gap:8px; margin-top:16px;">
        <span style="font-size:11px; background:rgba(6,182,212,0.15); color:var(--bento-cyan); padding:4px 10px; border-radius:6px;">Halal Fair</span>
        <span style="font-size:11px; background:rgba(99,102,241,0.15); color:var(--bento-indigo); padding:4px 10px; border-radius:6px;">Travel Fair</span>
      </div>
    </div>

    <!-- Item 4: Instant E-Ticket (Span 2) -->
    <div class="bento-item span-2">
      <div>
        <div class="icon-glow">🎟️</div>
        <h3>E-Tiket Instant dengan QR Code</h3>
        <p>Setelah melakukan konfirmasi, tiket digital lengkap dengan kode transaksi unik dan QR Code akan langsung diterbitkan untuk kemudahan check-in di lokasi.</p>
      </div>
      <div style="margin-top:20px; font-size:13px; color:var(--bento-emerald); font-weight:700;">Simulasi Pendaftaran Real-Time Active ✓</div>
    </div>

    <!-- Item 5: Gallery Highlights (Span 3) -->
    <div class="bento-item span-3">
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
        <h3 style="margin:0;">Dokumentasi & Galeri Acara</h3>
        <span style="font-size:13px; color:var(--bento-muted);">Klik foto untuk memperbesar</span>
      </div>

      <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
        <div style="height:160px; border-radius:16px; overflow:hidden; cursor:pointer;" onclick="openPhotoModal('Kajian Akbar Utama', 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=800&q=80')">
          <img src="https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=500&q=80" style="width:100%; height:100%; object-fit:cover; transition:.3s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
        </div>
        <div style="height:160px; border-radius:16px; overflow:hidden; cursor:pointer;" onclick="openPhotoModal('Khidmat Jamaah JICC', 'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=800&q=80')">
          <img src="https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=500&q=80" style="width:100%; height:100%; object-fit:cover; transition:.3s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
        </div>
        <div style="height:160px; border-radius:16px; overflow:hidden; cursor:pointer;" onclick="openPhotoModal('Suasana Inspiratif', 'https://images.unsplash.com/photo-1519817650390-64a93db51149?auto=format&fit=crop&w=800&q=80')">
          <img src="https://images.unsplash.com/photo-1519817650390-64a93db51149?auto=format&fit=crop&w=500&q=80" style="width:100%; height:100%; object-fit:cover; transition:.3s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
        </div>
        <div style="height:160px; border-radius:16px; overflow:hidden; cursor:pointer;" onclick="openPhotoModal('Exhibition Area', 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=800&q=80')">
          <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=500&q=80" style="width:100%; height:100%; object-fit:cover; transition:.3s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 3. SESSIONS SCHEDULE & BOOKING LIST -->
<section class="bento-section" id="sessions" style="padding-top:20px;">
  <div class="section-title-wrap">
    <h2>Jadwal Sesi & Pendaftaran Tiket</h2>
    <p>Pilih sesi yang ingin Anda ikuti dan klik untuk mendaftar</p>
  </div>

  <div class="sessions-list">
    @forelse($events as $event)
      <a href="{{ route('peserta.detail', $event) }}" class="session-card-row" style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
        <div style="display: flex; align-items: center; gap: 16px;">
          <!-- Event Poster Thumbnail -->
          <div style="width: 72px; height: 72px; border-radius: 14px; overflow: hidden; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); flex-shrink: 0;">
            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
          </div>

          <div class="session-info">
            <div class="session-time-badge" style="display: inline-flex; align-items: center; gap: 6px;">
              <span>⏱️ {{ $event->time_slot ?? '10.00 WIB' }}</span>
              <span>·</span>
              <span>📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
            </div>

            <div class="session-details" style="margin-top: 6px;">
              <div class="s-title" style="font-size: 16px; font-weight: 700;">{{ $event->title }}</div>
              <div class="s-speaker" style="margin-top: 2px;">🎙️ {{ $event->speaker ?? 'Pemateri Utama' }} · 📍 {{ $event->location }}</div>
            </div>
          </div>
        </div>

        <div class="btn-session-action">
          PILIH & DAFTAR TIKET →
        </div>
      </a>
    @empty
      <div class="empty" style="color:#fff; text-align:center; padding:40px;">Belum ada sesi yang tersedia.</div>
    @endforelse
  </div>
</section>

<!-- 4. MODERN TECH FOOTER -->
<footer class="bento-footer">
  <div class="footer-inner">
    <div class="footer-brand">
      <div class="name">EventFlow</div>
      <div class="sub">Platform Ticketing Seminar & Kajian Akbar</div>
    </div>

    <div class="footer-links">
      <a href="#sessions">Jadwal Sesi</a>
      <a href="#bento">Highlight</a>
      <a href="{{ route('admin.login') }}">Panel Admin</a>
    </div>

    <div style="font-size:13px; color:var(--bento-muted);">
      © 2026 EventFlow. All rights reserved.
    </div>
  </div>
</footer>

<!-- MODAL LIGHTBOX PHOTO -->
<div class="modal-backdrop" id="photoModal">
  <div class="modal-content-box">
    <button class="modal-close-btn" onclick="closePhotoModal()">✕</button>
    <div class="modal-photo-preview">
      <img id="modalPhotoImg" src="" alt="Preview">
    </div>
    <div class="modal-photo-title" id="modalPhotoTitle"></div>
  </div>
</div>

<!-- MODAL EVENT REGISTRATION -->
<div class="modal-backdrop" id="eventModal">
  <div class="modal-content-box">
    <button class="modal-close-btn" onclick="closeEventModal()">✕</button>
    <div class="modal-event-detail">
      <div class="detail-speaker" id="modalEventSpeaker"></div>
      <div class="detail-title" id="modalEventTitle"></div>
      
      <div class="detail-meta-list">
        <div>📅 <strong>Tanggal & Waktu:</strong> <span id="modalEventDate"></span> (<span id="modalEventTime"></span>)</div>
        <div>📍 <strong>Lokasi:</strong> <span id="modalEventLocation"></span></div>
      </div>

      <div class="detail-desc" id="modalEventDesc"></div>

      <a id="modalEventRegisterLink" href="#" class="btn-register-modal">LANJUTKAN REGISTRASI TIKET</a>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
// Countdown Timer logic
(function startCountdown() {
  const targetDate = new Date('2026-06-20T08:00:00').getTime();
  
  function updateCD() {
    const now = new Date().getTime();
    const diff = targetDate - now;

    if (diff <= 0) return;

    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const secs = Math.floor((diff % (1000 * 60)) / 1000);

    const dEl = document.getElementById('cdDays');
    const hEl = document.getElementById('cdHours');
    const mEl = document.getElementById('cdMins');
    const sEl = document.getElementById('cdSecs');

    if (dEl) dEl.textContent = String(days).padStart(2, '0');
    if (hEl) hEl.textContent = String(hours).padStart(2, '0');
    if (mEl) mEl.textContent = String(mins).padStart(2, '0');
    if (sEl) sEl.textContent = String(secs).padStart(2, '0');
  }

  updateCD();
  setInterval(updateCD, 1000);
})();

// Photo Modal Lightbox functions
function openPhotoModal(title, imgSrc) {
  document.getElementById('modalPhotoTitle').textContent = title;
  document.getElementById('modalPhotoImg').src = imgSrc;
  document.getElementById('photoModal').classList.add('active');
}

function closePhotoModal() {
  document.getElementById('photoModal').classList.remove('active');
}

// Event Poster Modal functions
function openEventModal(id, title, speaker, timeSlot, date, location, desc, detailUrl) {
  document.getElementById('modalEventTitle').textContent = title;
  document.getElementById('modalEventSpeaker').textContent = speaker;
  document.getElementById('modalEventTime').textContent = timeSlot;
  document.getElementById('modalEventDate').textContent = date;
  document.getElementById('modalEventLocation').textContent = location;
  document.getElementById('modalEventDesc').textContent = desc;
  document.getElementById('modalEventRegisterLink').href = detailUrl;
  
  document.getElementById('eventModal').classList.add('active');
}

function closeEventModal() {
  document.getElementById('eventModal').classList.remove('active');
}

// Close modals on backdrop click
document.addEventListener('DOMContentLoaded', function() {
  const pM = document.getElementById('photoModal');
  const eM = document.getElementById('eventModal');
  if(pM) pM.addEventListener('click', function(e) { if (e.target === this) closePhotoModal(); });
  if(eM) eM.addEventListener('click', function(e) { if (e.target === this) closeEventModal(); });
});
</script>
@endpush
