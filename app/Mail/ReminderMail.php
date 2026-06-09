<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $tenantName,
        public string $roomNumber,
        public string $amount,
        public string $dueDate,
        public string $type,
        public string $template,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder Pembayaran Sewa - e-Kost',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reminder',
        );
    }
}