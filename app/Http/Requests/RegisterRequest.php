<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];
    }

    public function messages()
{
    return [
        'name.required' => 'Please enter your name.',
        'name.min' => 'Name must be at least 3 characters long.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'Email address already exists.',
        'password.required' => 'Please enter a password.',
        'password.min' => 'Password must be at least 6 characters long.',
        'password.confirmed' => 'Password confirmation does not match.',
    ];
}
}
