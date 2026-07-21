@extends('layouts.app')

@section('title', 'Isi Data Diri')

@section('content')
<div class="stepper">
  <div class="step done"><span class="num">✓</span>Pilih Event</div>
  <div class="step done"><span class="num">✓</span>Detail</div>
  <div class="step active"><span class="num">3</span>Isi Data</div>
  <div class="step"><span class="num">4</span>Konfirmasi</div>
  <div class="step"><span class="num">5</span>Pembayaran</div>
  <div class="step"><span class="num">6</span>Tiket</div>
</div>
<div class="stage">
  <div class="stage-inner">
    <div class="eyebrow">Langkah 3</div>
    <h2>Login / Daftar &amp; isi data diri</h2>
    <div class="sub">Peserta login jika sudah punya akun, atau mengisi data diri sesuai form yang tersedia.</div>

    <form method="POST" action="{{ route('peserta.store-form', $event) }}">
      @csrf
      <div class="field">
        <label for="name">Nama Lengkap</label>
        <input id="name" name="name" value="{{ old('name') }}" placeholder="Nama sesuai KTP" required>
        @error('name')<div style="color:var(--coral); font-size:12px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>
      <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
        @error('email')<div style="color:var(--coral); font-size:12px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>
      <div class="field">
        <label for="phone">No. WhatsApp</label>
        <input id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
        @error('phone')<div style="color:var(--coral); font-size:12px; margin-top:4px;">{{ $message }}</div>@enderror
      </div>
      <div class="field">
        <label for="instansi">Instansi / Organisasi</label>
        <input id="instansi" name="instansi" value="{{ old('instansi') }}" placeholder="Opsional">
      </div>

      <div class="btn-row">
        <a href="{{ route('peserta.detail', $event) }}" class="btn btn-ghost">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan &amp; Lanjutkan</button>
      </div>
    </form>
  </div>
</div>
@endsection
