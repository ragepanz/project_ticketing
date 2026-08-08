<?php

namespace App\Jobs;

use App\Mail\TicketConfirmationMail;
use App\Models\Participant;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTicketEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 300, 900];
    public $timeout = 120;

    public function __construct(
        public Participant $participant
    ) {}

    public function handle(WhatsAppService $whatsAppService): void
    {
         try {
            $mail = new TicketConfirmationMail($this->participant, $this->participant->event);
            Mail::to($this->participant->email)->send($mail);
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email tiket ke ' . $this->participant->email . ': ' . $e->getMessage());
        }

        try {
            $whatsAppService->sendTicketConfirmation($this->participant);
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim WhatsApp tiket ke ' . $this->participant->phone . ': ' . $e->getMessage());
        }
    }
}
