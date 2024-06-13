<?php

declare(strict_types=1);

namespace App\Http\Exceptions;

use Exception;
use Illuminate\Http\{JsonResponse, Response};

class RoomAvailabilityException extends Exception
{
    public function __construct()
    {
        parent::__construct('The room is not available for the selected period');
    }

    public function render(): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->getMessage()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
