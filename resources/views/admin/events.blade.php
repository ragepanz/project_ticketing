@extends('layouts.admin')

@section('title', 'Kelola Event - Tixia')
@section('page_title', 'Schedule & Event List')

@section('admin-content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap;">
  <div>
    <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">Jadwal & Event List</h2>
    <div style="font-size: 13px; color: #64748b; margin-top: 4px;">Kelola jadwal event, poster foto, kuota peserta, dan harga tiket.</div>
  </div>
  <button class="tixia-report-btn" onclick="toggleModal()" style="background: linear-gradient(135deg, #383be5 0%, #2528c7 100%); color: #fff; box-shadow: 0 4px 14px rgba(56, 59, 229, 0.25);">
    <span>+ Tambah Event Baru</span>
  </button>
</div>

<div class="tixia-card">
  <div class="tixia-table-wrap">
    <table class="tixia-table">
      <thead>
        <tr>
          <th>Poster</th>
          <th>Nama Event & Pemateri</th>
          <th>Tanggal & Jam</th>
          <th>Lokasi</th>
          <th>Harga Tiket</th>
          <th>Kuota & Pendaftar</th>
          <th style="text-align: right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($events as $event)
        <tr>
          <td style="width: 70px;">
            <div style="width: 56px; height: 56px; border-radius: 12px; overflow: hidden; background: #e2e8f0; border: 1px solid #cbd5e1;">
              <img src="{{ $event->image_url }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
          </td>
          <td>
            <div style="font-weight: 700; color: #1e293b; font-size: 14px;">{{ $event->title }}</div>
            <div style="font-size: 12px; color: #383be5; font-weight: 600; margin-top: 2px;">{{ $event->speaker ?? 'Pemateri Utama' }}</div>
          </td>
          <td style="font-weight: 600; color: #334155;">
            <div>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</div>
            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $event->time_slot ?? '10.00 WIB' }}</div>
          </td>
          <td style="color: #64748b;">{{ $event->location }}</td>
          <td>
            <span class="tixia-pill-rev">
              {{ $event->rupiah }}
            </span>
          </td>
          <td>
            <div style="font-weight: 700; color: #0f172a;">{{ $event->participants_count }} / {{ $event->quota }}</div>
            <div style="font-size: 11px; color: #64748b;">Peserta terdaftar</div>
          </td>
          <td style="text-align: right;">
            <div style="display: flex; gap: 8px; justify-content: flex-end;">
              <button class="tixia-icon-btn" title="Edit Event" style="width: 34px; height: 34px;"
                onclick="editEvent({{ $event->id }}, '{{ str_replace("'", "\'", $event->title) }}', '{{ str_replace("'", "\'", $event->speaker ?? '') }}', '{{ str_replace("'", "\'", $event->time_slot ?? '') }}', '{{ $event->date }}', '{{ str_replace("'", "\'", $event->location) }}', '{{ str_replace("'", "\'", $event->desc) }}', {{ $event->price }}, {{ $event->quota }}, '{{ str_replace("'", "\'", $event->image_url) }}')">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
              </button>
              <form method="POST" action="{{ route('admin.events.destroy', $event) }}" style="display:inline" onsubmit="return confirm('Hapus event ini?')">
                @csrf @method('DELETE')
                <button class="tixia-icon-btn" title="Hapus Event" style="width: 34px; height: 34px; color: #ef4444;">
                  <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align: center; padding: 48px; color: #94a3b8;">
            Belum ada event diselenggarakan.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Dialog -->
