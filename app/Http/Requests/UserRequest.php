<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

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
        $routeUsuario = $this->route('usuario');
        $id = is_object($routeUsuario) ? $routeUsuario->getKey() : $routeUsuario;
        $isPerfil = $this->routeIs('perfil.*');

        $rules = [
            'name' => 'required|string|min:3|max:100|not_regex:/\d/',
            'email' => [
                'required',
                'email:rfc,dns',
                'max:100',
                Rule::unique('usuarios', 'email')->ignore(auth()->id(), 'usuario_id'),
            ],
            'password' => [$method === 'POST' ? 'required' : 'nullable', 'string', 'min:8', 'confirmed'],
            'activo' => ['required', 'boolean'],
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
        ];
        if (!$isPerfil) {
        $rules['activo'] = ['required', 'boolean'];
        $rules['role'] = ['required', 'string', Rule::exists('roles', 'name')];
    }

        // Campos opcionales que el formulario de perfil también puede enviar.
        $rules['telefono'] = 'nullable|string|max:20';
        $rules['documento_identidad'] = 'nullable|string|max:30';
        $rules['fecha_nacimiento'] = 'nullable|date|before_or_equal:today|after_or_equal:' . Carbon::today()->subYears(80)->format('Y-m-d');
        $rules['direccion'] = 'nullable|string|max:255';
        $rules['ciudad'] = 'nullable|string|max:120|not_regex:/\d/';
        $rules['pais'] = 'nullable|string|max:120|not_regex:/\d/';
        $rules['codigo_postal'] = 'nullable|string|max:20';
        $rules['avatar'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        $rules['avatar_crop_size'] = 'nullable|integer|min:' . config('avatar.crop_min', 100) . '|max:' . config('avatar.crop_max', 800);

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $name = (string) $this->input('name', '');
        $email = (string) $this->input('email', '');

        $this->merge([
            'name' => strip_tags(trim($name)),
            'email' => mb_strtolower(trim($email)),
            'activo' => $this->boolean('activo'),
            'role' => is_string($this->input('role')) ? trim($this->input('role')) : $this->input('role'),
        ]);
    }

    public function messages()
    {
        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede tener más de 100 caracteres.',
            'name.not_regex' => 'El nombre no puede contener números.',

            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'Debes ingresar un correo electrónico válido.',
            'email.max' => 'El correo electrónico no puede tener más de 100 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',

            'password.required' => 'La contraseña es obligatoria al crear un usuario.',
            'password.string' => 'La contraseña debe ser texto válido.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',

            'activo.required' => 'Debes seleccionar el estado del usuario.',
            'activo.boolean' => 'El estado seleccionado no es válido.',

            'role.required' => 'Debes seleccionar un rol para el usuario.',
            'role.exists' => 'El rol seleccionado no existe o no es válido.',

            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'documento_identidad.max' => 'El documento no puede tener más de 30 caracteres.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida.',
            'fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser posterior a hoy.',
            'fecha_nacimiento.after_or_equal' => 'La fecha de nacimiento no puede ser anterior a hace 80 años.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
            'direccion.not_regex' => 'La dirección no puede contener números.',
            'ciudad.max' => 'La ciudad no puede tener más de 120 caracteres.',
            'ciudad.not_regex' => 'La ciudad no puede contener números.',
            'pais.max' => 'El país no puede tener más de 120 caracteres.',
            'pais.not_regex' => 'El país no puede contener números.',
            'codigo_postal.max' => 'El código postal no puede tener más de 20 caracteres.',
        ];
        $messages['avatar_crop_size.integer'] = 'El tamaño de recorte debe ser un número entero.';
        $messages['avatar_crop_size.min'] = 'El tamaño de recorte debe ser al menos '.config('avatar.crop_min', 100).' px.';
        $messages['avatar_crop_size.max'] = 'El tamaño de recorte no puede exceder '.config('avatar.crop_max', 800).' px.';

        return $messages;
    }

}
