@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="stepper">
  <div class="step done"><span class="num">✓</span>Pilih Event</div>
  <div class="step active"><span class="num">2</span>Detail</div>
  <div class="step"><span class="num">3</span>Isi Data</div>
  <div class="step"><span class="num">4</span>Konfirmasi</div>
  <div class="step"><span class="num">5</span>Pembayaran</div>
  <div class="step"><span class="num">6</span>Tiket</div>
</div>
<div class="stage">
  <div class="stage-inner">
    <!-- Event Banner Image -->
    <div style="width: 100%; height: 260px; border-radius: 20px; overflow: hidden; margin-bottom: 24px; border: 1px solid rgba(255, 255, 255, 0.15); box-shadow: 0 12px 30px rgba(0,0,0,0.4);">
      <img src="{{ $event->image_url }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div class="eyebrow">Langkah 2 · Detail Event</div>
    <h2>{{ $event->title }}</h2>
    <div class="sub">{{ $event->desc }}</div>

    @if($event->speaker)
    <div class="review-row"><div class="k">Pemateri Utama</div><div class="v" style="color:var(--bento-emerald); font-weight:700;">🎙️ {{ $event->speaker }}</div></div>
    @endif
    <div class="review-row"><div class="k">Tanggal Acara</div><div class="v">📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</div></div>
    @if($event->time_slot)
    <div class="review-row"><div class="k">Waktu / Jam Sesi</div><div class="v" style="color:var(--bento-cyan); font-weight:700;">⏱️ {{ $event->time_slot }}</div></div>
    @endif
    <div class="review-row"><div class="k">Lokasi</div><div class="v">📍 {{ $event->location }}</div></div>
    <div class="review-row"><div class="k">Kuota Tersedia</div><div class="v">⚡ {{ $event->quota }} peserta</div></div>
    <div class="review-row"><div class="k">Biaya Registrasi</div><div class="v" style="color:var(--bento-emerald); font-size:16px; font-weight:800;">{{ $event->rupiah }}</div></div>

    <div class="btn-row">
      <a href="{{ route('peserta.index') }}" class="btn btn-ghost">Kembali</a>
      <a href="{{ route('peserta.form', $event) }}" class="btn btn-primary">Daftar Sekarang →</a>
    </div>
  </div>
</div>
@endsection
