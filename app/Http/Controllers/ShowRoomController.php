<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ShowRoomResource;
use App\Http\Services\ShowRoomService;

readonly class ShowRoomController
{
    public function __construct(public ShowRoomService $service)
    {
    }

    public function __invoke(int $roomId): ShowRoomResource
    {
        return $this->service->getRoom($roomId);
    }
}
