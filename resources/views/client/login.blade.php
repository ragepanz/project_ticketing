@extends('layouts.app')

@section('title', 'Login Portal — KKA Official')

@section('body_class', 'dark-mode')

@section('fullwidth')
<div class="auth-screen">
  <div class="auth-card-wrap">
    <div class="auth-card">
      <!-- Icon + Heading -->
      <div class="auth-card-head">
        <div class="auth-icon">
          <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </div>
        <h2>Masuk ke Portal</h2>
        <p>Masukkan email & password Anda. Sistem akan otomatis mengarahkan sesuai akun.</p>
      </div>

      @if(session('success'))
      <div class="auth-alert auth-alert--success">{{ session('success') }}</div>
      @endif
      @if(session('info'))
      <div class="auth-alert auth-alert--info">{{ session('info') }}</div>
      @endif
      @if($errors->any())
      <div class="auth-alert auth-alert--error">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ $errors->first('email') ?: 'Email atau password salah.' }}
      </div>
      @endif

      <form method="POST" action="{{ route('client.authenticate') }}" class="auth-form">
        @csrf
        @if(request('redirect'))<input type="hidden" name="redirect" value="{{ request('redirect') }}">@endif

        <div class="auth-field">
          <label for="email">Alamat Email</label>
          <div class="auth-input-wrap">
            <svg width="18" height="18" class="auth-input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="email@domain.com" required autofocus class="auth-input">
          </div>
        </div>

        <div class="auth-field">
          <label for="password">Kata Sandi</label>
          <div class="auth-input-wrap">
            <svg width="18" height="18" class="auth-input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <input id="password" type="password" name="password" placeholder="Kata sandi" required class="auth-input">
          </div>
        </div>

        <button type="submit" class="auth-submit-btn">
          Masuk
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
          </svg>
        </button>
      </form>

      <div class="auth-footer-link">
        Belum punya akun?
        <a href="{{ route('client.register') }}">Daftar disini</a>
      </div>
    </div>
  </div>
</div>
@endsection