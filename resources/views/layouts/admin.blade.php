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
      <span class="tixia-brand-name">Tixia<span class="tixia-dot">.</span></span>
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

        <!-- Notification Bell -->
        <button class="tixia-icon-btn" title="Notifications">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 17H3L5 15V9a7 7 0 1114 0v6l2 2h-6m-6 0a3 3 0 006 0"/></svg>
          <span class="dot-badge yellow"></span>
        </button>

        <!-- Message/Chat Icon -->
        <button class="tixia-icon-btn" title="Messages">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
          <span class="dot-badge green"></span>
        </button>

        <!-- User Profile Avatar -->
        <div class="tixia-user-profile">
          <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Admin Avatar" class="tixia-avatar">
        </div>

        <!-- Schedule Event Interactive Dropdown -->
        <div style="position: relative;">
          <button type="button" class="tixia-btn-primary" onclick="toggleScheduleDropdown(event)">
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
function toggleScheduleDropdown(e) {
  e.stopPropagation();
  const dd = document.getElementById('schedule-dropdown-menu');
  if (dd) dd.classList.toggle('open');
}
document.addEventListener('click', function(e) {
  const dd = document.getElementById('schedule-dropdown-menu');
  if (dd && dd.classList.contains('open') && !dd.contains(e.target)) {
    dd.classList.remove('open');
  }
});
</script>
@endsection
