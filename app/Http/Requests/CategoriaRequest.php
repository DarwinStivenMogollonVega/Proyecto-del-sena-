<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaRequest extends FormRequest
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
        $routeCategoria = $this->route('categorium') ?? $this->route('categoria');
        $id = is_object($routeCategoria) ? $routeCategoria->getKey() : $routeCategoria;

        return [
            'name' => ['required', 'string', 'min:3', 'max:100', Rule::unique('categorias', 'nombre')->ignore($id)],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => strip_tags(trim((string) $this->input('name', ''))),
            'description' => is_null($this->input('description')) ? null : trim((string) $this->input('description')),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.string' => 'El nombre de la categoría debe ser texto válido.',
            'name.min' => 'El nombre de la categoría debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre de la categoría no puede tener más de 100 caracteres.',
            'name.unique' => 'Ya existe una categoría con ese nombre.',

            'description.string' => 'La descripción de la categoría debe ser texto válido.',
            'description.max' => 'La descripción no puede tener más de 1000 caracteres.',
        ];
    }
}
