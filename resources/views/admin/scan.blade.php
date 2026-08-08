@extends('layouts.admin')

@section('title', 'Check-in Scan QR - Tixia')
@section('page_title', 'Check Schedule & QR Scan')

@push('head')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
@endpush

@section('admin-content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap;">
  <div>
    <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">Scan QR Code — Check-in</h2>
    <div style="font-size: 13px; color: #64748b; margin-top: 4px;">Scan QR Code atau masukkan kode tiket peserta saat hari H event.</div>
  </div>
</div>

<div class="tixia-card" style="padding: 32px;">
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start;">
    <div>
      <!-- Camera Scanner Container -->
      <div style="width: 100%; max-width: 320px; margin: 0 auto; border: 1px solid #cbd5e1; border-radius: 20px; overflow: hidden; background: #f8fafc; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <div id="reader" style="width: 100%;"></div>
      </div>

      <div style="display: flex; gap: 10px; margin-top: 20px; max-width: 380px; margin-left: auto; margin-right: auto;">
        <input id="scan-code-input" placeholder="Ketik kode tiket, mis. TRX-8841" value="{{ request('code') }}" style="flex: 1; padding: 12px 18px; border: 1px solid #cbd5e1; border-radius: 12px; font-family: 'IBM Plex Mono', monospace; font-size: 14px; outline: none; background: #ffffff; color: #0f172a;">
        <button onclick="processScan()" class="tixia-report-btn" style="background: #383be5; color: #fff; border-radius: 12px; padding: 12px 24px;">Scan</button>
      </div>
    </div>

    <div id="scan-result" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 20px; padding: 28px; min-height: 280px; display: flex; flex-direction: column; justify-content: center;">
      <div style="text-align: center; color: #94a3b8; font-size: 14px;">
        Belum ada hasil scan.<br>
        Masukkan kode tiket di samping untuk verifikasi kehadiran.
      </div>
    </div>
  </div>
</div>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
/* Styling html5-qrcode agar serasi dengan Tixia Admin */
#reader {
  border: none !important;
}
#reader__dashboard_section_csr button {
  background: #383be5 !important;
  color: #fff !important;
  border: none !important;
  padding: 8px 16px !important;
  border-radius: 8px !important;
  font-size: 13px !important;
  font-weight: 600 !important;
  cursor: pointer !important;
  margin: 10px 4px !important;
  transition: all 0.2s !important;
}
#reader__dashboard_section_csr button:hover {
  background: #2f32d4 !important;
}
#reader__dashboard_section_csr select {
  padding: 8px 12px !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 8px !important;
  font-size: 13px !important;
  outline: none !important;
  background: #fff !important;
}
#reader img {
  display: none !important;
}
</style>
<script>
let scanningCode = '{{ request('code') }}';
let html5QrcodeScanner;

function onScanSuccess(decodedText, decodedResult) {
  const input = document.getElementById('scan-code-input');
  if (input && input.value !== decodedText) {
    input.value = decodedText;
    processScan();
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('scan-code-input');
  if (input) {
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') processScan();
    });
    if (scanningCode) setTimeout(processScan, 300);
  }

  // Mulai inisialisasi QR scanner kamera
  if (typeof Html5QrcodeScanner !== 'undefined') {
    html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", 
      { 
        fps: 15, 
        qrbox: { width: 200, height: 200 },
        rememberLastUsedCamera: true
      },
      /* verbose= */ false
    );
    html5QrcodeScanner.render(onScanSuccess);
  }
});

function processScan() {
  const input = document.getElementById('scan-code-input');
  const code = (input.value || '').trim();
  if (!code) return;

  const btn = document.querySelector('button[onclick="processScan()"]');
  const resultDiv = document.getElementById('scan-result');
  if (btn) { btn.disabled = true; btn.textContent = 'Memproses...'; }

  resultDiv.innerHTML = `
    <div style="text-align:center;">
      <div style="width:40px;height:40px;border:4px solid #e2e8f0;border-top:4px solid #383be5;border-radius:50%;margin:0 auto 16px;animation:spin 0.8s linear infinite;"></div>
      <div style="color:#64748b;font-size:14px;">Memeriksa tiket...</div>
    </div>`;

  fetch('{{ route('admin.scan.process') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
    },
    body: JSON.stringify({ code }),
  })
  .then(res => res.json())
  .then(data => {
    if (data.error) {
      resultDiv.innerHTML = `
        <div style="text-align:center;">
          <div style="width:48px;height:48px;margin:0 auto 12px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#ef4444" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6m0-6l6 6"/></svg>
          </div>
          <div style="font-weight: 800; font-size: 18px; color: #ef4444;">Tiket Tidak Ditemukan</div>
          <div style="color: #64748b; font-size: 13px; margin-top: 6px;">Kode: ${code}</div>
        </div>`;
      if (btn) { btn.disabled = false; btn.textContent = 'Scan'; }
      return;
    }

    const p = data.participant;
    const already = data.already_checked;
    const msg = already ? 'Sudah Check-in Sebelumnya' : 'Check-in Berhasil!';
    const color = already ? '#f59e0b' : '#16a34a';
    const iconSvg = already
      ? '<svg width=\"40\" height=\"40\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"#f59e0b\" stroke-width=\"2\"><circle cx=\"12\" cy=\"12\" r=\"10\"/><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M12 8v4m0 4h.01\"/></svg>'
      : '<svg width=\"40\" height=\"40\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"#16a34a\" stroke-width=\"2\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\"/></svg>';

    resultDiv.innerHTML = `
      <div style="text-align:center;">
        <div style="width:56px;height:56px;margin:0 auto 12px;background:${already ? '#fffbeb' : '#f0fdf4'};border-radius:50%;display:flex;align-items:center;justify-content:center;">${iconSvg}</div>
        <div style="font-weight: 800; font-size: 20px; color: ${color};">${msg}</div>
        <div style="margin-top: 20px; text-align: left; background: #ffffff; padding: 18px; border-radius: 14px; border: 1px solid #e2e8f0;">
          <div style="display:flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
            <span style="color:#64748b;">Nama:</span>
            <strong style="color:#0f172a;">${p.name}</strong>
          </div>
          <div style="display:flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
            <span style="color:#64748b;">Event:</span>
            <strong style="color:#0f172a;">${p.event ? p.event.title : '—'}</strong>
          </div>
          <div style="display:flex; justify-content: space-between; font-size: 14px;">
            <span style="color:#64748b;">Waktu:</span>
            <strong style="color:#0f172a;">${p.checkin_time ? new Date(p.checkin_time).toLocaleString('id-ID') : '-'}</strong>
          </div>
        </div>
      </div>`;
    showToast('Status peserta berhasil diperbarui ke Hadir!');
    if (btn) { btn.disabled = false; btn.textContent = 'Scan'; }
  })
  .catch(() => {
    document.getElementById('scan-result').innerHTML =
      `<div style="text-align:center; color:#ef4444; font-weight:700;">Terjadi kesalahan. Silakan coba lagi.</div>`;
    if (btn) { btn.disabled = false; btn.textContent = 'Scan'; }
  });
}
</script>
@endsection
