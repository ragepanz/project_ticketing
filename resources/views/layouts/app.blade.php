<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'EventFlow 2026') — EventFlow Ticketing</title>
@stack('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=IBM+Plex Mono:wght@400;500;600&family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="@yield('body_class', '')">

@if(View::hasSection('fullwidth'))
  @if(!request()->routeIs('admin.*'))
  <!-- Public User Top Bar -->
  <header class="public-navbar">
    <div class="nav-container">
      <div class="nav-brand-group">
        <a href="{{ route('peserta.index') }}" class="nav-brand">
          <div class="mark">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5V7M15 11V13M15 17V19M5 5H19C20.1 5 21 5.9 21 7V9.5C19.9 9.5 19 10.4 19 11.5C19 12.6 19.9 13.5 21 13.5V17C21 18.1 20.1 19 19 19H5C3.9 19 3 18.1 3 17V13.5C4.1 13.5 5 12.6 5 11.5C5 10.4 4.1 9.5 3 9.5V7C3 5.9 3.9 5 5 5Z"/></svg>
          </div>
          <span class="txt">EventFlow</span>
        </a>
        <nav class="nav-menu">
          <a href="{{ route('peserta.index') }}" class="nav-item {{ request()->routeIs('peserta.index') ? 'active' : '' }}">Beranda</a>
          <a href="{{ route('peserta.search-order') }}" class="nav-item {{ request()->routeIs('peserta.search-order') ? 'active' : '' }}">Cek Tiket Saya</a>
        </nav>
      </div>

      <div class="nav-auth-group">
        @auth
          @if(Auth::user()->role === 'client')
            <a href="{{ route('client.dashboard') }}" class="btn-nav-dash">Dashboard Saya</a>
            <a href="{{ route('client.logout') }}" class="btn-nav-logout">Logout</a>
          @else
            <a href="{{ route('admin.dashboard') }}" class="btn-nav-dash">Panel Admin</a>
            <a href="{{ route('admin.logout') }}" class="btn-nav-logout">Logout</a>
          @endif
        @else
          <a href="{{ route('client.login') }}" class="btn-nav-login {{ request()->routeIs('client.login') ? 'active' : '' }}">Login</a>
          <a href="{{ route('client.register') }}" class="btn-nav-register">Register</a>
        @endauth
      </div>
    </div>
  </header>
  @endif

  @yield('fullwidth')
@else
<div class="app-shell">
  <header class="public-navbar inner-topbar">
    <div class="nav-container">
      <div class="nav-brand-group">
        <a href="{{ route('peserta.index') }}" class="nav-brand">
          <div class="mark">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5V7M15 11V13M15 17V19M5 5H19C20.1 5 21 5.9 21 7V9.5C19.9 9.5 19 10.4 19 11.5C19 12.6 19.9 13.5 21 13.5V17C21 18.1 20.1 19 19 19H5C3.9 19 3 18.1 3 17V13.5C4.1 13.5 5 12.6 5 11.5C5 10.4 4.1 9.5 3 9.5V7C3 5.9 3.9 5 5 5Z"/></svg>
          </div>
          <span class="txt">EventFlow</span>
        </a>
        <nav class="nav-menu">
          <a href="{{ route('peserta.index') }}" class="nav-item {{ request()->routeIs('peserta.index') ? 'active' : '' }}">Beranda</a>
          <a href="{{ route('peserta.search-order') }}" class="nav-item {{ request()->routeIs('peserta.search-order') ? 'active' : '' }}">Cek Tiket</a>
        </nav>
      </div>

      <div class="nav-auth-group">
        @auth
          @if(Auth::user()->role === 'client')
            <a href="{{ route('client.dashboard') }}" class="btn-nav-dash">Dashboard Saya</a>
            <a href="{{ route('client.logout') }}" class="btn-nav-logout">Logout</a>
          @else
            <a href="{{ route('admin.dashboard') }}" class="btn-nav-dash">Panel Admin</a>
            <a href="{{ route('admin.logout') }}" class="btn-nav-logout">Logout</a>
          @endif
        @else
          <a href="{{ route('client.login') }}" class="btn-nav-login {{ request()->routeIs('client.login') ? 'active' : '' }}">Login</a>
          <a href="{{ route('client.register') }}" class="btn-nav-register">Register</a>
        @endauth
      </div>
    </div>
  </header>

  <div class="panel" id="panel-root">
    @yield('content')
  </div>
</div>
@endif

<div class="toast" id="toast"></div>

@stack('scripts')

<script>
function showToast(msg) {
  const t = document.getElementById('toast');
  if(!t) return;
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(window.__toastTimer);
  window.__toastTimer = setTimeout(() => t.classList.remove('show'), 2200);
}

@if(session('success'))
document.addEventListener('DOMContentLoaded', () => showToast('{{ session('success') }}'));
@endif
</script>
</body>
</html>
