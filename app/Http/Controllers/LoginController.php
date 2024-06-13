<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Services\LoginService;
use Illuminate\Http\JsonResponse;

readonly class LoginController
{
    public function __construct(public LoginService $service)
    {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'token' => $this->service->createToken($request->email, $request->password),
        ]);
    }
}
