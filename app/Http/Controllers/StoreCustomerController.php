<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Services\StoreCustomerService;
use Illuminate\Http\JsonResponse;

readonly class StoreCustomerController
{
    public function __construct(public StoreCustomerService $service)
    {
    }

    public function __invoke(StoreCustomerRequest $request): JsonResponse
    {
        $customer = $this->service->createCustomer($request->name, $request->email, $request->phone_number);

        return response()->json([
            'status' => 'success',
            'message' => sprintf('User [%s] was successfully created', $customer->name)
        ]);
    }
}
