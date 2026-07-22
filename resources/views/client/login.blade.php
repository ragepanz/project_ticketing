@extends('layouts.app')

@section('title', 'Login Peserta')

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
      <span class="brand-badge">PESERTA PORTAL</span>
    </a>
    <a href="{{ route('peserta.index') }}" class="admin-back-btn">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
      <span>Ke Beranda</span>
    </a>
  </header>

  <div class="admin-login-container">
    <div class="admin-login-card">
      <div class="admin-login-card-head">
        <div class="admin-card-icon">
          <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </div>
        <h2>Login Peserta</h2>
        <p>Masuk untuk melihat tiket dan riwayat pendaftaran event Anda.</p>
      </div>

      @if(session('success'))
      <div class="admin-login-error" style="background:#ecfdf5;color:#065f46;border-color:#a7f3d0;">
        <span>{{ session('success') }}</span>
      </div>
      @endif

      @if($errors->any())
      <div class="admin-login-error">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ $errors->first('email') ?: 'Email atau password yang Anda masukkan salah.' }}</span>
      </div>
      @endif

      <form method="POST" action="{{ route('client.authenticate') }}">
        @csrf

        <div class="admin-field-group">
          <label for="email">Alamat Email</label>
          <div class="admin-input-wrapper">
            <span class="admin-input-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </span>
            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="email@domain.com" required autofocus class="admin-input">
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
            <input id="password" type="password" name="password" placeholder="password" required class="admin-input">
          </div>
        </div>

        <button type="submit" class="btn-admin-submit">
          <span>Masuk</span>
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
          </svg>
        </button>
      </form>

      <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #64748b;">
        Belum punya akun?
        <a href="{{ route('client.register') }}" style="color: #383be5; font-weight: 600; text-decoration: none;">Daftar disini</a>
      </div>
    </div>
  </div>

  <footer class="admin-login-footer">
    EventFlow Peserta Portal &copy; {{ date('Y') }} All Rights Reserved.
  </footer>
</div>
@endsection