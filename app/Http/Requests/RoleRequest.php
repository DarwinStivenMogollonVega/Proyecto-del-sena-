<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $routeRole = $this->route('role');
        $roleId = is_object($routeRole) ? $routeRole->getKey() : $routeRole;

        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:80',
                'not_regex:/\d/',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['required', 'string', Rule::exists('permissions', 'name')],
        ];
    }

    protected function prepareForValidation(): void
    {
        $name = (string) $this->input('name', '');
        $permissions = $this->input('permissions', []);

        $permissions = is_array($permissions)
            ? array_values(array_unique(array_filter(array_map(
                fn ($permission) => is_string($permission) ? trim($permission) : null,
                $permissions
            ))))
            : [];

        $this->merge([
            'name' => strip_tags(trim($name)),
            'permissions' => $permissions,
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.string' => 'El nombre del rol debe ser texto.',
            'name.min' => 'El nombre del rol debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre del rol no puede tener más de 80 caracteres.',
            'name.not_regex' => 'El nombre del rol no puede contener números.',
            'name.unique' => 'Ese nombre de rol ya existe. Usa uno diferente.',

            'permissions.required' => 'Debes seleccionar al menos un permiso.',
            'permissions.array' => 'El formato de permisos enviado no es válido.',
            'permissions.min' => 'Debes seleccionar al menos un permiso.',
            'permissions.*.required' => 'Todos los permisos seleccionados deben ser válidos.',
            'permissions.*.exists' => 'Se detectó un permiso inválido en la selección.',
        ];
    }
}
