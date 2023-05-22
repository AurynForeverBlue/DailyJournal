<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateUserRequest extends FormRequest
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
            'username' => [
                'required',
                'min:3',
            ],
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
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
            'username.required' => 'Username is required',
            'username.min:3' => 'Username or password is incorrect',
            
            'password.required' => 'Password is required',
            'password.regex:/[a-z]/' => 'Username or password is incorrect',
            'password.regex:/[A-Z]/' => 'Username or password is incorrect',
            'password.regex:/[0-9]/' => 'Username or password is incorrect',
            'password.regex:/[@$!%*#?&]/' => 'Username or password is incorrect',
        ];
    }
}
