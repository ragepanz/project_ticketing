@extends('layouts.admin')

@section('title', 'Check-in Scan QR - Tixia')
@section('page_title', 'Check Schedule & QR Scan')

@push('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" type="text/javascript"></script>
@endpush

@section('admin-content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap;">
  <div>
    <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0;">Scan QR Code — Check-in</h2>
    <div style="font-size: 13px; color: #64748b; margin-top: 4px;">Scan QR Code atau masukkan kode tiket peserta saat hari H event.</div>
  </div>
</div>

<div class="tixia-card" style="padding: 32px;">
  <!-- Grid layout responsif (1 kolom di HP, 2 kolom di tablet/desktop) -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px; align-items: start;">
    <div>
<!-- Camera Scanner Container -->
      <div style="width: 100%; max-width: 320px; margin: 0 auto; border: 1px solid #cbd5e1; border-radius: 20px; overflow: hidden; background: #f8fafc; box-shadow: 0 4px 12px rgba(0,0,0,0.05); position: relative;">
        <!-- Area preview kamera -->
        <div id="reader" style="width: 100%; aspect-ratio: 1; background: #000; position: relative; overflow: hidden;">
          <!-- Placeholder ketika kamera belum aktif -->
          <div id="scanner-placeholder" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; font-size: 13px; font-weight: 600; text-align: center; padding: 20px; z-index: 5; background: #0f172a;">
            <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin-bottom:12px; opacity:0.7;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
            </svg>
            Kamera belum aktif
          </div>
        </div>
      </div>
        </div>
      </div>

      <!-- Kamera controls & selectors -->
      <div style="margin: 20px auto; max-width: 320px; display: flex; flex-direction: column; gap: 10px;">
        <div id="camera-select-container" style="display: none;">
          <label style="font-size: 12px; font-weight:700; color:#64748b; display:block; margin-bottom:4px;">PILIH KAMERA:</label>
          <select id="camera-select" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13px; background:#fff; outline:none;"></select>
        </div>

        <div style="display: flex; gap: 8px;">
          <button id="start-scan-btn" onclick="startCamera()" class="tixia-report-btn" style="flex: 1; background: #16a34a; color: #fff; border-radius: 12px; padding: 12px; font-size: 13.5px; font-weight:700;">
            Aktifkan Kamera
          </button>
          <button id="stop-scan-btn" onclick="stopCamera()" class="tixia-report-btn" style="flex: 1; background: #ef4444; color: #fff; border-radius: 12px; padding: 12px; font-size: 13.5px; font-weight:700; display: none;">
            Matikan Kamera
          </button>
        </div>
      </div>

      <div style="display: flex; gap: 10px; margin-top: 20px; max-width: 380px; margin-left: auto; margin-right: auto; padding-top: 10px; border-top: 1px dashed #cbd5e1;">
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
/* Styling reader container */
#reader {
  position: relative !important;
  overflow: hidden !important;
}
#reader video {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  border-radius: 18px !important;
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
}
</style>
<script>
let scanningCode = '{{ request('code') }}';
let html5QrCode;
let selectedCameraId;

function onScanSuccess(decodedText, decodedResult) {
  // Mainkan efek bip getar jika didukung
  if (navigator.vibrate) navigator.vibrate(100);

  const input = document.getElementById('scan-code-input');
  if (input) {
    input.value = decodedText;
    processScan();
    // Stop kamera sementara setelah berhasil deteksi untuk menghindari double-trigger
    stopCamera();
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

  // Siapkan instansi html5QrCode secara background
  if (typeof Html5Qrcode !== 'undefined') {
    try {
      html5QrCode = new Html5Qrcode("reader");
      console.log("Scanner ready");
    } catch(err) {
      alert("Inisialisasi kamera error: " + err.message);
    }
  } else {
    alert("Perhatian: Library kamera gagal dimuat oleh browser. Cek koneksi internet Anda.");
  }
});

