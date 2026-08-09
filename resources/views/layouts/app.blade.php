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

<!-- Galaxy Starfield Canvas -->
<canvas id="starfield-canvas" aria-hidden="true"></canvas>


@if(View::hasSection('fullwidth'))
  <!-- Public User Top Bar -->
  <header class="public-navbar">
    <div class="nav-container">
      <a href="{{ route('peserta.index') }}" class="nav-brand">
        <div class="mark">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5V7M15 11V13M15 17V19M5 5H19C20.1 5 21 5.9 21 7V9.5C19.9 9.5 19 10.4 19 11.5C19 12.6 19.9 13.5 21 13.5V17C21 18.1 20.1 19 19 19H5C3.9 19 3 18.1 3 17V13.5C4.1 13.5 5 12.6 5 11.5C5 10.4 4.1 9.5 3 9.5V7C3 5.9 3.9 5 5 5Z"/></svg>
        </div>
        <span class="txt">TEMU <small style="font-weight:400; opacity:0.8; font-size:11px; letter-spacing:0.1em; display:block; margin-top:-4px;">OFFICIAL</small></span>
      </a>

      <!-- Desktop Nav Menu (visible on desktop only) -->
      <nav class="nav-menu desktop-nav-menu">
        <a href="{{ route('peserta.index') }}" class="nav-item {{ request()->routeIs('peserta.index') ? 'active' : '' }}">Home</a>
        <a href="{{ route('peserta.index') }}#events" class="nav-item">Daftar Event</a>
        <a href="{{ route('peserta.index') }}#wilayah" class="nav-item">Berdasarkan Wilayah</a>
        <a href="{{ route('peserta.index') }}#faq" class="nav-item">FAQ</a>
        <a href="{{ route('peserta.search-order') }}" class="nav-item {{ request()->routeIs('peserta.search-order') ? 'active' : '' }}">Cek Tiket Saya</a>
      </nav>

      <!-- Desktop Auth Group -->
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

      <!-- Mobile 3-Line Hamburger Button -->
      <button class="hamburger-btn" id="mobileMenuBtn" aria-label="Menu">
        <svg class="icon-bars" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
        <svg class="icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
  </header>

  <!-- Mobile Menu Overlay (OUTSIDE navbar, at body level for z-index independence) -->
  <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
  <nav class="mobile-menu-drawer" id="mobileNav">
    <a href="{{ route('peserta.index') }}" class="mobile-menu-item {{ request()->routeIs('peserta.index') ? 'active' : '' }}">Home</a>
    <a href="{{ route('peserta.index') }}#events" class="mobile-menu-item">Daftar Event</a>
    <a href="{{ route('peserta.index') }}#wilayah" class="mobile-menu-item">Berdasarkan Wilayah</a>
    <a href="{{ route('peserta.index') }}#faq" class="mobile-menu-item">FAQ</a>
    <a href="{{ route('peserta.search-order') }}" class="mobile-menu-item {{ request()->routeIs('peserta.search-order') ? 'active' : '' }}">Cek Tiket Saya</a>
    <div class="mobile-menu-divider"></div>
    @auth
      @if(Auth::user()->role === 'client')
        <a href="{{ route('client.dashboard') }}" class="mobile-menu-item auth-item">Dashboard Saya</a>
        <a href="{{ route('client.logout') }}" class="mobile-menu-item logout-item">Logout</a>
      @else
        <a href="{{ route('admin.dashboard') }}" class="mobile-menu-item auth-item">Panel Admin</a>
        <a href="{{ route('admin.logout') }}" class="mobile-menu-item logout-item">Logout</a>
      @endif
    @else
      <a href="{{ route('client.login') }}" class="mobile-menu-item auth-item">Login</a>
      <a href="{{ route('client.register') }}" class="mobile-menu-item register-item">Register</a>
    @endauth
  </nav>

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
        
        <!-- Mobile Hamburger Button -->
        <button class="hamburger-btn" id="mobileMenuBtn2" aria-label="Menu" style="display:none;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
        </button>
        
        <nav class="nav-menu" id="mobileNav2">
          <a href="{{ route('peserta.index') }}" class="nav-item {{ request()->routeIs('peserta.index') ? 'active' : '' }}">Beranda</a>
          <a href="{{ route('peserta.index') }}#sessions" class="nav-item">Jadwal Sesi</a>
          <a href="{{ route('peserta.index') }}#bento" class="nav-item">Highlight</a>
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

// Mobile Menu Toggle
(function() {
  const menuBtns = document.querySelectorAll('.hamburger-btn');
  const menus = document.querySelectorAll('.nav-menu');
  
  function toggleMenu(e) {
    e.preventDefault();
    const btn = e.currentTarget;
    const navId = btn.id.replace('Btn', 'Nav').replace('Btn2', 'Nav2');
    const menu = document.getElementById(navId);
    
    if (menu) {
      menu.classList.toggle('mobile-open');
      btn.classList.toggle('active');
    }
  }
  
  menuBtns.forEach(btn => {
    btn.addEventListener('click', toggleMenu);
  });
  
  // Close menu when clicking outside on mobile
  document.addEventListener('click', function(e) {
    if (window.innerWidth <= 768) {
      menuBtns.forEach(btn => {
        const navId = btn.id.replace('Btn', 'Nav').replace('Btn2', 'Nav2');
        const menu = document.getElementById(navId);
        if (menu && !menu.contains(e.target) && !btn.contains(e.target) && menu.classList.contains('mobile-open')) {
          menu.classList.remove('mobile-open');
          btn.classList.remove('active');
        }
      });
    }
  });
  
  // Close menu on resize
  window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
      menus.forEach(menu => menu.classList.remove('mobile-open'));
      menuBtns.forEach(btn => btn.classList.remove('active'));
    }
  });
})();

