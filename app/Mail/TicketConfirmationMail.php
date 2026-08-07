<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Participant $participant,
        public Event $event
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address', 'noreply@eventflow.id'),
                config('mail.from.name', config('app.name', 'EventFlow & Tixia'))
            ),
            subject: "E-Tiket {$this->event->title} - Kode: {$this->participant->trx_id}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-confirmation',
            with: [
                'participant' => $this->participant,
                'event' => $this->event,
                'ticketUrl' => route('peserta.ticket', $this->event),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
