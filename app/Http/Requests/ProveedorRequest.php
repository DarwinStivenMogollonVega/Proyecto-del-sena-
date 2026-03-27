<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $routeProveedor = $this->route('proveedore') ?? $this->route('proveedor');
        $proveedorId = is_object($routeProveedor) ? $routeProveedor->getKey() : $routeProveedor;

        return [
            'nombre' => ['required', 'string', 'min:3', 'max:120', Rule::unique('proveedores', 'nombre')->ignore($proveedorId, 'proveedor_id')],
            'contacto' => ['nullable', 'string', 'min:3', 'max:120'],
            'telefono' => ['nullable', 'string', 'max:40', 'regex:/^[0-9+\-\s()]+$/'],
            'email' => ['nullable', 'email:rfc,dns', 'max:120'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => strip_tags(trim((string) $this->input('nombre', ''))),
            'contacto' => is_null($this->input('contacto')) ? null : trim((string) $this->input('contacto')),
            'telefono' => is_null($this->input('telefono')) ? null : trim((string) $this->input('telefono')),
            'email' => is_null($this->input('email')) ? null : mb_strtolower(trim((string) $this->input('email'))),
            'direccion' => is_null($this->input('direccion')) ? null : trim((string) $this->input('direccion')),
            'descripcion' => is_null($this->input('descripcion')) ? null : trim((string) $this->input('descripcion')),
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del proveedor es obligatorio.',
            'nombre.string' => 'El nombre del proveedor debe ser texto válido.',
            'nombre.min' => 'El nombre del proveedor debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre del proveedor no puede superar 120 caracteres.',
            'nombre.unique' => 'Ya existe un proveedor con ese nombre.',

            'contacto.string' => 'El contacto debe ser texto válido.',
            'contacto.min' => 'El contacto debe tener al menos 3 caracteres.',
            'contacto.max' => 'El contacto no puede superar 120 caracteres.',

            'telefono.string' => 'El teléfono debe ser texto válido.',
            'telefono.max' => 'El teléfono no puede superar 40 caracteres.',
            'telefono.regex' => 'El teléfono solo permite números, espacios, paréntesis, "+" y "-".',

            'email.email' => 'El correo electrónico del proveedor no tiene un formato válido.',
            'email.max' => 'El correo electrónico no puede superar 120 caracteres.',

            'direccion.string' => 'La dirección debe ser texto válido.',
            'direccion.max' => 'La dirección no puede superar 255 caracteres.',

            'descripcion.string' => 'La descripción debe ser texto válido.',
            'descripcion.max' => 'La descripción no puede superar 1000 caracteres.',

            'activo.boolean' => 'El estado activo/inactivo enviado no es válido.',
        ];
    }
}
