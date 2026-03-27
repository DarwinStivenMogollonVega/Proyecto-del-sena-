<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CatalogoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para la solicitud.
     */
    public function rules(): array
    {
        $routeCatalogo = $this->route('catalogo');
        $id = is_object($routeCatalogo) ? $routeCatalogo->getKey() : $routeCatalogo;

        return [
            'nombre' => ['required', 'string', 'min:3', 'max:150', Rule::unique('catalogos', 'nombre')->ignore($id, 'catalogo_id')],
            'descripcion' => ['nullable', 'string', 'max:1000'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => strip_tags(trim((string) $this->input('nombre', ''))),
            'descripcion' => is_null($this->input('descripcion')) ? null : trim((string) $this->input('descripcion')),
        ]);
    }

    /**
     * Mensajes personalizados para los errores de validación.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del catálogo es obligatorio.',
            'nombre.string' => 'El nombre del catálogo debe ser texto válido.',
            'nombre.min' => 'El nombre del catálogo debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 150 caracteres.',
            'nombre.unique' => 'Ya existe un catálogo con ese nombre.',
            'descripcion.string' => 'La descripción del catálogo debe ser texto válido.',
            'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',
        ];
    }
}
