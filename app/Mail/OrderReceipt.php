<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceipt extends Mailable
{
    use Queueable, SerializesModels;

    // We pass the Order model in so the email knows the ticket number
    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Q-Less Campus: Your Ticket is ' . $this->order->queue_number,
        );
    }

    public function content(): Content
    {
        // This points directly to the HTML file we just created
        return new Content(
            view: 'emails.receipt',
        );
    }
}