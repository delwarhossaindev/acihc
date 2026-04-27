<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $permissionId = $this->route('permission')?->id ?? $this->route('id');

        return [
            'name'         => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permissionId)],
            'display_name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'display_name')->ignore($permissionId)],
            'description'  => ['required', 'string'],
        ];
    }
}
