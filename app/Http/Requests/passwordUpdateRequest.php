<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class passwordUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password'          => ['required', 'string'],
            'new_password'          => ['required', 'string', Password::min(8), 'different:old_password', 'same:password_confirmation'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ];
    }
}