<div class="modal-overlay" id="event-modal">
  <div class="modal-box" style="background: #ffffff; color: #1e293b; max-width: 760px;">
    <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
      <div class="modal-header-left">
        <div class="modal-header-icon" id="modal-icon" style="background: #eef2ff; color: #383be5;">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div class="modal-header-text">
          <h3 id="modal-title" style="color: #0f172a;">Tambah Event Baru</h3>
          <p id="modal-subtitle" style="color: #64748b;">Lengkapi informasi & poster foto event yang akan diselenggarakan</p>
        </div>
      </div>
      <button class="modal-close-btn" onclick="toggleModal()" style="color: #64748b; background: #f1f5f9;">✕</button>
    </div>

    <form method="POST" action="{{ route('admin.events.store') }}" id="event-form" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="_method" value="POST" id="form-method">
      <input type="hidden" name="event_id" id="form-event-id">

      <div class="modal-body" style="padding: 24px;">
        <div class="modal-form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div class="field field-full" style="grid-column: 1 / -1;">
            <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Nama Event</label>
            <input id="form-title" name="title" placeholder="Contoh: Konferensi & Kajian Akbar 2026" required style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
          </div>

          <div class="field">
            <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Pemateri / Speaker</label>
            <input id="form-speaker" name="speaker" placeholder="Contoh: Ustadz Dr. Khalid Basalamah" style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
          </div>

          <div class="field">
            <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Jam / Waktu Sesi</label>
            <input id="form-time-slot" name="time_slot" placeholder="Contoh: 10.00 - 11.30 WIB" style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
          </div>

          <div class="field">
            <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Tanggal Event</label>
            <input id="form-date" name="date" type="date" required style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
          </div>

          <div class="field">
            <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Lokasi</label>
            <input id="form-location" name="location" placeholder="Contoh: JICC Senayan, Jakarta" required style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
          </div>

          <div class="field">
            <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Harga Tiket (Rp)</label>
            <input id="form-price" name="price" type="number" placeholder="150000" required style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
          </div>

          <div class="field">
            <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Kuota Peserta</label>
            <input id="form-quota" name="quota" type="number" placeholder="320" required style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a;">
          </div>

          <!-- Photo Upload & URL Section -->
          <div class="field field-full" style="grid-column: 1 / -1; background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
            <label style="color: #0f172a; font-weight: 700; font-size: 13.5px; display: block; margin-bottom: 8px;">Foto / Poster Event</label>
            
            <div style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
              <!-- Preview thumbnail -->
              <div style="width: 80px; height: 80px; border-radius: 12px; overflow: hidden; background: #e2e8f0; border: 1px solid #cbd5e1; flex-shrink: 0;">
                <img id="image-preview" src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
              </div>

              <div style="flex: 1; min-width: 240px; display: flex; flex-direction: column; gap: 8px;">
                <div>
                  <span style="font-size: 12px; font-weight: 600; color: #475569;">Upload File Gambar:</span>
                  <input type="file" name="image_file" id="form-image-file" accept="image/*" style="display: block; width: 100%; margin-top: 4px; font-size: 12.5px;" onchange="previewFile(this)">
                </div>

                <div>
                  <span style="font-size: 12px; font-weight: 600; color: #475569;">Atau Link / URL Gambar:</span>
                  <input id="form-image-url" name="image_url" placeholder="https://images.unsplash.com/photo-..." style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; outline: none; background: #fff; color: #0f172a; margin-top: 2px;" oninput="previewUrl(this.value)">
                </div>
              </div>
            </div>
          </div>

          <div class="field field-full" style="grid-column: 1 / -1;">
            <label style="color: #334155; font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Deskripsi Event</label>
            <textarea id="form-desc" name="desc" rows="3" placeholder="Jelaskan tentang event ini..." style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; outline: none; background: #fff; color: #0f172a; resize: vertical;"></textarea>
          </div>
        </div>
      </div>

      <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; justify-content: flex-end; gap: 12px;">
        <button type="button" class="btn" onclick="toggleModal()" style="padding: 10px 20px; border-radius: 10px; border: 1px solid #cbd5e1; background: #fff; color: #475569; font-weight: 600;">Batal</button>
        <button type="submit" class="btn" id="modal-submit" style="padding: 10px 24px; border-radius: 10px; border: none; background: #383be5; color: #fff; font-weight: 700;">Simpan Event</button>
      </div>
    </form>
  </div>
</div>

<script>
function previewFile(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById('image-preview').src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function previewUrl(url) {
  if (url && url.trim().length > 5) {
    document.getElementById('image-preview').src = url;
  }
}

function toggleModal() {
  const m = document.getElementById('event-modal');
  m.classList.toggle('open');
  if (!m.classList.contains('open')) {
    document.getElementById('event-form').reset();
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-event-id').value = '';
    document.getElementById('modal-title').textContent = 'Tambah Event Baru';
    document.getElementById('modal-subtitle').textContent = 'Lengkapi informasi & poster foto event yang akan diselenggarakan';
    document.getElementById('modal-submit').textContent = 'Simpan Event';
    document.getElementById('modal-icon').innerHTML = '<svg width=\"20\" height=\"20\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" stroke-width=\"2\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"/></svg>';
    document.getElementById('image-preview').src = 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80';
    document.getElementById('event-form').action = '{{ route('admin.events.store') }}';
  }
}

function editEvent(id, title, speaker, time_slot, date, location, desc, price, quota, imageUrl) {
  document.getElementById('form-event-id').value = id;
  document.getElementById('form-title').value = title;
  document.getElementById('form-speaker').value = speaker || '';
  document.getElementById('form-time-slot').value = time_slot || '';
  document.getElementById('form-date').value = date;
  document.getElementById('form-location').value = location;
  document.getElementById('form-desc').value = desc;
  document.getElementById('form-price').value = price;
  document.getElementById('form-quota').value = quota;
  document.getElementById('form-image-url').value = imageUrl || '';
  if (imageUrl) {
    document.getElementById('image-preview').src = imageUrl;
  }
  document.getElementById('modal-title').textContent = 'Edit Event & Poster';
  document.getElementById('modal-subtitle').textContent = 'Perbarui informasi dan poster foto event';
  document.getElementById('modal-submit').textContent = 'Perbarui Event';
  document.getElementById('modal-icon').innerHTML = '<svg width=\"20\" height=\"20\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" stroke-width=\"2\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z\"/></svg>';
  document.getElementById('event-form').action = '{{ url('admin/events') }}/' + id;
  document.getElementById('form-method').value = 'PUT';
  toggleModal();
}

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('event-modal').addEventListener('click', function (e) {
    if (e.target === this) toggleModal();
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && document.getElementById('event-modal').classList.contains('open')) {
      toggleModal();
    }
  });
});
</script>
@endsection
