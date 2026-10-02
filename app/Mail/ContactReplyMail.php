<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public Contact $contact;
    public string $balasan;

    /**
     * Membuat instance email baru.
     */
    public function __construct(Contact $contact, string $balasan)
    {
        $this->contact = $contact;
        $this->balasan = $balasan;
    }

    /**
     * Subject email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Balasan dari RentalKu - ' . $this->contact->subjek,
        );
    }

    /**
     * Isi email.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-reply',
        );
    }

    /**
     * Lampiran email.
     */
    public function attachments(): array
    {
        return [];
    }
}