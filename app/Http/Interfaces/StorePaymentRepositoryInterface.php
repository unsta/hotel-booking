<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\{Booking, Payment};

interface StorePaymentRepositoryInterface
{
    public function getBooking(int $bookingId): Booking;

    /** @param array<mixed> $data */
    public function createPayment(array $data): Payment;
}
