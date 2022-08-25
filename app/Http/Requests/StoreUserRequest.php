<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name'    => ['required', 'max:255'],
            'last_name'     => ['required', 'max:255'],
            'email'         => ['required', 'email', 'max:50'],
            'gender'        => ['nullable', 'string', 'max:20'],
            'street'        => ['nullable', 'string', 'max:255'],
            'building'      => ['nullable', 'string', 'max:255'],
            'number'        => ['nullable', 'string', 'max:10'],
            'postal_code'   => ['nullable', 'string', 'max:10'],
            'city'          => ['nullable', 'string', 'max:30'],
            'country'       => ['nullable', 'string', 'max:30'],
            'home_number'   => ['nullable', 'string', 'max:30'],
            'mobile_number' => ['nullable', 'string', 'max:30'],
            'work_number'   => ['nullable', 'string', 'max:30'],
            'comments'      => ['nullable', 'string', 'max:65000'],
            'is_admin'      => ['nullable', 'boolean'],
            'password'      => ['required', 'confirmed', Password::defaults()],
            'department_id' => ['nullable', Rule::exists('departments', 'id')->withoutTrashed()],
        ];
    }
}
