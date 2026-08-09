@extends('layouts.app')

@section('title', 'Titik Temu Official — Mental Talk & Hypnotherapy Experience')
@section('body_class', 'dark-mode')

@section('fullwidth')
<!-- 1. HERO SPEAKER BANNER (Transparent Cutout & Touch-Scroll Fix) -->
<section class="temu-hero-wrap">
  <div class="temu-hero-img-box reveal">
    <img src="{{ asset('images/hero-person.png') }}" alt="Rizky Fadillah - Clinical Hypnotherapist" class="temu-hero-img">
  </div>
</section>

<!-- 2. NARRATIVE / EMOTIONAL QUOTE BOX -->
<section class="temu-narrative-section">
  <div class="temu-narrative-box reveal">
    <p class="temu-quote">
      “Kamu lagi capek yaa?” Nahan semuanya sendirian, sampai mungkin bilang “aku gapapa kok” padahal hati kamu lagi berisik. Dan perlahan kamu mulai terbiasa nyimpen semuanya itu sendiri. Sampai akhirnya kamu lupa rasanya benar-benar didengerin itu gimana? Di Titik Temu, kamu nggak harus selalu kuat. Kamu boleh cerita, boleh pelan-pelan kenal diri kamu lagi. Kamu ga usah khawatir yaa kita ada di sini buat dengerin kamu.
    </p>
    <p class="temu-subquote">
      Titik Temu itu ruang aman buat kamu yang udah capek nyimpen semuanya sendiri. Lewat sesi mental talk & hypnotherapy experience, kamu akan ditemenin buat pelan-pelan pulih tanpa harus dipaksa jadi kuat.
    </p>

    <div class="temu-hero-btns">
      <a href="#events" class="btn-temu-dark">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        <span>AKU MAU IKUT & PULIH</span>
      </a>
      <a href="#events" class="btn-temu-teal">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span>LIHAT JADWAL EVENT</span>
      </a>
    </div>
  </div>
</section>

<!-- 3. DAFTAR EVENT HORIZONTAL CAROUSEL -->
<section class="temu-events-section" id="events">
  <div class="temu-section-head reveal">
    <h2>Daftar Event</h2>
  </div>

  <div class="temu-carousel-wrap reveal">
    <button class="temu-carousel-nav-btn prev" onclick="scrollEvents(-1)" aria-label="Sebelumnya">‹</button>
    <button class="temu-carousel-nav-btn next" onclick="scrollEvents(1)" aria-label="Berikutnya">›</button>

    <div class="temu-events-track" id="eventsTrack">
      @forelse($events as $event)
        @php 
          $full = $event->participants_count >= $event->quota; 
          $isPublished = $event->status === \App\Models\Event::STATUS_PUBLISHED;
        @endphp
        <div class="temu-event-card" data-location="{{ strtolower($event->location) }}">
          <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="temu-event-poster">
          <div class="temu-event-body">
            <div class="temu-venue-badge">{{ $event->location ?? 'HOTEL & CONVENTION CENTER' }}</div>
            <div class="temu-event-title">{{ $event->title }} | {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}</div>
            
            @if(!$isPublished)
              <div class="session-card-action" style="background:rgba(100,116,139,0.2); border-color:rgba(100,116,139,0.3); color:#94a3b8; width:100%; border-radius:12px; padding:12px; font-weight:700;">
                @if($event->status === \App\Models\Event::STATUS_DRAFT) Belum Dibuka
                @elseif($event->status === \App\Models\Event::STATUS_CLOSED) Registrasi Ditutup
                @else Event Selesai
                @endif
              </div>
            @elseif($full)
              <div class="session-card-action" style="background:rgba(239,68,68,0.2); border-color:rgba(239,68,68,0.3); color:#ef4444; width:100%; border-radius:12px; padding:12px; font-weight:700;">
                Kuota Penuh
              </div>
            @else
              <a href="{{ Auth::check() && Auth::user()->role === 'client' ? route('peserta.detail', $event) : route('client.login', ['redirect' => route('peserta.detail', $event)]) }}" class="btn-temu-teal" style="width:100%; justify-content:center;">
                ☝ AMANKAN TIKET SEKARANG
              </a>
            @endif
          </div>
        </div>
      @empty
        <div class="empty" style="color:#fff; text-align:center; padding:40px; width:100%;">Belum ada sesi event yang tersedia.</div>
      @endforelse
    </div>
  </div>
