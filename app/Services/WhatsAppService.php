<?php

namespace App\Services;

use App\Models\Participant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Kirim notifikasi konfirmasi e-tiket via WhatsApp.
     */
    public function sendTicketConfirmation(Participant $participant): bool
    {
        $phone = $participant->phone;
        $event = $participant->event;
        $ticketUrl = route('peserta.ticket', $event->slug);

        $message = "Halo *{$participant->name}*,\n\n"
            . "Terima kasih telah mendaftar di event *{$event->title}*.\n"
            . "Pembayaran Anda telah terkonfirmasi *LUNAS*.\n\n"
            . "Berikut rincian tiket Anda:\n"
            . "• *Kode Transaksi:* {$participant->trx_id}\n"
            . "• *Pemateri:* {$event->speaker}\n"
            . "• *Waktu:* {$event->time_slot}\n"
            . "• *Lokasi:* {$event->location}\n\n"
            . "Tunjukkan QR Code e-tiket Anda saat memasuki lokasi acara:\n"
            . "{$ticketUrl}\n\n"
            . "Sampai jumpa di lokasi acara!";

        return $this->sendMessage($phone, $message);
    }

    /**
     * Kirim pesan WhatsApp generic.
     */
    public function sendMessage(string $phone, string $message): bool
    {
        // Bersihkan format nomor HP (ubah ke format internasional 62)
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $apiKey = config('services.whatsapp.api_key');
        $endpoint = config('services.whatsapp.endpoint');

        // Jika API Key tidak diset, fallback ke logging (Mock Mode untuk dev/testing)
        if (empty($apiKey) || empty($endpoint)) {
            Log::info("WhatsApp Mock Send (To: {$phone}): \n{$message}");
            return true;
        }

        try {
            $response = Http::timeout(10)->post($endpoint, [
                'token' => $apiKey,
                'target' => $phone,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp message successfully sent to {$phone}");
                return true;
            }

            Log::error("WhatsApp Gateway returned error: " . $response->body());
            return false;
        } catch (\Throwable $e) {
            Log::error("WhatsApp Gateway connection failed: " . $e->getMessage());
            return false;
        }
    }
}
