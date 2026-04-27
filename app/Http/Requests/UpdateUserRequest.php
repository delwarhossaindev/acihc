<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? $this->route('id');

        return [
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password'    => ['nullable', 'string', Password::min(8)],
            'designation' => ['nullable', 'string', 'max:255'],
            'staff_id'    => ['nullable', 'string', 'max:255'],
            'status'      => ['nullable', 'in:0,1'],
            'roles'       => ['nullable', 'array'],
            'roles.*'     => ['integer', 'exists:roles,id'],
        ];
    }
}
