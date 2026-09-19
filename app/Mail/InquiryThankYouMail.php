<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Inquiry $inquiry
    ) {}

    public function envelope(): Envelope
    {
        $typeName = $this->typeName();
        $ref = $this->inquiry->reference;

        return new Envelope(
            from: new Address(
                config('mail.from.address', 'connect@bridgeindiacapital.com'),
                config('mail.from.name', 'Bridge India Capital')
            ),
            replyTo: [
                new Address('connect@bridgeindiacapital.com', 'Bridge India Capital Advisory Team')
            ],
            subject: "Thank You for Contacting Bridge India Capital [Ref: {$ref}]",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry-thank-you',
            text: 'emails.inquiry-thank-you-text',
            with: [
                'inquiry' => $this->inquiry,
                'typeName' => $this->typeName(),
                'formattedDate' => $this->inquiry->created_at?->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A'),
            ],
        );
    }

    public function typeName(): string
    {
        return match ($this->inquiry->type) {
            'startup' => 'Startup Capital Application',
            'msme' => 'MSME Equity Inquiry',
            'investor' => 'Investor Introduction',
            'ma' => 'M&A / Strategic Transaction Inquiry',
            'contact' => 'Contact Message',
            default => ucfirst($this->inquiry->type) . ' Inquiry',
        };
    }
}
