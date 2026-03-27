<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoEntregaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'departamento' => ['required', 'string', 'max:120'],
            'ciudad' => ['required', 'string', 'max:120'],
            'tipo_direccion' => ['required', 'string', 'max:40', 'in:calle,carrera,avenida,transversal,otro'],
            'calle' => ['required', 'string', 'max:120'],
            'numero' => ['required', 'string', 'max:40'],
            'barrio' => ['required', 'string', 'max:120'],
            'piso_apto' => ['nullable', 'string', 'max:80'],
            'nombre_recibe' => ['required', 'string', 'max:120'],
            // synthesized field used by the view; keep as fallback
            'direccion' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'departamento.required' => 'El departamento es obligatorio.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'tipo_direccion.required' => 'El tipo de dirección es obligatorio.',
            'tipo_direccion.in' => 'El tipo de dirección seleccionado no es válido.',
            'calle.required' => 'La calle es obligatoria.',
            'numero.required' => 'El número es obligatorio.',
            'barrio.required' => 'El barrio es obligatorio.',
            'nombre_recibe.required' => 'El nombre de la persona que recibe es obligatorio.',
            'direccion.max' => 'La dirección generada es demasiado larga.',
        ];
    }
}
