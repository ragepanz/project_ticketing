@extends('layouts.app')

@section('title', 'Cek Pesanan Tiket Saya')

@section('content')
<div class="stage">
  <div class="stage-inner" style="max-width:520px;">
    <div class="eyebrow">PENCARIAN TIKET INSTAN</div>
    <h2>Cek Pesanan & Tiket Saya</h2>
    <div class="sub">Masukkan Kode Transaksi (contoh: <code>TRX-XXXXX</code>), Alamat Email, atau No. WhatsApp pemesan untuk menemukan E-Tiket Anda.</div>

    @if(session('error'))
      <div style="background:rgba(239, 68, 68, 0.15); border:1px solid #ef4444; color:#fca5a5; padding:12px 16px; border-radius:12px; font-size:13.5px; margin-bottom:20px;">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('peserta.find-order') }}">
      @csrf
      <div class="field">
        <label for="query">Kode TRX / Email / No. WhatsApp</label>
        <input id="query" name="query" placeholder="Contoh: TRX-1A2B3 atau email@domain.com" required autofocus>
      </div>

      <div class="btn-row">
        <a href="{{ route('peserta.index') }}" class="btn btn-ghost">Kembali ke Beranda</a>
        <button type="submit" class="btn btn-primary">Cari Tiket Saya →</button>
      </div>
    </form>
  </div>
</div>
@endsection
