<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\URL;

class CheckoutReminderMail extends Mailable
{
    public $resumeUrl;
    public $mailSubject;
    public $mailView;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Order $order,
        string $subject,
        string $view
    ) {
        $this->resumeUrl = URL::signedRoute('checkout.resume', [
            'order' => $order->id,
        ], now()->addDays(14));
        $this->mailSubject = $subject;
        $this->mailView = $view;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->mailSubject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(markdown: $this->mailView);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}