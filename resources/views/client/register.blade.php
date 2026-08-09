@extends('layouts.app')

@section('title', 'Daftar Akun Peserta')

@section('body_class', 'login-page')

@section('fullwidth')
<div class="admin-login-screen">
  <header class="admin-login-header"></header>

  <div class="admin-login-container">
    <div class="admin-login-card">
      <div class="admin-login-card-head">
        <div class="admin-card-icon">
          <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
          </svg>
        </div>
        <h2>Daftar Akun Baru</h2>
        <p>Buat akun untuk melihat tiket dan riwayat pendaftaran event Anda.</p>
      </div>

      @if($errors->any())
      <div class="admin-login-error">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ $errors->first() }}</span>
      </div>
      @endif

      <form method="POST" action="{{ route('client.store-register') }}">
        @csrf

        <div class="admin-field-group">
          <label for="name">Nama Lengkap</label>
          <div class="admin-input-wrapper">
            <span class="admin-input-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </span>
            <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Nama lengkap" required autofocus class="admin-input">
          </div>
        </div>

        <div class="admin-field-group">
          <label for="email">Alamat Email</label>
          <div class="admin-input-wrapper">
            <span class="admin-input-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </span>
            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="email@domain.com" required class="admin-input">
          </div>
        </div>

        <div class="admin-field-group">
          <label for="phone">No. WhatsApp</label>
          <div class="admin-input-wrapper">
            <span class="admin-input-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
            </span>
            <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required class="admin-input">
          </div>
        </div>

        <div class="admin-field-group">
          <label for="password">Kata Sandi</label>
          <div class="admin-input-wrapper">
            <span class="admin-input-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </span>
            <input id="password" type="password" name="password" placeholder="Minimal 6 karakter" required class="admin-input">
          </div>
        </div>

        <div class="admin-field-group">
          <label for="password_confirmation">Konfirmasi Kata Sandi</label>
          <div class="admin-input-wrapper">
            <span class="admin-input-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </span>
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password" required class="admin-input">
          </div>
        </div>

        <button type="submit" class="btn-admin-submit">
          <span>Daftar</span>
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
          </svg>
        </button>
      </form>

      <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #64748b;">
        Sudah punya akun?
        <a href="{{ route('client.login') }}" style="color: #383be5; font-weight: 600; text-decoration: none;">Login disini</a>
      </div>
    </div>
  </div>

  <footer class="admin-login-footer">
    EventFlow Peserta Portal &copy; {{ date('Y') }} All Rights Reserved.
  </footer>
</div>
@endsection