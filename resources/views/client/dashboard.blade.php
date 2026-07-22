@extends('layouts.app')

@section('title', 'Dashboard Peserta')

@section('body_class', 'login-page')

@section('fullwidth')
<div class="admin-login-screen">
  <header class="admin-login-header">
    <a href="{{ route('peserta.index') }}" class="admin-login-brand">
      <div class="brand-logo">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 5V7M15 11V13M15 17V19M5 5H19C20.1 5 21 5.9 21 7V9.5C19.9 9.5 19 10.4 19 11.5C19 12.6 19.9 13.5 21 13.5V17C21 18.1 20.1 19 19 19H5C3.9 19 3 18.1 3 17V13.5C4.1 13.5 5 12.6 5 11.5C5 10.4 4.1 9.5 3 9.5V7C3 5.9 3.9 5 5 5Z"/>
        </svg>
      </div>
      <span class="brand-text">EventFlow</span>
      <span class="brand-badge">DASHBOARD PESERTA</span>
    </a>
    <div style="display: flex; gap: 8px;">
      <a href="{{ route('peserta.index') }}" class="admin-back-btn">
        <span>Ke Beranda</span>
      </a>
      <a href="{{ route('client.logout') }}" class="admin-back-btn" style="color: #ef4444;">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
        <span>Keluar</span>
      </a>
    </div>
  </header>

  <div class="admin-login-container" style="max-width: 800px;">
    <div class="admin-login-card" style="padding: 32px;">
      <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #383be5, #6366f1); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 22px;">
          {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
          <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">{{ $user->name }}</h2>
          <p style="font-size: 14px; color: #64748b; margin: 2px 0 0;">{{ $user->email }}</p>
        </div>
      </div>

      <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 16px;">Tiket Saya ({{ $participants->count() }})</h3>

      @forelse($participants as $p)
      <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;">
        <div>
          <div style="font-weight: 700; color: #1e293b;">{{ $p->event->title ?? 'Event' }}</div>
          <div style="font-size: 13px; color: #64748b; margin-top: 4px;">
            {{ $p->event ? \Carbon\Carbon::parse($p->event->date)->format('d M Y') : '' }} &middot;
            {{ $p->event->location ?? '' }}
          </div>
          <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">Kode: #{{ $p->trx_id }}</div>
        </div>
        <div style="text-align: right;">
          @if($p->status === 'lunas')
          <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; background: #ecfdf5; color: #065f46;">LUNAS</span>
          @else
          <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; background: #fef3c7; color: #92400e;">PENDING</span>
          @endif
          @if($p->checked_in)
          <div style="font-size: 11px; color: #383be5; font-weight: 600; margin-top: 4px;">Sudah Check-in</div>
          @endif
        </div>
      </div>
      @empty
      <div style="text-align: center; padding: 48px; color: #94a3b8;">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 12px; opacity: 0.5;">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 5V7M15 11V13M15 17V19M5 5H19C20.1 5 21 5.9 21 7V9.5C19.9 9.5 19 10.4 19 11.5C19 12.6 19.9 13.5 21 13.5V17C21 18.1 20.1 19 19 19H5C3.9 19 3 18.1 3 17V13.5C4.1 13.5 5 12.6 5 11.5C5 10.4 4.1 9.5 3 9.5V7C3 5.9 3.9 5 5 5Z"/>
        </svg>
        <div>Belum ada tiket yang terdaftar.</div>
        <a href="{{ route('peserta.index') }}" style="color: #383be5; font-weight: 600; text-decoration: none; display: inline-block; margin-top: 8px;">Daftar Event Sekarang</a>
      </div>
      @endforelse
    </div>
  </div>

  <footer class="admin-login-footer">
    EventFlow Peserta Portal &copy; {{ date('Y') }} All Rights Reserved.
  </footer>
</div>
@endsection