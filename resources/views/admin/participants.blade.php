@extends('layouts.admin')

@section('title', 'Data Peserta - Tixia')
@section('page_title', 'Customer & Order List')

@section('admin-content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap;">
  <div>
    <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">Data Peserta & Order</h2>
    <div style="font-size: 13px; color: #64748b; margin-top: 4px;">Lihat, cari, dan ekspor data peserta terdaftar.</div>
  </div>
  <a href="{{ route('admin.export-csv') }}" class="tixia-report-btn" style="padding: 10px 20px; font-size: 13px;">
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    <span>Export CSV</span>
  </a>
</div>

<div class="tixia-card">
  <div class="tixia-table-wrap">
    <table class="tixia-table">
      <thead>
        <tr>
          <th>Nama Peserta</th>
          <th>Event</th>
          <th>Kode Tiket</th>
          <th>Status Bayar</th>
          <th>Presensi Check-in</th>
        </tr>
      </thead>
      <tbody>
        @forelse($participants as $p)
        <tr>
          <td>
            <div style="font-weight: 700; color: #1e293b;">{{ $p->name }}</div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $p->email }}</div>
          </td>
          <td style="font-weight: 600; color: #334155;">{{ $p->event->title ?? '—' }}</td>
          <td style="font-weight: 700; color: #475569; font-family: 'IBM Plex Mono', monospace;">#{{ $p->trx_id }}</td>
          <td>
            @if($p->status === 'lunas')
              <span style="display: inline-block; padding: 4px 10px; background: #dcfce7; color: #15803d; border-radius: 999px; font-size: 11px; font-weight: 700;">LUNAS</span>
            @else
              <span style="display: inline-block; padding: 4px 10px; background: #fef3c7; color: #b45309; border-radius: 999px; font-size: 11px; font-weight: 700;">PENDING</span>
            @endif
          </td>
          <td>
            @if($p->checked_in)
              <span style="display: inline-block; padding: 4px 10px; background: #e0e7ff; color: #4338ca; border-radius: 999px; font-size: 11px; font-weight: 700;">HADIR</span>
            @else
              <span style="display: inline-block; padding: 4px 10px; background: #f1f5f9; color: #64748b; border-radius: 999px; font-size: 11px; font-weight: 700;">BELUM</span>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align: center; padding: 48px; color: #94a3b8;">Tidak ada peserta ditemukan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($participants->hasPages())
  <div style="display: flex; justify-content: flex-end; padding: 16px 0 0; gap: 6px;">
    {{ $participants->links() }}
  </div>
  @endif
</div>
@endsection
