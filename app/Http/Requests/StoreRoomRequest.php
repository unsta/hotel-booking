<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\{RoomStatus, RoomType};
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'number' => 'required|string|min:1|max:5|unique:rooms,number',
            'type' => ['required', 'string', 'lowercase', 'max:15', Rule::enum(RoomType::class)],
            'price_per_night' => 'required|integer|digits_between:3,8',
            'status' => ['required', 'string', 'lowercase', 'max:15', Rule::enum(RoomStatus::class)],
        ];
    }
}