</section>

<!-- 4. VISION & STORY SECTION -->
<section class="temu-story-section">
  <div class="temu-story-box reveal">
    <p class="temu-story-text">
      Titik Temu lahir dari satu kenyataan pahit yaitu terlalu banyak orang di luar sana yang mentalnya hampir runtuh, tapi nggak punya tempat buat bersandar. Dan tanpa kita sadari, ribuan orang dari berbagai kota udah datang ke sini bukan karena hidupnya ringan, tapi karena mereka butuh tempat yang nggak menghakimi rasa lelahnya.
    </p>
    <p class="temu-story-text">
      Visi kita sederhana tapi berat: jadi jembatan buat jiwa-jiwa yang retak, yang setiap hari berusaha nggak hancur di depan orang lain, yang hatinya penuh luka tapi tetap pura-pura baik-baik aja.
    </p>
    <p class="temu-story-text">
      Di Titik Temu, kamu boleh rapuh. Kamu boleh jatuh. Kamu boleh jujur sama diri sendiri. Karena di sini, proses pulih itu nggak dipaksa cepat yang penting kamu nggak melangkah sendirian lagi.
    </p>
  </div>
</section>

<!-- 5. PHOTO GALLERY AUTO-SLIDER -->
<section class="temu-gallery-section">
  <div class="temu-gallery-slider reveal" id="gallerySlider">
    <div class="temu-gallery-slides">
      <div class="temu-gallery-slide active">
        <img src="{{ asset('images/gallery1.png') }}" alt="Titik Temu Event Atmosphere 1">
      </div>
      <div class="temu-gallery-slide">
        <img src="{{ asset('images/gallery1.png') }}" alt="Titik Temu Event Atmosphere 2" style="filter: hue-rotate(15deg);">
      </div>
      <div class="temu-gallery-slide">
        <img src="{{ asset('images/gallery1.png') }}" alt="Titik Temu Event Atmosphere 3" style="filter: brightness(1.1);">
      </div>
    </div>
    
    <!-- Dots -->
    <div class="temu-gallery-dots" id="galleryDots">
      <div class="temu-gallery-dot active" onclick="setGallerySlide(0)"></div>
      <div class="temu-gallery-dot" onclick="setGallerySlide(1)"></div>
      <div class="temu-gallery-dot" onclick="setGallerySlide(2)"></div>
    </div>
  </div>
</section>

<!-- 6. TESTIMONIALS SECTION ("YANG DI RASAKAN" PER PERSON) -->
<section class="temu-testimonials-section">
  <div class="temu-section-head reveal">
    <h2>“Yang Di Rasakan”</h2>
    <div style="color: #facc15; font-size: 14px; font-weight: 700; margin-top: 12px; letter-spacing: 0.05em;">
      ★★★★★ <span style="color: #ffffff; margin-left: 6px;">Dari Ratusan Peserta</span>
    </div>
  </div>

  <div class="temu-testimonials-grid">
    @forelse($testimonials as $t)
    <div class="temu-testimonial-card reveal">
      <div class="temu-testimonial-user-head">
        <div class="temu-user-avatar">{{ strtoupper(substr($t->name, 0, 1)) }}</div>
        <div class="temu-user-details">
          <h4>{{ $t->name }}</h4>
          <span>{{ $t->city_or_event ?? 'Peserta Event' }}</span>
        </div>
      </div>
      <div style="color:#f59e0b; font-size:14px; margin-bottom:12px;">
        {{ str_repeat('★', $t->rating) }}
      </div>
      <p class="temu-testimonial-quote">
        “{{ $t->comment }}”
      </p>
    </div>
    @empty
    <div style="color:#cbd5e1; text-align:center; grid-column:span 3; padding:20px;">Belum ada ulasan yang ditampilkan.</div>
    @endforelse
  </div>

  <div style="text-align: center; margin-bottom: 60px;" class="reveal">
    <a href="#events" class="btn-temu-dark">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
      </svg>
      <span>LIHAT SELURUH EVENT</span>
    </a>
  </div>
