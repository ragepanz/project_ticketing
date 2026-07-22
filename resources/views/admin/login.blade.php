@extends('layouts.app')

@section('title', 'Login Admin')

@section('body_class', 'login-page')

@section('fullwidth')
<div class="admin-login-screen">
  <!-- Top Bar -->
  <header class="admin-login-header">
    <a href="{{ route('peserta.index') }}" class="admin-login-brand">
      <div class="brand-logo">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 5V7M15 11V13M15 17V19M5 5H19C20.1 5 21 5.9 21 7V9.5C19.9 9.5 19 10.4 19 11.5C19 12.6 19.9 13.5 21 13.5V17C21 18.1 20.1 19 19 19H5C3.9 19 3 18.1 3 17V13.5C4.1 13.5 5 12.6 5 11.5C5 10.4 4.1 9.5 3 9.5V7C3 5.9 3.9 5 5 5Z"/>
        </svg>
      </div>
      <span class="brand-text">EventFlow</span>
      <span class="brand-badge">ADMIN PORTAL</span>
    </a>
    <a href="{{ route('peserta.index') }}" class="admin-back-btn">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
      <span>Ke Web Peserta</span>
    </a>
  </header>

  <!-- Login Card Container -->
  <div class="admin-login-container">
    <div class="admin-login-card">
      <div class="admin-login-card-head">
        <div class="admin-card-icon">
          <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
        </div>
        <h2>Login Admin</h2>
        <p>Masuk ke panel administrasi EventFlow untuk mengelola event &amp; peserta.</p>
      </div>

      @if($errors->any())
      <div class="admin-login-error">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ $errors->first('email') ?: 'Email atau password yang Anda masukkan salah.' }}</span>
      </div>
      @endif

      <form method="POST" action="{{ route('admin.authenticate') }}">
        @csrf
        
        <div class="admin-field-group">
          <label for="email">Alamat Email</label>
          <div class="admin-input-wrapper">
            <span class="admin-input-icon">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </span>
            <input id="email" name="email" type="email" value="{{ old('email', 'admin@eventflow.id') }}" placeholder="email@domain.com" required autofocus class="admin-input">
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
            <input id="password" type="password" name="password" value="admin123" placeholder="••••••••" required class="admin-input">
            <button type="button" class="admin-toggle-pwd" onclick="togglePasswordVisibility()" title="Tampilkan / Sembunyikan Password">
              <svg id="eye-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-admin-submit">
          <span>Masuk Ke Dashboard</span>
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
          </svg>
        </button>
      </form>

      <div class="admin-demo-box">
        <div class="admin-demo-info">
          <div>Kredensial Demo:</div>
          <strong>admin@eventflow.id</strong> / <strong>admin123</strong>
        </div>
        <button type="button" class="btn-fill-demo" onclick="fillDemoCredentials()">
          ⚡ Auto Fill
        </button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="admin-login-footer">
    🔒 EventFlow Secured Admin Portal &copy; {{ date('Y') }} All Rights Reserved.
  </footer>
</div>
@endsection

@push('scripts')
<script>
function togglePasswordVisibility() {
  const pwdInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eye-icon');
  if (!pwdInput) return;

  if (pwdInput.type === 'password') {
    pwdInput.type = 'text';
    eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 014.122-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-4.09-4.09a3 3 0 00-4.243-4.243M3 3l18 18" />`;
  } else {
    pwdInput.type = 'password';
    eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
  }
}

function fillDemoCredentials() {
  document.getElementById('email').value = 'admin@eventflow.id';
  document.getElementById('password').value = 'admin123';
  showToast('Kredensial demo berhasil diisi!');
}
</script>
@endpush
