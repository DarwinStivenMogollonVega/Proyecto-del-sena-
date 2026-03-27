<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoDatosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            // allow plus, spaces, parentheses and dashes; enforce reasonable length
            'telefono' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s()\-]{7,30}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo no tiene un formato válido.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono contiene caracteres inválidos o es demasiado corto.',
        ];
    }
}
