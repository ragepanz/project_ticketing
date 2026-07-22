@extends('layouts.admin')

@section('title', 'Ubah Password - Tixia')
@section('page_title', 'Pengaturan')

@section('admin-content')
<div style="max-width: 420px; margin: 0 auto;">

  @if(session('success'))
  <div style="background: #ecfdf5; color: #065f46; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 600; border: 1px solid #a7f3d0;">
    {{ session('success') }}
  </div>
  @endif

  <div style="text-align: center; margin-bottom: 32px;">
    <div style="width: 56px; height: 56px; border-radius: 16px; background: #eef2ff; color: #383be5; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
    </div>
    <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Ubah Password</h2>
    <p style="font-size: 14px; color: #64748b; margin: 0;">
      {{ Auth::user()->name }} &middot; {{ Auth::user()->email }}
    </p>
  </div>

  <form method="POST" action="{{ route('admin.password.update') }}">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 20px;">
      <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Password Saat Ini</label>
      <input name="current_password" type="password" placeholder="Masukkan password lama" required
        style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a; transition: border-color 0.2s;" onfocus="this.style.borderColor='#383be5'" onblur="this.style.borderColor='#cbd5e1'">
      @error('current_password')
      <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-bottom: 20px;">
      <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Password Baru</label>
      <input name="new_password" type="password" placeholder="Minimal 6 karakter" required
        style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a; transition: border-color 0.2s;" onfocus="this.style.borderColor='#383be5'" onblur="this.style.borderColor='#cbd5e1'">
      @error('new_password')
      <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-bottom: 28px;">
      <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Konfirmasi Password Baru</label>
      <input name="new_password_confirmation" type="password" placeholder="Ulangi password baru" required
        style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a; transition: border-color 0.2s;" onfocus="this.style.borderColor='#383be5'" onblur="this.style.borderColor='#cbd5e1'">
    </div>

    <button type="submit" style="width: 100%; padding: 12px; border-radius: 10px; border: none; background: #383be5; color: #fff; font-size: 15px; font-weight: 700; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#2f32d5'" onmouseout="this.style.background='#383be5'">
      Simpan Password
    </button>

    <div style="text-align: center; margin-top: 16px;">
      <a href="{{ route('admin.dashboard') }}" style="font-size: 13px; color: #64748b; text-decoration: none;">Kembali ke Dashboard</a>
    </div>
  </form>
</div>
@endsection