// ==========================================
// GALAXY STARFIELD ANIMATION
// ==========================================
(function() {
  const canvas = document.getElementById('starfield-canvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');

  let W, H, stars = [], dpr = window.devicePixelRatio || 1;

  // Reduce star count on mobile for performance
  const STAR_COUNT = window.innerWidth < 600 ? 120 : 220;

  function resize() {
    W = window.innerWidth;
    H = window.innerHeight;
    canvas.width  = W * dpr;
    canvas.height = H * dpr;
    canvas.style.width  = W + 'px';
    canvas.style.height = H + 'px';
    ctx.scale(dpr, dpr);
    initStars();
  }

  function randBetween(a, b) { return a + Math.random() * (b - a); }

  function initStars() {
    stars = [];
    for (let i = 0; i < STAR_COUNT; i++) {
      // Cluster more stars near center-upper area (milky way look)
      let x, y;
      if (Math.random() < 0.35) {
        // Milky way band: diagonal strip
        const t = Math.random();
        x = W * (0.2 + t * 0.6) + randBetween(-W*0.15, W*0.15);
        y = H * (0.3 + t * 0.4) + randBetween(-H*0.1, H*0.1);
      } else {
        x = Math.random() * W;
        y = Math.random() * H;
      }
      const size = Math.random() < 0.08 ? randBetween(1.8, 2.6) : randBetween(0.4, 1.4);
      // Twinkling phase offset
      const phase = Math.random() * Math.PI * 2;
      const speed = randBetween(0.4, 1.6); // twinkle speed

      // Star color: mostly white/blue-white, some faint teal
      const colorRoll = Math.random();
      let color;
      if (colorRoll < 0.08) {
        color = { r: 0, g: 220, b: 255 };   // bright teal
      } else if (colorRoll < 0.18) {
        color = { r: 160, g: 220, b: 255 }; // blue-white
      } else if (colorRoll < 0.26) {
        color = { r: 200, g: 230, b: 255 }; // soft blue
      } else {
        color = { r: 255, g: 255, b: 255 }; // pure white
      }

      stars.push({ x, y, size, phase, speed, color, baseOpacity: randBetween(0.4, 0.9) });
    }
  }

  let raf, lastT = 0;

  function draw(t) {
    raf = requestAnimationFrame(draw);
    ctx.clearRect(0, 0, W, H);

    const dt = (t - lastT) / 1000;
    lastT = t;

    for (let i = 0; i < stars.length; i++) {
      const s = stars[i];
      s.phase += dt * s.speed;

      // Sine-based twinkle
      const twinkle = 0.5 + 0.5 * Math.sin(s.phase);
      const alpha = s.baseOpacity * (0.25 + 0.75 * twinkle);

      const { r, g, b } = s.color;

      // Glow for larger stars
      if (s.size > 1.5) {
        const grd = ctx.createRadialGradient(s.x, s.y, 0, s.x, s.y, s.size * 3.5);
        grd.addColorStop(0, `rgba(${r},${g},${b},${alpha})`);
        grd.addColorStop(1, `rgba(${r},${g},${b},0)`);
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.size * 3.5, 0, Math.PI * 2);
        ctx.fillStyle = grd;
        ctx.fill();
      }

      // Star core
      ctx.beginPath();
      ctx.arc(s.x, s.y, s.size, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(${r},${g},${b},${alpha})`;
      ctx.fill();
    }
  }

  window.addEventListener('resize', function() {
    cancelAnimationFrame(raf);
    resize();
    lastT = 0;
    raf = requestAnimationFrame(draw);
  });

  resize();
  raf = requestAnimationFrame(draw);
})();

// Navbar Scroll Effect & Mobile Hamburger Toggle
document.addEventListener('DOMContentLoaded', function() {
  const navbar = document.querySelector('.public-navbar');
  if (navbar) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 40) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  }

  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const mobileNav = document.getElementById('mobileNav');
  const mobileOverlay = document.getElementById('mobileMenuOverlay');
  if (mobileMenuBtn && mobileNav) {
    const barsIcon = mobileMenuBtn.querySelector('.icon-bars');
    const closeIcon = mobileMenuBtn.querySelector('.icon-close');

    function toggleMobileMenu() {
      mobileNav.classList.toggle('mobile-open');
      const isOpened = mobileNav.classList.contains('mobile-open');
      if (barsIcon) barsIcon.style.display = isOpened ? 'none' : 'block';
      if (closeIcon) closeIcon.style.display = isOpened ? 'block' : 'none';
      if (mobileOverlay) {
        if (isOpened) {
          mobileOverlay.classList.add('open');
        } else {
          mobileOverlay.classList.remove('open');
        }
      }
    }

    function closeMobileMenu() {
      mobileNav.classList.remove('mobile-open');
      if (barsIcon) barsIcon.style.display = 'block';
      if (closeIcon) closeIcon.style.display = 'none';
      if (mobileOverlay) mobileOverlay.classList.remove('open');
    }

    mobileMenuBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleMobileMenu();
    });

    // Close menu when clicking overlay
    if (mobileOverlay) {
      mobileOverlay.addEventListener('click', closeMobileMenu);
    }

    // Close menu when clicking any link
    mobileNav.querySelectorAll('a').forEach(function(link) {
      link.addEventListener('click', closeMobileMenu);
    });
  }

  // Scroll Reveal Observer (matching htmllandingpage.txt reference)
  const reveals = document.querySelectorAll('.reveal');
  if (reveals.length > 0 && 'IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: "0px 0px -40px 0px" });

    reveals.forEach(reveal => {
      revealObserver.observe(reveal);
    });
  } else {
    // Fallback for older browsers
    reveals.forEach(r => r.classList.add('active'));
  }
});
</script>
</body>
</html>
