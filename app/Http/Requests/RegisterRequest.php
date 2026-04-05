<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // allow digits at rule level; enforce conditional digit policy in withValidator()
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email:rfc,dns', 'max:100', Rule::unique('usuarios', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function withValidator(ValidatorContract $validator): void
    {
        $validator->after(function ($validator) {
            $name = trim((string) $this->input('name', ''));
            if ($name === '') return;

            // Count words (non-empty tokens separated by whitespace)
            $words = preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);
            $wordCount = is_array($words) ? count($words) : 0;

            // If the name contains any digit but has fewer than 5 words, it's invalid
            if (preg_match('/\\d/', $name) && $wordCount < 5) {
                $validator->errors()->add('name', 'El nombre no puede contener números a menos que tenga al menos 5 palabras.');
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => strip_tags(trim((string) $this->input('name', ''))),
            'email' => mb_strtolower(trim((string) $this->input('email', ''))),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede tener más de 100 caracteres.',
            'name.not_regex' => 'El nombre no puede contener números.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes ingresar un correo válido.',
            'email.max' => 'El correo no puede tener más de 100 caracteres.',
            'email.unique' => 'Este correo ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser texto válido.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}