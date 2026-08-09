@extends('layouts.app')

@section('title', 'My Account — KKA Official')

@section('body_class', 'dark-mode')

@section('fullwidth')
<div class="client-dashboard-wrap">

  <!-- Page Header -->
  <div class="client-dash-header">
    <div class="client-dash-header-inner">
      <div class="client-dash-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
      <div class="client-dash-info">
        <h1 class="client-dash-name">{{ $user->name }}</h1>
        <p class="client-dash-email">{{ $user->email }}</p>
      </div>
      <a href="{{ route('client.logout') }}" class="client-dash-logout">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
        <span>Keluar</span>
      </a>
    </div>
  </div>

  <!-- Tickets Section -->
  <div class="client-dash-container">
    <h2 class="client-dash-section-title">
      <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5V7M15 11V13M15 17V19M5 5H19C20.1 5 21 5.9 21 7V9.5C19.9 9.5 19 10.4 19 11.5C19 12.6 19.9 13.5 21 13.5V17C21 18.1 20.1 19 19 19H5C3.9 19 3 18.1 3 17V13.5C4.1 13.5 5 12.6 5 11.5C5 10.4 4.1 9.5 3 9.5V7C3 5.9 3.9 5 5 5Z"/>
      </svg>
      Tiket Saya <span class="ticket-count">{{ $participants->count() }}</span>
    </h2>

    @forelse($participants as $p)
    <div class="client-ticket-card">
      <div class="client-ticket-info">
        <div class="client-ticket-event">{{ $p->event->title ?? 'Event' }}</div>
        <div class="client-ticket-meta">
          @if($p->event)
            <span>{{ \Carbon\Carbon::parse($p->event->date)->format('d M Y') }}</span>
            <span class="dot">·</span>
            <span>{{ $p->event->location ?? '' }}</span>
          @endif
        </div>
        <div class="client-ticket-trx">Kode Tiket: #{{ $p->trx_id }}</div>
      </div>
      <div class="client-ticket-status">
        @if($p->status === 'lunas')
          <span class="status-badge status-paid">LUNAS</span>
        @else
          <span class="status-badge status-pending">PENDING</span>
        @endif
        @if($p->checked_in)
          <div class="checkin-label">✓ Sudah Check-in</div>
        @endif
      </div>
    </div>
    @empty
    <div class="client-empty-state">
      <svg width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5V7M15 11V13M15 17V19M5 5H19C20.1 5 21 5.9 21 7V9.5C19.9 9.5 19 10.4 19 11.5C19 12.6 19.9 13.5 21 13.5V17C21 18.1 20.1 19 19 19H5C3.9 19 3 18.1 3 17V13.5C4.1 13.5 5 12.6 5 11.5C5 10.4 4.1 9.5 3 9.5V7C3 5.9 3.9 5 5 5Z"/>
      </svg>
      <p>Belum ada tiket yang terdaftar.</p>
      <a href="{{ route('peserta.index') }}" class="client-empty-cta">Daftar Event Sekarang →</a>
    </div>
    @endforelse
  </div>

</div>
@endsection