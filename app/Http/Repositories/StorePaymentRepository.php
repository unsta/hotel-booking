<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Http\Exceptions\QueryException;
use App\Models\Booking;
use App\Models\Payment;

class StorePaymentRepository
{
    public function __construct()
    {
    }

    public function getBooking(int $bookingId): Booking
    {
        // @phpstan-ignore-next-line
        return Booking::find($bookingId);
    }

    /**
     * @param array<mixed> $data
     */
    public function createPayment(array $data): Payment
    {
        $payment = Payment::create($data);

        if (! $payment instanceof Payment) {
            throw new QueryException(Payment::class);
        }

        return $payment;
    }
}
