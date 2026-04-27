<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', Password::min(8)],
            'designation' => ['nullable', 'string', 'max:255'],
            'staff_id'    => ['nullable', 'string', 'max:255'],
            'roles'       => ['nullable', 'array'],
            'roles.*'     => ['integer', 'exists:roles,id'],
        ];
    }
}
