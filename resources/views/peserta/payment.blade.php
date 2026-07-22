@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="stepper">
  <div class="step done"><span class="num">✓</span>Pilih Event</div>
  <div class="step done"><span class="num">✓</span>Detail</div>
  <div class="step done"><span class="num">✓</span>Isi Data</div>
  <div class="step done"><span class="num">✓</span>Konfirmasi</div>
  <div class="step active"><span class="num">5</span>Pembayaran</div>
  <div class="step"><span class="num">6</span>Tiket</div>
</div>
<div class="stage">
  <div class="stage-inner">
    <div class="eyebrow">Langkah 5</div>
    <h2>Pembayaran QRIS</h2>
    <div class="sub">Scan kode QRIS di bawah menggunakan aplikasi e-wallet atau mobile banking Anda.</div>

    <div class="qris-box">
      <div class="qris-fake"></div>
      <div class="amount">{{ $event->rupiah }}</div>
      <div style="color:var(--muted); font-size:12.5px;">Berlaku hingga pembayaran dikonfirmasi payment gateway</div>
    </div>

    <div class="btn-row">
      <a href="{{ route('peserta.review', $event) }}" class="btn btn-ghost">Kembali</a>
      <form method="POST" action="{{ route('peserta.confirm', $event) }}" style="flex:1">
        @csrf
        <button type="submit" class="btn btn-primary">Konfirmasi &amp; Saya Sudah Bayar →</button>
      </form>
    </div>
  </div>
</div>
@endsection
