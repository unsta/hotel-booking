<?php

namespace App\Mail;

use App\Helpers\MoneyHelper;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Money\Money;

class BookingNotifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private string $bookingId,
        private string $roomNumber,
        private string $customerName,
        private string $customerEmail,
        private string $customerPhoneNumber,
        private string $checkInDate,
        private string $checkOutDate,
        private int $totalPrice
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('hotel-booking@example.com', 'HB'),
            subject: 'New Booking for Room ' . $this->roomNumber,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.booking_created',
            with: [
                'bookingId' => $this->bookingId,
                'roomNumber' => $this->roomNumber,
                'customerName' => $this->customerName,
                'customerEmail' => $this->customerEmail,
                'customerPhoneNumber' => $this->customerPhoneNumber,
                'checkInDate' => (new CarbonImmutable($this->checkInDate))->format('Y-m-d'),
                'checkOutDate' => (new CarbonImmutable($this->checkOutDate))->format('Y-m-d'),
                'totalPrice' => MoneyHelper::formatDecimal(Money::EUR($this->totalPrice)),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
