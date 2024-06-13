<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:50',
            'email' => 'required|email:rfc|string|max:50|unique:customers,email',
            'phone_number' => 'required|string|regex:/^\+?[0-9]*$/|min:8|max:20',
        ];
    }
}
