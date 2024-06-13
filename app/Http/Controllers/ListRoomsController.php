<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ListRoomsResource;
use App\Http\Services\ListRoomsService;
use App\Mail\BookingNotifyEmail;
use Illuminate\Support\Facades\Mail;

readonly class ListRoomsController
{
    public function __construct(public ListRoomsService $service)
    {
    }

    public function __invoke(): ListRoomsResource
    {
        return $this->service->getRooms();
    }
}
