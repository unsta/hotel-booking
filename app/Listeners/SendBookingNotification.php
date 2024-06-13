<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\BookingNotifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendBookingNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;

        Mail::to('testreceiver@gmail.com')->send(new BookingNotifyEmail(
            $booking->id,
            $booking->room->number,
            $booking->customer->name,
            $booking->customer->email,
            $booking->customer->phone_number,
            $booking->check_in_date,
            $booking->check_out_date,
            (int) $booking->total_price
        ));
    }

    /**
     * Handle a job failure.
     */
    public function failed(BookingCreated $event, Throwable $exception): void
    {
        Log::error('[booking-created-email] ' . $exception->getMessage());
    }
}
