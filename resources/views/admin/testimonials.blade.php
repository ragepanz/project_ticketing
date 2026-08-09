@extends('layouts.admin')

@section('title', 'Kelola Ulasan Peserta — Admin')
@section('page_title', 'Kelola Ulasan Peserta')

@section('admin-content')
<div style="display:flex; flex-direction:column; gap:24px;">

  @if(session('success'))
  <div style="background:#ecfdf5; border:1px solid #10b981; color:#065f46; padding:14px 20px; border-radius:14px; font-weight:600; font-size:14px;">
    {{ session('success') }}
  </div>
  @endif

  <!-- Top Banner Action -->
  <div style="background:#fff; border-radius:20px; padding:24px; border:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
    <div>
      <h3 style="font-size:18px; font-weight:800; color:#0f172a; margin:0 0 4px;">Ulasan & Feedback Peserta</h3>
      <p style="font-size:13.5px; color:#64748b; margin:0;">Moderasi komentar dan pilih ulasan terbaik untuk ditampilkan di halaman beranda utama.</p>
    </div>
    <button onclick="document.getElementById('addTestimonialForm').style.display='block'" class="tixia-btn-primary">
      + Tambah Ulasan Kurasi
    </button>
  </div>

  <!-- Add Form Modal/Card -->
  <div id="addTestimonialForm" style="display:none; background:#fff; border-radius:20px; padding:28px; border:1px solid #383be5; box-shadow:0 10px 30px rgba(56,59,229,0.1);">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
      <h4 style="font-size:16px; font-weight:800; color:#0f172a; margin:0;">Tambah Ulasan Kurasi Baru</h4>
      <button onclick="document.getElementById('addTestimonialForm').style.display='none'" style="border:none; background:transparent; font-size:18px; cursor:pointer; color:#64748b;">✕</button>
    </div>
    <form method="POST" action="{{ route('admin.testimonials.store') }}">
      @csrf
      <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:16px; margin-bottom:16px;">
        <div>
          <label style="display:block; font-size:12.5px; font-weight:700; color:#475569; margin-bottom:6px;">Nama Peserta</label>
          <input name="name" placeholder="Contoh: Anisa Rahmawati" required style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:10px; font-size:13.5px;">
        </div>
        <div>
          <label style="display:block; font-size:12.5px; font-weight:700; color:#475569; margin-bottom:6px;">Kota / Asal Event</label>
          <input name="city_or_event" placeholder="Contoh: Peserta Mental Talk Jakarta" style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:10px; font-size:13.5px;">
        </div>
        <div>
          <label style="display:block; font-size:12.5px; font-weight:700; color:#475569; margin-bottom:6px;">Rating (1-5)</label>
          <select name="rating" style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:10px; font-size:13.5px;">
            <option value="5" selected>⭐⭐⭐⭐⭐ (5 Bintang)</option>
            <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
            <option value="3">⭐⭐⭐ (3 Bintang)</option>
          </select>
        </div>
      </div>
      <div style="margin-bottom:16px;">
        <label style="display:block; font-size:12.5px; font-weight:700; color:#475569; margin-bottom:6px;">Isi Ulasan / Komentar</label>
        <textarea name="comment" rows="3" placeholder="Tuliskan ulasan mendalam peserta..." required style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:10px; font-size:13.5px;"></textarea>
      </div>
      <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px;">
        <input type="checkbox" name="is_featured" id="is_featured" value="1" checked style="width:18px; height:18px;">
        <label for="is_featured" style="font-size:13.5px; font-weight:600; color:#1e293b; cursor:pointer;">Tampilkan langsung di Landing Page Beranda</label>
      </div>
      <button type="submit" class="tixia-btn-primary" style="background:#383be5; color:#fff; width:100%; justify-content:center;">Simpan & Publikasikan</button>
    </form>
  </div>

  <!-- Testimonials Table -->
  <div class="tixia-card">
    <div class="tixia-table-wrap">
      <table class="tixia-table">
        <thead>
          <tr>
            <th>NAMA PESERTA</th>
            <th>ASAL KOTA / EVENT</th>
            <th>RATING</th>
            <th>ISI ULASAN</th>
            <th>STATUS TAMPIL</th>
            <th style="text-align:right;">AKSI</th>
          </tr>
        </thead>
        <tbody>
          @forelse($testimonials as $t)
          <tr>
            <td>
              <strong style="color:#0f172a;">{{ $t->name }}</strong>
            </td>
            <td>
              <span style="font-size:12.5px; color:#64748b;">{{ $t->city_or_event ?? '-' }}</span>
            </td>
            <td>
              <span style="color:#f59e0b; font-weight:700;">{{ str_repeat('★', $t->rating) }}</span>
            </td>
            <td>
              <p style="margin:0; font-size:13px; color:#334155; max-width:320px; line-height:1.5;">“{{ $t->comment }}”</p>
            </td>
            <td>
              @if($t->is_featured)
                <span style="background:#ecfdf5; border:1px solid #10b981; color:#047857; font-weight:700; font-size:11.5px; padding:4px 10px; border-radius:999px; display:inline-block;">✓ Tampil di Beranda</span>
              @else
                <span style="background:#f1f5f9; border:1px solid #cbd5e1; color:#64748b; font-weight:600; font-size:11.5px; padding:4px 10px; border-radius:999px; display:inline-block;">Disembunyikan</span>
              @endif
            </td>
            <td style="text-align:right;">
              <div style="display:flex; justify-content:flex-end; gap:8px;">
                <form method="POST" action="{{ route('admin.testimonials.toggle', $t) }}" style="display:inline;">
                  @csrf
                  @method('PATCH')
                  <button type="submit" style="border:1px solid #cbd5e1; background:#f8fafc; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer;">
                    {{ $t->is_featured ? 'Sembunyikan' : 'Tampilkan' }}
                  </button>
                </form>

                <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" style="display:inline;" onsubmit="return confirm('Hapus ulasan ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" style="border:1px solid #fca5a5; background:#fef2f2; color:#ef4444; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer;">
                    Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="text-align:center; padding:40px; color:#94a3b8;">Belum ada data ulasan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
