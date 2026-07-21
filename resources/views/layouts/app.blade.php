<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'EventFlow 2026') — Platform Tiket Seminar & Kajian</title>
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
  <div class="prototype-switch-bar">
    <div class="brand-mini">
      <div class="mark">E</div>
      <span class="txt">EventFlow 2026</span>
    </div>
    <div class="persona-switch">
      <a href="{{ route('peserta.index') }}" class="{{ request()->routeIs('peserta.index') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('peserta.search-order') }}" class="{{ request()->routeIs('peserta.search-order') ? 'active' : '' }}">🔍 Cek Tiket Saya</a>
    </div>
  </div>
  @endif

  @yield('fullwidth')
@else
<div class="app-shell">
  <div class="topbar">
    <div class="brand">
      <a href="{{ route('peserta.index') }}" style="display:flex; align-items:center; gap:10px;">
        <div class="mark">E</div>
        <div class="name">EventFlow</div>
        <div class="tag">Pendaftaran Tiket Online</div>
      </a>
    </div>
    <div class="persona-switch">
      <a href="{{ route('peserta.index') }}" class="{{ request()->routeIs('peserta.index') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('peserta.search-order') }}" class="{{ request()->routeIs('peserta.search-order') ? 'active' : '' }}">🔍 Cek Tiket</a>
    </div>
  </div>

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
