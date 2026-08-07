<?php

namespace App\Jobs;

use App\Mail\TicketConfirmationMail;
use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

    public function handle(): void
    {
        $mail = new TicketConfirmationMail($this->participant, $this->participant->event);

        Mail::to($this->participant->email)
            ->send($mail);
    }
}
