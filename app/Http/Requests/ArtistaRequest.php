<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArtistaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Permissions are enforced in controllers; allow request here.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $routeArtista = $this->route('artista') ?? $this->route('id');
        $artistaId = is_object($routeArtista) ? $routeArtista->getKey() : $routeArtista;

        $rules = [
            'nombre' => ['required', 'string', 'min:3', 'max:120', 'regex:/^[\pL\s\-\.]+$/u'],
            'biografia' => ['nullable', 'string', 'max:5000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        if ($this->isMethod('post')) {
            $rules['identificador_unico'] = ['nullable', 'string', 'max:140', 'regex:/^[a-zA-Z0-9\-_]+$/', 'unique:artistas,identificador_unico'];
        } else {
            $rules['identificador_unico'] = [
                'nullable',
                'string',
                'max:140',
                'regex:/^[a-zA-Z0-9\-_]+$/',
                Rule::unique('artistas', 'identificador_unico')->ignore($artistaId, 'artista_id'),
            ];
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => strip_tags(trim((string) $this->input('nombre', ''))),
            'biografia' => is_null($this->input('biografia')) ? null : trim((string) $this->input('biografia')),
            'identificador_unico' => is_null($this->input('identificador_unico'))
                ? null
                : trim((string) $this->input('identificador_unico')),
        ]);
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del artista es obligatorio.',
            'nombre.string' => 'El nombre del artista debe ser texto.',
            'nombre.min' => 'El nombre del artista debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre del artista no puede superar los 120 caracteres.',
            'nombre.regex' => 'El nombre del artista solo permite letras, espacios, guiones y puntos.',

            'biografia.string' => 'La biografía debe ser texto válido.',
            'biografia.max' => 'La biografía no puede superar los 5000 caracteres.',

            'foto.image' => 'La fotografía debe ser una imagen válida.',
            'foto.mimes' => 'La fotografía debe estar en formato JPG, JPEG, PNG o WEBP.',
            'foto.max' => 'La fotografía no debe pesar más de 2MB.',

            'identificador_unico.string' => 'El identificador único debe ser texto válido.',
            'identificador_unico.max' => 'El identificador único no puede superar los 140 caracteres.',
            'identificador_unico.regex' => 'El identificador único solo permite letras, números, guiones y guion bajo.',
            'identificador_unico.unique' => 'El identificador único ya existe. Debes usar uno diferente.',
        ];
    }
}
