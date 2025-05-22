<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
    public function rules(): array
    {   
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        if (Auth::check() && Auth::user()->isAdmin()) {
            $rules['role'] = 'in:admin,user';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de usuario es obligatorio.',
            'email.required' => 'El Email es obligatorio.',
            'email.unique' => 'El Email ya esta en uso.',
            'email.email' => 'Direccion de email invalido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener por lo menos 6 caracteres.',
            'password.confirmed' => 'Confirmar contraseña. {"password_confirm": "tu_contraseña"}',
        ];
    }
}
