@extends('layouts.app')

@section('title', 'Konfirmasi Data')

@section('content')
<div class="stepper">
  <div class="step done"><span class="num">✓</span>Pilih Event</div>
  <div class="step done"><span class="num">✓</span>Detail</div>
  <div class="step done"><span class="num">✓</span>Isi Data</div>
  <div class="step active"><span class="num">4</span>Konfirmasi</div>
  <div class="step"><span class="num">5</span>Pembayaran</div>
  <div class="step"><span class="num">6</span>Tiket</div>
</div>
<div class="stage">
  <div class="stage-inner">
    <div class="eyebrow">Langkah 4</div>
    <h2>Periksa kembali data Anda</h2>
    <div class="sub">Pastikan data yang telah diisi sudah benar sebelum melanjutkan ke pembayaran.</div>

    <div class="review-row"><div class="k">Event / Sesi</div><div class="v">{{ $event->title }}</div></div>
    @if($event->time_slot)
    <div class="review-row"><div class="k">Waktu / Jam Sesi</div><div class="v" style="color:var(--bento-cyan); font-weight:700;">{{ $event->time_slot }}</div></div>
    @endif
    <div class="review-row"><div class="k">Nama Pemesan</div><div class="v">{{ $data['name'] }}</div></div>
    <div class="review-row"><div class="k">Email</div><div class="v">{{ $data['email'] }}</div></div>
    <div class="review-row"><div class="k">WhatsApp</div><div class="v">{{ $data['phone'] }}</div></div>
    <div class="review-row"><div class="k">Instansi</div><div class="v">{{ $data['instansi'] ?: '—' }}</div></div>
    <div class="review-row"><div class="k">Total Bayar</div><div class="v">{{ $event->rupiah }}</div></div>

    <div class="btn-row">
      <a href="{{ route('peserta.form', $event) }}" class="btn btn-ghost">Ubah Data</a>
      <a href="{{ route('peserta.payment', $event) }}" class="btn btn-primary">Konfirmasi &amp; Bayar</a>
    </div>
  </div>
</div>
@endsection
