@extends('layouts.app')

@section('title', 'Tiket Anda')

@push('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush

@section('content')
<div class="stepper">
  <div class="step done"><span class="num">✓</span>Pilih Event</div>
  <div class="step done"><span class="num">✓</span>Detail</div>
  <div class="step done"><span class="num">✓</span>Isi Data</div>
  <div class="step done"><span class="num">✓</span>Konfirmasi</div>
  <div class="step done"><span class="num">✓</span>Pembayaran</div>
  <div class="step active"><span class="num">6</span>Tiket</div>
</div>
<div class="stage">
  <div class="stage-inner">
    <div class="eyebrow">Langkah 6</div>
    <h2>Email konfirmasi terkirim</h2>
    <div class="sub">Sistem mengirim email otomatis berisi tiket QR, detail pembayaran, dan link grup WhatsApp.</div>

    <div class="ticket">
      <div class="ticket-top">
        <div class="ev">{{ $event->title }}</div>
        <div class="dt">📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} @if($event->time_slot) · ⏱️ {{ $event->time_slot }} @endif · 📍 {{ $event->location }}</div>
        @if($event->speaker)<div style="font-size:12.5px; color:rgba(255,255,255,0.7); margin-top:4px;">🎙️ {{ $event->speaker }}</div>@endif
      </div>
      <div class="stub-divider"></div>
      <div class="ticket-mid">
        <div class="qr-holder" id="ticket-qr"></div>
        <div class="info">
          <div class="name">{{ $participant->name }}</div>
          <div class="code mono">{{ $participant->trx_id }} · <span class="badge badge-lunas">LUNAS</span></div>
        </div>
      </div>
      <div class="ticket-bottom">
        <div class="chip">📄 Konfirmasi Pembayaran</div>
        <div class="chip">🔳 QR Code Check-in</div>
        <div class="chip">💬 Link Grup WhatsApp</div>
      </div>
    </div>

    <div class="btn-row">
      <a href="{{ route('peserta.index') }}" class="btn btn-ghost">Kembali ke Daftar Event</a>
      <a href="{{ route('admin.scan') }}?code={{ $participant->trx_id }}" class="btn btn-primary">Lihat Proses Check-in di Admin →</a>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  var holder = document.getElementById('ticket-qr');
  if (holder && typeof QRCode !== 'undefined') {
    new QRCode(holder, {
      text: '{{ $participant->trx_id }}',
      width: 96,
      height: 96,
      colorDark: '#142033',
      colorLight: '#ffffff'
    });
  }
});
</script>
@endpush
