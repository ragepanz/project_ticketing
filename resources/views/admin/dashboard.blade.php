@extends('layouts.admin')

@section('title', 'Dashboard - Tixia')
@section('page_title', 'Orders')

@section('admin-content')
<!-- Top Stat Summary Banner -->
<div class="tixia-stat-banner">
  <div style="display: flex; align-items: center; gap: 20px;">
    <a href="{{ route('admin.export-csv') }}" class="tixia-report-btn">
      <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
      <span>Generate Report</span>
    </a>
    <div class="tixia-banner-info">
      Laporan penjualan tiket & data statistik peserta event secara real-time.
    </div>
  </div>

  <div class="tixia-metrics-row">
    <div class="tixia-metric-item">
      <div class="m-icon">📊</div>
      <div>
        <div class="m-label">Income</div>
        <div class="m-val">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
      </div>
    </div>

    <div class="tixia-metric-item">
      <div class="m-icon">📈</div>
      <div>
        <div class="m-label">Customer</div>
        <div class="m-val">{{ $totalPeserta }} Person</div>
      </div>
    </div>

    <div class="tixia-metric-item">
      <div class="m-icon">🍩</div>
      <div>
        <div class="m-label">Check-in Rate</div>
        <div class="m-val blue">{{ $checkinPercent }}%</div>
      </div>
    </div>
  </div>
</div>

<!-- Orders / Participants Table Card -->
<div class="tixia-card">
  <div class="tixia-table-wrap">
    <table class="tixia-table">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Date</th>
          <th>Event Name</th>
          <th>Customer Name ↕</th>
          <th>Location</th>
          <th>Sold Ticket</th>
          <th>Available</th>
          <th>Refund</th>
          <th>Total Revenue</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentParticipants as $index => $p)
        <tr class="{{ $index === 4 ? 'tixia-highlight' : '' }}">
          <td style="font-weight: 700; color: #475569;">#{{ $p->trx_id }}</td>
          <td style="color: #64748b; font-size: 12.5px;">
            {{ $p->created_at ? $p->created_at->format('d/m/Y h:i A') : '04/06/2026 12:34 AM' }}
          </td>
          <td style="font-weight: 700; color: #1e293b;">
            {{ $p->event->title ?? 'Seminar Nasional EventFlow' }}
          </td>
          <td style="font-weight: 600; color: #334155;">{{ $p->name }}</td>
          <td style="color: #64748b;">{{ $p->instansi ?? ($p->event->location ?? 'Medan, Indonesia') }}</td>
          <td>1 Pcs</td>
          <td style="color: #64748b;">
            {{ max(0, ($p->event->quota ?? 100) - ($p->event->participants_count ?? 1)) }} left
          </td>
          <td>
            @if($p->status === 'lunas')
              <span class="tixia-badge-no">NO</span>
            @else
              <span class="tixia-badge-refund">REFUND</span>
            @endif
          </td>
          <td>
            <span class="tixia-pill-rev">
              Rp {{ number_format($p->event->price ?? 125000, 0, ',', '.') }}
            </span>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" style="text-align: center; padding: 48px; color: #94a3b8;">
            Belum ada transaksi / data peserta.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
