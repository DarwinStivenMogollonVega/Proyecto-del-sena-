<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductoRequest extends FormRequest
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
        $routeProducto = $this->route('producto');
        $id = is_object($routeProducto) ? $routeProducto->getKey() : $routeProducto;

        $rules = [
            'codigo' => ['required', 'string', 'max:16', Rule::unique('productos', 'codigo')->ignore($id), 'regex:/^[A-Za-z0-9_-]+$/'],
            'nombre' => ['required', 'string', 'min:3', 'max:100', 'not_regex:/\\d/'],
            'precio' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'cantidad' => ['required', 'integer', 'regex:/^\d+$/', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'album_id' => ['nullable', 'exists:albums,album_id'],
            'formato_id' => ['required', 'exists:formatos,formato_id'],
            'proveedor_id' => ['required', 'exists:proveedores,proveedor_id'],
            'artista_id' => ['required', 'exists:artistas,artista_id'],
            'anio_lanzamiento' => ['nullable', 'integer', 'regex:/^\d+$/', 'between:1900,2100'],
            'lista_canciones' => ['nullable', 'string', 'max:5000'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'imagen' => [$method === 'POST' ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'codigo' => strtoupper(trim((string) $this->input('codigo', ''))),
            'nombre' => strip_tags(trim((string) $this->input('nombre', ''))),
            'descripcion' => is_null($this->input('descripcion')) ? null : trim((string) $this->input('descripcion')),
            'lista_canciones' => is_null($this->input('lista_canciones')) ? null : trim((string) $this->input('lista_canciones')),
        ]);
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código del producto es obligatorio.',
            'codigo.unique' => 'Este código ya está registrado en otro producto.',
            'codigo.max' => 'El código no puede tener más de 16 caracteres.',
            'codigo.regex' => 'El código solo puede contener letras, números, guiones y guiones bajos (sin espacios ni caracteres especiales).',

            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'nombre.not_regex' => 'El nombre del producto no puede contener números.',

            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.regex' => 'El precio solo permite números y hasta 2 decimales.',
            'precio.min' => 'El precio no puede ser negativo.',

            'cantidad.required' => 'La cantidad en inventario es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un numero entero.',
            'cantidad.regex' => 'La cantidad solo permite números enteros sin letras.',
            'cantidad.min' => 'La cantidad no puede ser negativa.',

            'categoria_id.required' => 'Debes seleccionar una categoría para el producto.',
            'categoria_id.exists' => 'La categoría seleccionada no existe o ya no está disponible.',
            'formato_id.required' => 'Debes seleccionar un formato para el producto.',
            'formato_id.exists' => 'El formato seleccionado no existe o ya no está disponible.',
            'proveedor_id.required' => 'Debes seleccionar un proveedor para el producto.',
            'proveedor_id.exists' => 'El proveedor seleccionado no existe o ya no está disponible.',
            'artista_id.required' => 'Debes seleccionar un artista para el producto.',
            'artista_id.exists' => 'El artista seleccionado no existe o ya no está disponible.',

            'anio_lanzamiento.integer' => 'El año de lanzamiento debe ser un número entero.',
            'anio_lanzamiento.regex' => 'El año de lanzamiento no puede contener letras.',
            'anio_lanzamiento.between' => 'El año de lanzamiento debe estar entre 1900 y 2100.',
            'lista_canciones.max' => 'La lista de canciones no puede superar 5000 caracteres.',

            'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',

            'imagen.required' => 'La imagen del producto es obligatoria.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo JPG o PNG.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
        ];
    }
}
