<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'room_id' => 'required|integer|exists:rooms,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'check_in_date' => 'required|string|date_format:Y-m-d|after:tomorrow|before:+1 year',
            'check_out_date' => 'required|string|date_format:Y-m-d|after:check_in_date|before:+1 year',
        ];
    }
}