// Fungsi memicu kamera dan meminta izin akses
function startCamera() {
  const placeholder = document.getElementById('scanner-placeholder');
  const startBtn = document.getElementById('start-scan-btn');
  const stopBtn = document.getElementById('stop-scan-btn');
  const selectContainer = document.getElementById('camera-select-container');
  const selectElement = document.getElementById('camera-select');

  if (typeof Html5Qrcode === 'undefined') {
    alert('Library html5-qrcode GAGAL dimuat. Cek koneksi internet & refresh halaman.');
    return;
  }

  // Cek dukungan HTTPS / MediaDevices
  if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
    alert("Browser tidak mendukung akses kamera. Pastikan akses via HTTPS:// (bukan HTTP).");
    return;
  }

  if (!html5QrCode) {
    try {
      html5QrCode = new Html5Qrcode("reader");
      console.log("Html5Qrcode instance created");
    } catch (e) {
      alert("Gagal inisialisasi scanner: " + e.message);
      return;
    }
  }

  // Tampilkan loading / indikator
  startBtn.disabled = true;
  startBtn.textContent = 'Membuka Kamera...';
  console.log("Starting camera...");

  const config = { 
    fps: 10, 
    qrbox: function(width, height) {
      const minDim = Math.min(width, height);
      return { width: Math.floor(minDim * 0.7), height: Math.floor(minDim * 0.7) };
    }
  };

  const startWithFacingMode = () => {
    return html5QrCode.start(
      { facingMode: "environment" },
      config,
      onScanSuccess,
      (err) => { console.warn("Scan error:", err); }
    );
  };

  const startWithCameraId = (cameraId) => {
    return html5QrCode.start(
      cameraId,
      config,
      onScanSuccess,
      (err) => { console.warn("Scan error:", err); }
    );
  };

  // Jalankan scanner langsung
  startWithFacingMode()
    .then(() => {
      console.log("Camera started successfully via facingMode");
      onCameraStarted();
      populateCameraList();
    })
    .catch(err => {
      console.error("facingMode failed:", err);
      
      // Fallback
      Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length > 0) {
          const backCam = devices.find(d => 
            (d.label || '').toLowerCase().includes('back') || 
            (d.label || '').toLowerCase().includes('belakang') || 
            (d.label || '').toLowerCase().includes('environment')
          );
          const camId = backCam ? backCam.id : devices[0].id;
          
          return startWithCameraId(camId).then(() => {
            onCameraStarted();
            populateCameraList(devices);
          });
        } else {
          throw new Error('Tidak ada kamera terdeteksi.');
        }
      }).catch(finalErr => {
        console.error("Camera Start Error:", finalErr);
        resetCameraUI();
        alert('Gagal akses kamera: ' + (finalErr.message || finalErr));
      });
    });
}

function onCameraStarted() {
  const placeholder = document.getElementById('scanner-placeholder');
  const startBtn = document.getElementById('start-scan-btn');
  const stopBtn = document.getElementById('stop-scan-btn');

  placeholder.style.display = 'none';
  startBtn.style.display = 'none';
  startBtn.disabled = false;
  startBtn.textContent = 'Aktifkan Kamera';
  stopBtn.style.display = 'block';
}

function resetCameraUI() {
  const placeholder = document.getElementById('scanner-placeholder');
  const startBtn = document.getElementById('start-scan-btn');
  const stopBtn = document.getElementById('stop-scan-btn');
  const selectContainer = document.getElementById('camera-select-container');

  placeholder.style.display = 'flex';
  startBtn.style.display = 'block';
  startBtn.disabled = false;
  startBtn.textContent = 'Aktifkan Kamera';
  stopBtn.style.display = 'none';
  selectContainer.style.display = 'none';
}

function populateCameraList(devicesList) {
  const selectContainer = document.getElementById('camera-select-container');
  const selectElement = document.getElementById('camera-select');

  const getDevices = devicesList ? Promise.resolve(devicesList) : Html5Qrcode.getCameras();

  getDevices.then(devices => {
    if (devices && devices.length > 1) {
      selectContainer.style.display = 'block';
      selectElement.innerHTML = '';
      devices.forEach((device, index) => {
        const opt = document.createElement('option');
        opt.value = device.id;
        opt.text = device.label || `Kamera ${index + 1}`;
        selectElement.appendChild(opt);
      });

      selectElement.onchange = function() {
        stopCamera().then(() => {
          html5QrCode.start(
            selectElement.value,
            { fps: 15, qrbox: { width: 220, height: 220 } },
            onScanSuccess,
            () => {}
          ).then(onCameraStarted);
        });
      };
    }
  }).catch(() => {});
}

function stopCamera() {
  if (html5QrCode && html5QrCode.isScanning) {
    return html5QrCode.stop().then(() => {
      resetCameraUI();
    }).catch(err => {
      console.error('Gagal mematikan kamera: ', err);
      resetCameraUI();
    });
  }
  return Promise.resolve();
}

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
