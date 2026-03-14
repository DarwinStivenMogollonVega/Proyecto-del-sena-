<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $id = $this->route('producto');

        $rules = [
            'codigo' => ['required', 'string', 'max:16', 'unique:productos,codigo,' . $id],
            'nombre' => ['required', 'string', 'max:100'],
            'precio' => ['required', 'numeric', 'min:0'],
            'cantidad' => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'catalogo_id' => ['nullable', 'exists:catalogos,id'],
            'proveedor_id' => ['nullable', 'exists:proveedores,id'],
            'artista_id' => ['nullable', 'exists:artistas,id'],
            'anio_lanzamiento' => ['nullable', 'integer', 'between:1900,2100'],
            'lista_canciones' => ['nullable', 'string', 'max:5000'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'imagen' => [$method === 'POST' ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
        return $rules;
    }
    public function messages(): array
    {
        return [
            'codigo.required' => 'El código del producto es obligatorio.',
            'codigo.unique' => 'Este código ya está registrado en otro producto.',
            'codigo.max' => 'El código no puede tener más de 50 caracteres.',

            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio no puede ser negativo.',

            'cantidad.required' => 'La cantidad en inventario es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un numero entero.',

            'categoria_id.required' => 'La categoria es obligatoria.',
            'categoria_id.exists' => 'La categoria seleccionada no es valida.',
            'catalogo_id.exists' => 'El catalogo seleccionado no es valido.',
            'proveedor_id.exists' => 'El proveedor seleccionado no es valido.',
            'artista_id.exists' => 'El artista seleccionado no es valido.',

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
