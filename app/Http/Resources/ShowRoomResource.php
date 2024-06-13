<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Helpers\MoneyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ShowRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number' => $this->number,
            'type' => $this->type,
            'price_per_night' => $this->price_per_night,
            'status' => $this->status,
            'bookings' => ShowBookingResource::collection($this->bookings),
        ];
    }
}
