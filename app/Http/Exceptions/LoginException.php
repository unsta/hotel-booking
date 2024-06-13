<?php

declare(strict_types=1);

namespace App\Http\Exceptions;

use Exception;
use Illuminate\Http\{JsonResponse, Response};

class LoginException extends Exception
{
    public function __construct()
    {
        parent::__construct('Incorrect email or password');
    }

    public function render(): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->getMessage()
        ], Response::HTTP_NOT_FOUND);
    }
}
