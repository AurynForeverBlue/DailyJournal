<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'password' => [
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/', 
                'confirmed',
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.regex:/[a-z]/' => 'Password must comtain at least one lowercase letter',
            'password.regex:/[A-Z]/' => 'Password must comtain at least one uppercase letter',
            'password.regex:/[0-9]/' => 'Password must comtain at least one digit',
            'password.regex:/[@$!%*#?&]/' => 'Password must comtain at least one special character',
            'password.confirmed' => 'Password check does not match'
        ];
    }
}
