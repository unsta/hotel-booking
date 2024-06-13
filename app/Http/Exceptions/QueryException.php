<?php

declare(strict_types=1);

namespace App\Http\Exceptions;

use Exception;
use Illuminate\Http\{JsonResponse, Response};

class QueryException extends Exception
{
    public function __construct(string $model)
    {
        parent::__construct("Unable to create record for model [{$model}]");
    }

    public function render(): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->getMessage()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
