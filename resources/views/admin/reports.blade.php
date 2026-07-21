@extends('layouts.admin')

@section('title', 'Laporan & Streaming - Tixia')
@section('page_title', 'Analytics & Reports')

@section('admin-content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap;">
  <div>
    <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">Laporan & Analytics</h2>
    <div style="font-size: 13px; color: #64748b; margin-top: 4px;">Ringkasan statistik peserta, presensi check-in, dan status pembayaran.</div>
  </div>
  <a href="{{ route('admin.export-csv') }}" class="tixia-report-btn" style="padding: 10px 20px; font-size: 13px;">
    <span>⬇ Export CSV</span>
  </a>
</div>

<!-- Stat Grid Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 28px;">
  <div class="tixia-card" style="padding: 22px;">
    <div style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Total Peserta</div>
    <div style="font-size: 28px; font-weight: 800; color: #0f172a; margin-top: 6px; font-family: 'Space Grotesk', sans-serif;">{{ $totalPeserta }}</div>
  </div>
  <div class="tixia-card" style="padding: 22px;">
    <div style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Sudah Check-in</div>
    <div style="font-size: 28px; font-weight: 800; color: #16a34a; margin-top: 6px; font-family: 'Space Grotesk', sans-serif;">{{ $totalHadir }}</div>
  </div>
  <div class="tixia-card" style="padding: 22px;">
    <div style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Belum Check-in</div>
    <div style="font-size: 28px; font-weight: 800; color: #383be5; margin-top: 6px; font-family: 'Space Grotesk', sans-serif;">{{ $totalBelum }}</div>
  </div>
  <div class="tixia-card" style="padding: 22px;">
    <div style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Pembayaran Lunas</div>
    <div style="font-size: 28px; font-weight: 800; color: #4338ca; margin-top: 6px; font-family: 'Space Grotesk', sans-serif;">{{ $lunas }}/{{ $totalPeserta }}</div>
  </div>
</div>

<!-- Charts Row -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
  <div class="tixia-card" style="padding: 24px;">
    <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 20px;">Peserta Per Event</h4>
    @php $maxTotal = max(1, $events->sum(fn($e) => $e->participants->count())); @endphp
    @foreach($events as $event)
      @php $count = $event->participants->count(); @endphp
      <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px; font-size: 13px;">
        <div style="width: 140px; color: #475569; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $event->title }}</div>
        <div style="flex: 1; height: 10px; background: #f1f5f9; border-radius: 999px; overflow: hidden;">
          <div style="height: 100%; width: {{ $maxTotal > 0 ? ($count / $maxTotal * 100) : 0 }}%; background: linear-gradient(90deg, #383be5, #6366f1); border-radius: 999px;"></div>
        </div>
        <div style="width: 40px; text-align: right; font-weight: 700; color: #0f172a;">{{ $count }}</div>
      </div>
    @endforeach
  </div>

  <div class="tixia-card" style="padding: 24px;">
    <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 20px;">Status Pembayaran & Check-in</h4>
    @php $denom = max(1, $totalPeserta); @endphp
    
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px; font-size: 13px;">
      <div style="width: 140px; color: #475569; font-weight: 600;">Lunas</div>
      <div style="flex: 1; height: 10px; background: #f1f5f9; border-radius: 999px; overflow: hidden;">
        <div style="height: 100%; width: {{ ($lunas / $denom * 100) }}%; background: linear-gradient(90deg, #22c55e, #16a34a); border-radius: 999px;"></div>
      </div>
      <div style="width: 40px; text-align: right; font-weight: 700; color: #0f172a;">{{ $lunas }}</div>
    </div>

    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; font-size: 13px;">
      <div style="width: 140px; color: #475569; font-weight: 600;">Pending</div>
      <div style="flex: 1; height: 10px; background: #f1f5f9; border-radius: 999px; overflow: hidden;">
        <div style="height: 100%; width: {{ ($pending / $denom * 100) }}%; background: linear-gradient(90deg, #f59e0b, #d97706); border-radius: 999px;"></div>
      </div>
      <div style="width: 40px; text-align: right; font-weight: 700; color: #0f172a;">{{ $pending }}</div>
    </div>

    <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Status Presensi</h4>
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px; font-size: 13px;">
      <div style="width: 140px; color: #475569; font-weight: 600;">Hadir</div>
      <div style="flex: 1; height: 10px; background: #f1f5f9; border-radius: 999px; overflow: hidden;">
        <div style="height: 100%; width: {{ ($totalHadir / $denom * 100) }}%; background: linear-gradient(90deg, #383be5, #4f46e5); border-radius: 999px;"></div>
      </div>
      <div style="width: 40px; text-align: right; font-weight: 700; color: #0f172a;">{{ $totalHadir }}</div>
    </div>

    <div style="display: flex; align-items: center; gap: 12px; font-size: 13px;">
      <div style="width: 140px; color: #475569; font-weight: 600;">Belum Hadir</div>
      <div style="flex: 1; height: 10px; background: #f1f5f9; border-radius: 999px; overflow: hidden;">
        <div style="height: 100%; width: {{ ($totalBelum / $denom * 100) }}%; background: #cbd5e1; border-radius: 999px;"></div>
      </div>
      <div style="width: 40px; text-align: right; font-weight: 700; color: #0f172a;">{{ $totalBelum }}</div>
    </div>
  </div>
</div>
@endsection
