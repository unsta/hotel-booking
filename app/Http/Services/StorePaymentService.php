<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Enums\PaymentStatus;
use App\Http\Repositories\StorePaymentRepository;
use App\Models\Payment;
use Carbon\CarbonImmutable;
use Money\Money;

readonly class StorePaymentService
{
    public function __construct(public StorePaymentRepository $repository)
    {
    }

    public function createPayment(int $bookingId, int $amount): Payment
    {
        $data = [
            'booking_id' => $bookingId,
            'amount' => $amount,
            'payment_date' => CarbonImmutable::now(),
            'status' => $this->getPaymentStatus($bookingId, $amount),
        ];

        return $this->repository->createPayment($data);
    }

    public function getPaymentStatus(int $bookingId, int $amount): string
    {
        $booking = $this->repository->getBooking($bookingId);

        $bookingTotalPrice = Money::EUR($booking->total_price);
        $paymentAmount = Money::EUR($amount);

        $isFullPayment = (int) $bookingTotalPrice->subtract($paymentAmount)->getAmount();

        return 0 === $isFullPayment ? PaymentStatus::COMPLETE->value : PaymentStatus::PENDING->value;
    }
}
