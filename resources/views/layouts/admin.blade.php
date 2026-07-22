@extends('layouts.app')

@section('fullwidth')
<div class="tixia-admin-shell">
  <!-- Tixia Royal Blue Sidebar -->
  <aside class="tixia-sidebar">
    <!-- Brand Header -->
    <div class="tixia-brand">
      <div class="tixia-brand-icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 12V6C20 4.89543 19.1046 4 18 4H6C4.89543 4 4 4.89543 4 6V12C5.10457 12 6 12.8954 6 14C6 15.1046 5.10457 16 4 16V18C4 19.1046 4.89543 20 6 20H18C19.1046 20 20 19.1046 20 18V16C18.8954 16 18 15.1046 18 14C18 12.8954 18.8954 12 20 12Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
          <path d="M9 9H15M9 15H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </div>
      <span class="tixia-brand-name">EventFlow<span class="tixia-dot">.</span></span>
    </div>

    <!-- Main Nav Menu -->
    <nav class="tixia-nav">
      <a href="{{ route('admin.dashboard') }}" class="tixia-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="nav-ico">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </span>
        <span class="nav-txt">Dashboard</span>
      </a>

      <a href="{{ route('admin.events') }}" class="tixia-nav-item {{ request()->routeIs('admin.events*') ? 'active' : '' }}">
        <span class="nav-ico">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </span>
        <span class="nav-txt">Kelola Event</span>
      </a>

      <a href="{{ route('admin.participants') }}" class="tixia-nav-item {{ request()->routeIs('admin.participants*') ? 'active' : '' }}">
        <span class="nav-ico">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </span>
        <span class="nav-txt">Data Peserta</span>
      </a>

      <a href="{{ route('admin.scan') }}" class="tixia-nav-item {{ request()->routeIs('admin.scan*') ? 'active' : '' }}">
        <span class="nav-ico">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
        </span>
        <span class="nav-txt">Scan QR Check-in</span>
      </a>

      <a href="{{ route('admin.reports') }}" class="tixia-nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
        <span class="nav-ico">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </span>
        <span class="nav-txt">Laporan & Analytics</span>
      </a>
    </nav>

    <!-- Sidebar Bottom -->
    <div class="tixia-sidebar-bottom">
      <a href="{{ route('peserta.index') }}" class="tixia-nav-item" target="_blank">
        <span class="nav-ico">🌐</span>
        <span class="nav-txt">Web Peserta ↗</span>
      </a>
      <a href="{{ route('admin.logout') }}" class="tixia-nav-item logout">
        <span class="nav-ico">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        </span>
        <span class="nav-txt">Logout</span>
      </a>
      <div class="tixia-copyright">
        Tixia Ticketing Admin Dashboard<br>© 2026 All Rights Reserved
      </div>
    </div>
  </aside>

  <!-- Main Workspace -->
  <main class="tixia-main">
    <header class="tixia-topbar">
      <div class="tixia-topbar-left">
        <div class="tixia-title-wrap">
          <h1 class="tixia-page-title">@yield('page_title', 'Orders')</h1>
          <div class="tixia-breadcrumb">
            <span class="b-parent">Event</span> / <span class="b-child">@yield('page_title', 'Order List')</span>
          </div>
        </div>
      </div>

      <div class="tixia-topbar-right">
        <!-- Search bar -->
        <form action="{{ route('admin.participants') }}" method="GET" class="tixia-search-box">
          <svg class="search-ico" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="7" cy="7" r="5"/><path d="M11 11l4 4"/></svg>
          <input type="text" name="search" placeholder="Search here" value="{{ request('search') }}" class="tixia-search-input">
        </form>

        <!-- Notification Bell Dropdown -->
        <div style="position: relative;">
          <button type="button" class="tixia-icon-btn" title="Notifikasi Sistem" onclick="toggleTopbarDropdown(event, 'notif-dropdown')">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="dot-badge yellow"></span>
          </button>
          
          <div class="tixia-dropdown-menu" id="notif-dropdown">
            <div class="dd-header" style="display:flex; justify-content:space-between; align-items:center;">
              <span>Notifikasi System</span>
              <span style="font-size:10px; background:#10b981; color:#ffffff; padding:2px 7px; border-radius:10px; font-weight:700;">3 BARU</span>
            </div>
            <div class="dd-list">
              <a href="{{ route('admin.participants') }}" class="dd-item">
                <div class="dd-title">🎟️ Pendaftaran Baru #TRX-8291</div>
                <div class="dd-meta">Budi Santoso memesan 1 tiket Seminar — 4m lalu</div>
              </a>
              <a href="{{ route('admin.scan') }}" class="dd-item">
                <div class="dd-title">📷 Presensi QR Check-in</div>
                <div class="dd-meta">Siti Rahma telah berhasil verified check-in — 18m lalu</div>
              </a>
              <a href="{{ route('admin.reports') }}" class="dd-item">
                <div class="dd-title">📈 Milestone Kuota Event</div>
                <div class="dd-meta">Event flow tiket terjual melebihi 85% — 1j lalu</div>
              </a>
            </div>
            <div class="dd-footer">
              <a href="{{ route('admin.participants') }}" class="dd-action">Lihat Semua Data Peserta</a>
            </div>
          </div>
        </div>

        <!-- Message/Chat Dropdown -->
        <div style="position: relative;">
          <button type="button" class="tixia-icon-btn" title="Pesan & Pertanyaan" onclick="toggleTopbarDropdown(event, 'msg-dropdown')">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span class="dot-badge green"></span>
          </button>

          <div class="tixia-dropdown-menu" id="msg-dropdown">
            <div class="dd-header">Pesan Peserta</div>
            <div class="dd-list">
              <a href="{{ route('admin.participants') }}" class="dd-item">
                <div class="dd-title">💬 Ahmad Rizky</div>
                <div class="dd-meta">"Halo min, apakah invoice bisa dikirim ulang?" — 12m lalu</div>
              </a>
              <a href="{{ route('admin.participants') }}" class="dd-item">
                <div class="dd-title">💬 Maya Putri</div>
                <div class="dd-meta">"Konfirmasi pembayaran QRIS sudah terverifikasi?" — 42m lalu</div>
              </a>
            </div>
            <div class="dd-footer">
              <a href="{{ route('admin.participants') }}" class="dd-action">Kelola Data Peserta</a>
            </div>
          </div>
        </div>

        <!-- User Profile Avatar Dropdown -->
        <div style="position: relative;">
          <button type="button" class="tixia-user-profile" onclick="toggleTopbarDropdown(event, 'profile-dropdown')" style="background:none; border:none; padding:0; cursor:pointer;" title="Profil Administrator">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Admin Avatar" class="tixia-avatar">
          </button>

          <div class="tixia-dropdown-menu" id="profile-dropdown" style="width: 250px;">
            <div style="padding:14px 16px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:12px; background: #f8fafc;">
              <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" style="width:38px; height:38px; border-radius:50%; object-fit:cover;">
              <div style="overflow: hidden;">
                <div style="font-weight:700; font-size:13.5px; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Administrator</div>
                <div style="font-size:11.5px; color:#64748b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">admin@eventflow.id</div>
              </div>
            </div>
            <div class="dd-list">
              <a href="{{ route('admin.dashboard') }}" class="dd-item">
                <div class="dd-title">📊 Dashboard Utama</div>
              </a>
              <a href="{{ route('admin.events') }}" class="dd-item">
                <div class="dd-title">📅 Kelola Event</div>
              </a>
              <a href="{{ route('admin.reports') }}" class="dd-item">
                <div class="dd-title">📈 Laporan Penjualan</div>
              </a>
              <a href="{{ route('peserta.index') }}" class="dd-item" target="_blank">
                <div class="dd-title">🌐 Web Peserta ↗</div>
              </a>
            </div>
            <div class="dd-footer" style="background:#fff0f3; border-top:1px solid #ffe4e6;">
              <a href="{{ route('admin.logout') }}" class="dd-action" style="color:#e11d48; display:flex; align-items:center; justify-content:center; gap:6px;">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Keluar (Logout)</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Schedule Event Interactive Dropdown -->
        <div style="position: relative;">
          <button type="button" class="tixia-btn-primary" onclick="toggleTopbarDropdown(event, 'schedule-dropdown-menu')">
            <span class="btn-icon">📅</span>
            <span>Schedule Event ({{ \App\Models\Event::count() }})</span>
            <span class="btn-arrow">▾</span>
          </button>
          
          <div class="tixia-dropdown-menu" id="schedule-dropdown-menu">
            <div class="dd-header">Jadwal Event Aktif</div>
            <div class="dd-list">
              @forelse(\App\Models\Event::latest()->take(5)->get() as $ev)
              <a href="{{ route('admin.events') }}" class="dd-item">
                <div class="dd-title">{{ $ev->title }}</div>
                <div class="dd-meta">📅 {{ \Carbon\Carbon::parse($ev->date)->format('d M Y') }} · 📍 {{ $ev->location }}</div>
              </a>
              @empty
              <div class="dd-item" style="color: #94a3b8; font-size: 13px;">Belum ada event diselenggarakan.</div>
              @endforelse
            </div>
            <div class="dd-footer">
              <a href="{{ route('admin.events') }}" class="dd-action">+ Kelola & Tambah Event Baru</a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="tixia-content">
      @yield('admin-content')
    </div>
  </main>
</div>

<script>
function toggleTopbarDropdown(e, dropdownId) {
  e.stopPropagation();
  const targetDd = document.getElementById(dropdownId);
  const allDropdowns = document.querySelectorAll('.tixia-dropdown-menu');

  allDropdowns.forEach(dd => {
    if (dd.id !== dropdownId) {
      dd.classList.remove('open');
    }
  });

  if (targetDd) {
    targetDd.classList.toggle('open');
  }
}

document.addEventListener('click', function(e) {
  const allDropdowns = document.querySelectorAll('.tixia-dropdown-menu');
  allDropdowns.forEach(dd => {
    if (dd.classList.contains('open') && !dd.contains(e.target)) {
      dd.classList.remove('open');
    }
  });
});
</script>
@endsection