</section>

<!-- 7. BERDASARKAN WILAYAH (DYNAMIC CITIES FROM DB) -->
<section class="temu-city-section" id="wilayah">
  <div class="temu-section-head reveal">
    <h2>Berdasarkan Wilayah</h2>
  </div>

  <div class="temu-city-grid reveal">
    @forelse($cities as $city)
    <div class="temu-city-tile" onclick="filterCity('{{ strtolower($city->slug) }}')">
      {{ $city->name }}
    </div>
    @empty
    <div style="color:#cbd5e1; text-align:center; grid-column:span 5;">Belum ada wilayah kota.</div>
    @endforelse
  </div>
</section>

<!-- 8. FAQ ACCORDION -->
<section class="temu-faq-section" id="faq">
  <div class="temu-section-head reveal">
    <h2>FAQ</h2>
  </div>

  <div class="temu-faq-box reveal">
    <div class="temu-faq-item">
      <div class="temu-faq-question" onclick="toggleFaq(this)">
        <span>— Kalau aku belum pernah ikut terapi, boleh ikut ?</span>
        <div class="temu-faq-icon">+</div>
      </div>
      <div class="temu-faq-answer">
        Boleh banget. Titik Temu justru dirancang untuk kamu yang baru mulai. Kamu nggak perlu punya pengalaman apa-apa, cukup datang dan hadir sebagai diri kamu sendiri.
      </div>
    </div>

    <div class="temu-faq-item">
      <div class="temu-faq-question" onclick="toggleFaq(this)">
        <span>+ Apakah aku harus cerita di depan banyak orang ?</span>
        <div class="temu-faq-icon">+</div>
      </div>
      <div class="temu-faq-answer">
        Nggak perlu. Sesi hipnoterapi dan refleksi diri dilakukan secara privat dari tempat duduk masing-masing. Kamu tidak akan dipaksa berbicara atau maju ke depan.
      </div>
    </div>

    <div class="temu-faq-item">
      <div class="temu-faq-question" onclick="toggleFaq(this)">
        <span>+ Apakah ini aman secara emosional?</span>
        <div class="temu-faq-icon">+</div>
      </div>
      <div class="temu-faq-answer">
        Sangat aman. Seluruh sesi dipandu langsung oleh Clinical Hypnotherapist sertifikasi profesional dengan suasana kondusif, tenang, dan tanpa penghakiman.
      </div>
    </div>

    <div class="temu-faq-item">
      <div class="temu-faq-question" onclick="toggleFaq(this)">
        <span>+ Apa itu Hypnotherapy? Apakah aku akan “dikontrol” ?</span>
        <div class="temu-faq-icon">+</div>
      </div>
      <div class="temu-faq-answer">
        Tidak sama sekali. Hypnotherapy adalah relaksasi pikiran bawah sadar yang dibimbing. Kamu tetap 100% sadar, mendengar suara sekitar, dan memegang kendali penuh atas diri kamu.
      </div>
    </div>

    <div class="temu-faq-item">
      <div class="temu-faq-question" onclick="toggleFaq(this)">
        <span>+ Aku takut ke-trigger, gimana ?</span>
        <div class="temu-faq-icon">+</div>
      </div>
      <div class="temu-faq-answer">
        Tim fasilitator dan panitia siap mendampingi kamu sepanjang sesi jika kamu membutuhkan ruang tenang atau pendampingan saat emosi meluap.
      </div>
    </div>
  </div>
</section>

