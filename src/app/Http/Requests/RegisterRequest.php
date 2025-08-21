<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        if ($this->phone_number) {
            $this->merge([
                'phone_number' => preg_replace('/\D/', '', $this->phone_number),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:30',
            'phone_number' => 'required|regex:/^\+?\d{10,15}$/',
        ];
    }
}
