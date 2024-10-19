<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Interfaces\ShowRoomServiceInterface;
use App\Http\Repositories\ShowRoomRepository;
use App\Http\Resources\ShowRoomResource;

readonly class ShowRoomService implements ShowRoomServiceInterface
{
    public function __construct(public ShowRoomRepository $repository)
    {
    }

    public function getRoom(int $roomId): ShowRoomResource
    {
        return $this->repository->getRoom($roomId);
    }
}
