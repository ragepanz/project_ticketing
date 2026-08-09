@extends('layouts.admin')

@section('title', 'Kelola Wilayah & Lokasi — Admin')
@section('page_title', 'Kelola Wilayah & Lokasi')

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
      <h3 style="font-size:18px; font-weight:800; color:#0f172a; margin:0 0 4px;">Wilayah Kota & Lokasi Venue</h3>
      <p style="font-size:13.5px; color:#64748b; margin:0;">Kelola daftar wilayah kota, nama hotel/venue, serta dokumentasi event yang tampil di landing page beranda.</p>
    </div>
    <button onclick="document.getElementById('addCityForm').style.display='block'" class="tixia-btn-primary">
      + Tambah Wilayah Kota
    </button>
  </div>

  <!-- Add Form Card -->
  <div id="addCityForm" style="display:none; background:#fff; border-radius:20px; padding:28px; border:1px solid #383be5; box-shadow:0 10px 30px rgba(56,59,229,0.1);">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
      <h4 style="font-size:16px; font-weight:800; color:#0f172a; margin:0;">Tambah Wilayah Kota Baru</h4>
      <button onclick="document.getElementById('addCityForm').style.display='none'" style="border:none; background:transparent; font-size:18px; cursor:pointer; color:#64748b;">✕</button>
    </div>
    <form method="POST" action="{{ route('admin.cities.store') }}" enctype="multipart/form-data">
      @csrf
      <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:16px; margin-bottom:16px;">
        <div>
          <label style="display:block; font-size:12.5px; font-weight:700; color:#475569; margin-bottom:6px;">Nama Kota (misal: BATAM, JAKARTA)</label>
          <input name="name" placeholder="Contoh: SEMARANG" required style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:10px; font-size:13.5px;">
        </div>
        <div>
          <label style="display:block; font-size:12.5px; font-weight:700; color:#475569; margin-bottom:6px;">Nama Venue / Hotel Location</label>
          <input name="location_name" placeholder="Contoh: Grand Candi Hotel Semarang" style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:10px; font-size:13.5px;">
        </div>
        <div>
          <label style="display:block; font-size:12.5px; font-weight:700; color:#475569; margin-bottom:6px;">Unggah Foto Dokumentasi (Opsional)</label>
          <input type="file" name="image" accept="image/*" style="width:100%; padding:8px 14px; border:1px solid #cbd5e1; border-radius:10px; font-size:13.5px;">
        </div>
      </div>
      <button type="submit" class="tixia-btn-primary" style="background:#383be5; color:#fff; width:100%; justify-content:center;">Simpan Wilayah</button>
    </form>
  </div>

  <!-- Cities Cards Grid -->
  <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:20px;">
    @forelse($cities as $city)
    <div style="background:#fff; border-radius:18px; border:1px solid #edf2f7; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,0.03); display:flex; flex-direction:column;">
      <div style="height:120px; background:#020c1b; position:relative; overflow:hidden;">
        @if($city->image_url)
          <img src="{{ $city->image_url }}" alt="{{ $city->name }}" style="width:100%; height:100%; object-fit:cover; opacity:0.85;">
        @endif
        <div style="position:absolute; inset:0; background:linear-gradient(180deg, transparent 30%, rgba(2,12,27,0.85) 100%); display:flex; align-items:flex-end; padding:14px;">
          <h4 style="font-size:18px; font-weight:800; color:#ffffff; margin:0; letter-spacing:0.05em;">{{ $city->name }}</h4>
        </div>
      </div>
      <div style="padding:16px; display:flex; flex-direction:column; gap:12px; flex:1; justify-content:space-between;">
        <div style="font-size:13px; color:#64748b;">
          📍 {{ $city->location_name ?? 'Hotel / Convention Center' }}
        </div>
        <form method="POST" action="{{ route('admin.cities.destroy', $city) }}" onsubmit="return confirm('Hapus wilayah {{ $city->name }}?')" style="margin-top:auto;">
          @csrf
          @method('DELETE')
          <button type="submit" style="width:100%; border:1px solid #fca5a5; background:#fef2f2; color:#ef4444; padding:7px 12px; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; text-align:center;">
            Hapus Wilayah
          </button>
        </form>
      </div>
    </div>
    @empty
    <div style="grid-column:1/-1; text-align:center; padding:40px; color:#94a3b8; background:#fff; border-radius:18px;">Belum ada data wilayah.</div>
    @endforelse
  </div>

</div>
@endsection
