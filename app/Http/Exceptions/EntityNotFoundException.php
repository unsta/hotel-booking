<?php

declare(strict_types=1);

namespace App\Http\Exceptions;

use Exception;
use Illuminate\Http\{JsonResponse, Response};

class EntityNotFoundException extends Exception
{
    public function __construct(string $model)
    {
        parent::__construct("No query results for model [{$model}]");
    }

    public function render(): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->getMessage()
        ], Response::HTTP_NOT_FOUND);
    }
}
