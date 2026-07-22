@extends('layouts.app')

@section('title', 'E-Tiket Event — ' . $participant->name)

@push('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<style>
@media print {
  body {
    background: #ffffff !important;
    color: #000000 !important;
  }
  .prototype-switch-bar, .topbar, .stepper, .btn-row, .eyebrow, .sub, h2, .no-print {
    display: none !important;
  }
  .app-shell {
    padding: 0 !important;
    max-width: 100% !important;
  }
  .panel {
    background: none !important;
    border: none !important;
    box-shadow: none !important;
  }
  .stage {
    padding: 0 !important;
  }
  .stage-inner {
    max-width: 100% !important;
  }
  .ticket {
    border: 2px solid #000 !important;
    color: #000 !important;
    background: #ffffff !important;
    box-shadow: none !important;
  }
  .ticket-top .ev, .ticket-mid .name {
    color: #000000 !important;
  }
}
</style>
@endpush

@section('content')
<div class="stepper no-print">
  <div class="step done"><span class="num">✓</span>Pilih Event</div>
  <div class="step done"><span class="num">✓</span>Detail</div>
  <div class="step done"><span class="num">✓</span>Isi Data</div>
  <div class="step done"><span class="num">✓</span>Konfirmasi</div>
  <div class="step done"><span class="num">✓</span>Pembayaran</div>
  <div class="step active"><span class="num">6</span>Tiket</div>
</div>

<div class="stage">
  <div class="stage-inner">
    <div class="eyebrow no-print">BERHASIL DITERBITKAN</div>
    <h2 class="no-print">E-Tiket Resmi Anda</h2>
    <div class="sub no-print">Konfirmasi pendaftaran &amp; tiket QR Anda telah aktif. Silakan simpan atau cetak tiket ini untuk akses masuk event.</div>

    <div class="ticket">
      <div class="ticket-top">
        <div class="ev">{{ $event->title }}</div>
        <div class="dt">📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} @if($event->time_slot) · ⏱️ {{ $event->time_slot }} @endif · 📍 {{ $event->location }}</div>
        @if($event->speaker)<div style="font-size:13px; color:rgba(255,255,255,0.8); margin-top:6px;">🎙️ Pemateri: {{ $event->speaker }}</div>@endif
      </div>
      
      <div class="stub-divider"></div>
      
      <div class="ticket-mid" style="display: flex; align-items: center; gap: 24px; flex-wrap: wrap;">
        <div class="qr-holder" id="ticket-qr" style="background:#ffffff; padding:10px; border-radius:12px; display:inline-block;"></div>
        <div class="info" style="flex:1;">
          <div style="font-size:12px; text-transform:uppercase; letter-spacing:0.1em; color:var(--bento-emerald); font-weight:700; margin-bottom:4px;">NAMA PESERTA</div>
          <div class="name" style="font-size:20px; font-weight:800; color:#ffffff; margin-bottom:8px;">{{ $participant->name }}</div>
          <div class="code mono" style="font-size:14px; color:rgba(255,255,255,0.85); display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <span>ID: <strong>{{ $participant->trx_id }}</strong></span>
            <span class="badge badge-lunas" style="background:rgba(16,185,129,0.2); color:#10b981; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:700; border:1px solid rgba(16,185,129,0.4);">✓ LUNAS</span>
          </div>
          @if($participant->instansi)
          <div style="font-size:12.5px; color:var(--bento-muted); margin-top:6px;">Instansi/Organisasi: {{ $participant->instansi }}</div>
          @endif
        </div>
      </div>

      <div class="ticket-bottom" style="margin-top:20px; padding-top:16px; border-top:1px dashed rgba(255,255,255,0.15); display:flex; gap:10px; flex-wrap:wrap; font-size:12px;">
        <div class="chip" style="background:rgba(255,255,255,0.06); padding:6px 12px; border-radius:8px; color:rgba(255,255,255,0.8);">🔒 E-Tiket Resmi EventFlow</div>
        <div class="chip" style="background:rgba(255,255,255,0.06); padding:6px 12px; border-radius:8px; color:rgba(255,255,255,0.8);">📷 Pindai QR Saat Check-in</div>
      </div>
    </div>

    <!-- Client Notice Box -->
    <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 16px; padding: 16px; margin-bottom: 24px; font-size: 13px; color: rgba(255,255,255,0.9); line-height: 1.5;" class="no-print">
      📌 <strong>Petunjuk Masuk Event:</strong> Tunjukkan QR Code di atas kepada panitia di pintu masuk event untuk dilakukan verifikasi presensi instan.
    </div>

    <div class="btn-row no-print" style="display: flex; gap: 12px; flex-wrap: wrap;">
      <a href="{{ route('peserta.index') }}" class="btn btn-ghost" style="flex: 1; text-align: center;">← Ke Beranda</a>
      <button type="button" class="btn btn-ghost" onclick="window.print()" style="flex: 1; text-align: center;">🖨️ Cetak / Simpan PDF</button>
      <a href="https://chat.whatsapp.com/demo-group" target="_blank" class="btn btn-primary" style="flex: 1.2; text-align: center;">💬 Gabung Grup WhatsApp</a>
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
      width: 100,
      height: 100,
      colorDark: '#0f172a',
      colorLight: '#ffffff'
    });
  }
});
</script>
@endpush
