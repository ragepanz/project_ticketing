<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Tiket - {{ $participant->trx_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .ticket {
            background: white;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .ticket-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .ticket-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .ticket-header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .ticket-content {
            padding: 30px;
        }
        .event-info {
            margin-bottom: 25px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 20px;
        }
        .event-info h2 {
            font-size: 22px;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
            color: #6b7280;
        }
        .info-value {
            flex: 1;
            color: #1f2937;
        }
        .participant-info {
            margin-bottom: 25px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 20px;
        }
        .participant-info h3 {
            font-size: 16px;
            color: #1f2937;
            margin-bottom: 12px;
        }
        .qr-section {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }
        .qr-section p {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        .qr-code {
            display: inline-block;
            width: 150px;
            height: 150px;
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-radius: 4px;
            padding: 8px;
            font-size: 11px;
            text-align: center;
            line-height: 150px;
            color: #6b7280;
        }
        .ticket-code {
            background: #f0f9ff;
            border: 2px dashed #3b82f6;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 20px;
        }
        .ticket-code .label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        .ticket-code .code {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 2px;
            font-family: 'Courier New', monospace;
        }
        .footer {
            background: #f9fafb;
            padding: 15px 30px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .status {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <h1>E-TIKET</h1>
            <p>EventFlow & Tixia Ticketing Platform</p>
        </div>

        <div class="ticket-content">
            <!-- Event Info -->
            <div class="event-info">
                <h2>{{ $event->title }}</h2>
                <div class="info-row">
                    <span class="info-label">Pemateri:</span>
                    <span class="info-value">{{ $event->speaker ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Waktu:</span>
                    <span class="info-value">{{ $event->time_slot ?? 'TBA' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Lokasi:</span>
                    <span class="info-value">{{ $event->location }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Harga:</span>
                    <span class="info-value">{{ $event->rupiah }}</span>
                </div>
            </div>

            <!-- Ticket Code -->
            <div class="ticket-code">
                <div class="label">KODE TIKET / TRANSACTION ID</div>
                <div class="code">{{ $participant->trx_id }}</div>
            </div>

            <!-- Participant Info -->
            <div class="participant-info">
                <h3>Data Peserta</h3>
                <div class="info-row">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $participant->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $participant->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">WhatsApp:</span>
                    <span class="info-value">{{ $participant->phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Instansi:</span>
                    <span class="info-value">{{ $participant->instansi ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status">✓ LUNAS</span>
                    </span>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                <p>Scan QR Code untuk verifikasi tiket</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($participant->trx_id) }}" alt="QR Code" style="width: 150px; height: 150px;" />
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>E-tiket ini berlaku sebagai bukti pembayaran dan akses ke acara.</p>
                <p>Silakan tunjukkan e-tiket ini saat check-in di lokasi acara.</p>
                <p style="margin-top: 10px; color: #9ca3af;">
                    Dicetak pada: {{ now()->format('d F Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