<!-- 9. FOOTER -->
<footer class="bento-footer">
  <div class="footer-inner">
    <div class="footer-brand">
      <div class="name">TEMU OFFICIAL</div>
      <div class="sub">Ruang Aman Pulih lewat Mental Talk & Hypnotherapy Experience</div>
    </div>

    <div class="footer-contact-group" style="display:flex; flex-direction:column; align-items:center; gap:10px;">
      <div class="footer-contact-title" style="font-size:14px; font-weight:700; color:#fff; letter-spacing:0.05em; text-transform:uppercase;">Hubungi Kami</div>

      <div class="footer-contact" style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
        <a href="mailto:info@titiktemuofficial.id" style="display:flex; align-items:center; gap:8px; color:var(--bento-muted); text-decoration:none; font-size:13px;">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          info@titiktemuofficial.id
        </a>
        <a href="https://wa.me/6288976780924" target="_blank" style="display:flex; align-items:center; gap:8px; color:var(--bento-muted); text-decoration:none; font-size:13px;">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
          +62 889-7678-0924
        </a>
      </div>
    </div>

    <div style="font-size:13px; color:var(--bento-muted); margin-top:16px;">
      © {{ date('Y') }} Titik Temu Official. All rights reserved.
    </div>
  </div>
</footer>

<!-- 10. FLOATING BACK TO TOP BUTTON -->
<button class="back-to-top-btn" id="backToTopBtn" onclick="scrollToTop()" aria-label="Back to top">
  <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
  </svg>
</button>

@endsection

@push('scripts')
<script>
// Event Horizontal Carousel Scroll
function scrollEvents(direction) {
  const track = document.getElementById('eventsTrack');
  if (!track) return;
  const scrollAmount = 360 * direction;
  track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
}

// Auto Gallery Slider logic (Auto-slide every 4 seconds)
let galleryIndex = 0;
let galleryTimer = null;

function setGallerySlide(idx) {
  const slides = document.querySelectorAll('.temu-gallery-slide');
  const dots = document.querySelectorAll('.temu-gallery-dot');
  if (!slides.length) return;

  slides.forEach(s => s.classList.remove('active'));
  dots.forEach(d => d.classList.remove('active'));

  galleryIndex = idx % slides.length;
  slides[galleryIndex].classList.add('active');
  if (dots[galleryIndex]) dots[galleryIndex].classList.add('active');
}

function autoNextGallery() {
  const slides = document.querySelectorAll('.temu-gallery-slide');
  if (slides.length) {
    setGallerySlide((galleryIndex + 1) % slides.length);
  }
}

galleryTimer = setInterval(autoNextGallery, 4000);

// FAQ Accordion Toggle
function toggleFaq(el) {
  const item = el.closest('.temu-faq-item');
  const isOpen = item.classList.contains('active');
  
  document.querySelectorAll('.temu-faq-item').forEach(i => i.classList.remove('active'));
  
  if (!isOpen) {
    item.classList.add('active');
  }
}

// City Tile Filter logic
function filterCity(cityName) {
  const tiles = document.querySelectorAll('.temu-city-tile');
  tiles.forEach(t => t.classList.remove('active'));
  
  if (window.event && window.event.target) {
    window.event.target.classList.add('active');
  }

  const cards = document.querySelectorAll('.temu-event-card');
  let found = false;

  cards.forEach(card => {
    const loc = card.getAttribute('data-location') || '';
    if (loc.includes(cityName)) {
      card.style.display = 'flex';
      found = true;
    } else {
      card.style.display = 'none';
    }
  });

  if (!found) {
    cards.forEach(c => c.style.display = 'flex');
  }

  document.getElementById('events').scrollIntoView({ behavior: 'smooth' });
}

// Back to top floating button logic
window.addEventListener('scroll', function() {
  const btn = document.getElementById('backToTopBtn');
  if (!btn) return;
  if (window.scrollY > 400) {
    btn.classList.add('visible');
  } else {
    btn.classList.remove('visible');
  }
});

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endpush
