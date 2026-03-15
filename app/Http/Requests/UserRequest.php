<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
        $method = $this->method();
        $id = $this->route('usuario') ?? Auth::id(); 
        
        $rules= [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id), // 👈 Correcto, todo en array
            ],
            'telefono' => 'nullable|string|max:20',
            'documento_identidad' => 'nullable|string|max:30',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:120',
            'pais' => 'nullable|string|max:120',
            'codigo_postal' => 'nullable|string|max:20',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        if ($method === 'POST') {
            $rules['password'] = 'required|min:8|confirmed'; // Requerido solo en POST (crear)
        } else if (in_array($method, ['PUT', 'PATCH'])) {
            $rules['password'] = 'nullable|min:8|confirmed'; // No obligatorio en PUT (editar)
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',

            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'documento_identidad.max' => 'El documento no puede tener más de 30 caracteres.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
            'ciudad.max' => 'La ciudad no puede tener más de 120 caracteres.',
            'pais.max' => 'El país no puede tener más de 120 caracteres.',
            'codigo_postal.max' => 'El código postal no puede tener más de 20 caracteres.',

            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ];
    }

}
