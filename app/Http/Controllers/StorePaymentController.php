<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Services\StorePaymentService;
use Illuminate\Http\JsonResponse;

readonly class StorePaymentController
{
    public function __construct(public StorePaymentService $service)
    {
    }

    public function __invoke(StorePaymentRequest $request): JsonResponse
    {
        $payment = $this->service->createPayment($request->booking_id, $request->amount);

        return response()->json([
            'status' => 'success',
            'message' => sprintf('Payment #%d was successfully created', $payment->id)
        ]);
    }
}
