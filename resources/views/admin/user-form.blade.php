@extends('layouts.admin')

@section('title', isset($user) ? 'Edit Admin - Tixia' : 'Tambah Admin - Tixia')
@section('page_title', isset($user) ? 'Edit Admin' : 'Tambah Admin')

@section('admin-content')
<div style="max-width: 640px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap;">
    <div>
      <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">{{ isset($user) ? 'Edit Admin' : 'Tambah Admin Baru' }}</h2>
      <div style="font-size: 13px; color: #64748b; margin-top: 4px;">
        {{ isset($user) ? 'Perbarui informasi akun admin.' : 'Buat akun admin baru untuk mengelola dashboard.' }}
      </div>
    </div>
    <a href="{{ route('admin.users') }}" class="tixia-icon-btn" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7l-7 7 7 7"/></svg>
    </a>
  </div>

  <div class="tixia-card" style="padding: 24px;">
    <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}">
      @csrf
      @if(isset($user)) @method('PUT') @endif

      <div style="margin-bottom: 20px;">
        <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Nama Lengkap</label>
        <input name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="Nama admin" required
          style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
        @error('name')
        <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
        @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Email</label>
        <input name="email" type="email" value="{{ old('email', $user->email ?? '') }}" placeholder="admin@example.com" required
          style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
        @error('email')
        <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
        @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">
          Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}
        </label>
        <input name="password" type="password" placeholder="{{ isset($user) ? 'Biarkan kosong jika tidak diubah' : 'Minimal 6 karakter' }}" {{ isset($user) ? '' : 'required' }}
          style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
        @error('password')
        <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
        @enderror
      </div>

      <div style="margin-bottom: 4px;">
        <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Role</label>
        <div style="padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; color: #64748b; font-size: 14px;">
          Admin
        </div>
      </div>

      <div style="margin-top: 28px; display: flex; gap: 12px; justify-content: flex-end;">
        <a href="{{ route('admin.users') }}" class="btn" style="padding: 10px 20px; border-radius: 10px; border: 1px solid #cbd5e1; background: #fff; color: #475569; font-weight: 600; text-decoration: none; display: inline-block;">Batal</a>
        <button type="submit" class="btn" style="padding: 10px 24px; border-radius: 10px; border: none; background: #383be5; color: #fff; font-weight: 700; cursor: pointer;">
          {{ isset($user) ? 'Perbarui Admin' : 'Simpan Admin' }}
        </button>
      </div>
    </form>
  </div>
</div>
@endsection