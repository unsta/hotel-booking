<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\Payment;

interface StorePaymentServiceInterface
{
    public function createPayment(int $bookingId, int $amount): Payment;

    public function getPaymentStatus(int $bookingId, int $amount): string;
}
