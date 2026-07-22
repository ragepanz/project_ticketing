@extends('layouts.admin')

@section('title', 'Kelola Admin - Tixia')
@section('page_title', 'Admin Management')

@section('admin-content')
@if(session('success'))
<div style="background: #ecfdf5; color: #065f46; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 600; border: 1px solid #a7f3d0;">
  {{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="background: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 600; border: 1px solid #fecaca;">
  {{ $errors->first() }}
</div>
@endif

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap;">
  <div>
    <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">Daftar Admin</h2>
    <div style="font-size: 13px; color: #64748b; margin-top: 4px;">Kelola akun admin yang dapat mengakses dashboard.</div>
  </div>
  @if(Auth::user()->role === 'superadmin')
  <a href="{{ route('admin.users.create') }}" class="tixia-report-btn" style="background: linear-gradient(135deg, #383be5 0%, #2528c7 100%); color: #fff; box-shadow: 0 4px 14px rgba(56, 59, 229, 0.25); text-decoration: none;">
    <span>+ Tambah Admin</span>
  </a>
  @endif
</div>

<div class="tixia-card">
  <div class="tixia-table-wrap">
    <table class="tixia-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Bergabung</th>
          <th style="text-align: right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td style="font-weight: 700; color: #1e293b;">
            <div style="display: flex; align-items: center; gap: 12px;">
              <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #383be5, #6366f1); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
              <div>
                <div style="display: flex; align-items: center; gap: 6px;">
                  <span>{{ $user->name }}</span>
                  @if($user->role === 'superadmin')
                  <span style="font-size: 10px; padding: 1px 8px; border-radius: 10px; background: #fef3c7; color: #92400e; font-weight: 700; letter-spacing: 0.3px;">SUPERADMIN</span>
                  @endif
                </div>
                @if($user->id === Auth::id())
                <div style="font-size: 11px; color: #383be5; font-weight: 600;">Anda</div>
                @endif
              </div>
            </div>
          </td>
          <td style="color: #64748b;">{{ $user->email }}</td>
          <td>
            @if($user->role === 'superadmin')
            <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; background: #fef3c7; color: #92400e;">
              <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
              Superadmin
            </span>
            @else
            <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; background: #eef2ff; color: #383be5;">
              <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
              Admin
            </span>
            @endif
          </td>
          <td style="color: #64748b; font-size: 13px;">{{ $user->created_at->format('d M Y') }}</td>
          <td style="text-align: right;">
  @if(Auth::user()->role === 'superadmin' && $user->role !== 'superadmin')
            <div style="display: flex; gap: 8px; justify-content: flex-end;">
              <a href="{{ route('admin.users.edit', $user) }}" class="tixia-icon-btn" title="Edit Admin" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
              </a>
              @if($user->id !== Auth::id())
              <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline" onsubmit="return confirm('Hapus admin {{ $user->name }}?')">
                @csrf @method('DELETE')
                <button class="tixia-icon-btn" title="Hapus Admin" style="width: 34px; height: 34px; color: #ef4444; display: inline-flex; align-items: center; justify-content: center;">
                  <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
              </form>
              @endif
            </div>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="text-align: center; padding: 48px; color: #94a3b8;">
            Belum ada admin.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div style="margin-top: 16px;">
  {{ $users->links() }}
</div>
@endsection