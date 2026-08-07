<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Tiket {{ $event->title }}</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        
        <div style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 32px 24px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700;">
                ✅ Pendaftaran Berhasil!
            </h1>
            <p style="color: #e0e7ff; margin: 8px 0 0 0; font-size: 14px;">
                {{ config('app.name', 'EventFlow & Tixia') }}
            </p>
        </div>

        <div style="padding: 32px 24px;">
            <p style="margin: 0 0 24px 0; color: #374151; font-size: 16px; line-height: 1.6;">
                Yth. <strong>{{ $participant->name }}</strong>,<br><br>
                Terima kasih telah mendaftar di event <strong>{{ $event->title }}</strong>. Berikut adalah detail e-tiket Anda:
            </p>

            <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Kode Tiket</td>
                        <td style="padding: 8px 0; color: #1f2937; font-size: 16px; font-weight: 700; text-align: right;">
                            {{ $participant->trx_id }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;">Event</td>
                        <td style="padding: 8px 0; color: #1f2937; font-size: 16px; font-weight: 600; text-align: right; border-top: 1px solid #e5e7eb;">
                            {{ $event->title }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;">Tanggal</td>
                        <td style="padding: 8px 0; color: #1f2937; font-size: 14px; text-align: right; border-top: 1px solid #e5e7eb;">
                            {{ \Carbon\Carbon::parse($event->date)->translatedFormat('l, d F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;">Lokasi</td>
                        <td style="padding: 8px 0; color: #1f2937; font-size: 14px; text-align: right; border-top: 1px solid #e5e7eb;">
                            {{ $event->location }}
                        </td>
                    </tr>
                    @if($event->speaker)
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;">Pemateri</td>
                        <td style="padding: 8px 0; color: #1f2937; font-size: 14px; text-align: right; border-top: 1px solid #e5e7eb;">
                            {{ $event->speaker }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;">Email</td>
                        <td style="padding: 8px 0; color: #1f2937; font-size: 14px; text-align: right; border-top: 1px solid #e5e7eb;">
                            {{ $participant->email }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;">Status</td>
                        <td style="padding: 8px 0; text-align: right; border-top: 1px solid #e5e7eb;">
                            <span style="background-color: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600;">
                                LUNAS
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center; margin-bottom: 24px;">
                <a href="{{ $ticketUrl }}" 
                   style="display: inline-block; background-color: #2563eb; color: #ffffff; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px;">
                    🎫 Lihat E-Tiket Saya
                </a>
            </div>

            <div style="background-color: #fef3c7; border: 1px solid #fcd34d; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.5;">
                    ⚠️ <strong>Penting:</strong> Tunjukkan kode tiket <strong>{{ $participant->trx_id }}</strong> atau QR Code di halaman e-tiket saat check-in di lokasi event.
                </p>
            </div>

            <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                Jika ada pertanyaan, silakan hubungi panitia.<br>
                Sampai jumpa di {{ $event->title }}!
            </p>
        </div>

        <div style="background-color: #1e293b; padding: 20px 24px; text-align: center;">
            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                © {{ date('Y') }} {{ config('app.name', 'EventFlow & Tixia') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
