<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PedidoPagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'metodo_pago' => ['required', 'string', 'max:30', Rule::in(['tarjeta', 'pse', 'nequi', 'efectivo'])],
            // comprobante opcional (ej. transferencia) — mantiene nullable
            'comprobante_pago' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'requiere_factura_electronica' => ['nullable', 'boolean'],
            'tipo_documento' => ['required_if:requiere_factura_electronica,1', 'nullable', Rule::in(['nit', 'cedula'])],
            'numero_documento' => ['required_if:requiere_factura_electronica,1', 'nullable', 'string', 'max:40'],
            'razon_social' => ['required_if:requiere_factura_electronica,1', 'nullable', 'string', 'max:140'],
            'correo_factura' => ['required_if:requiere_factura_electronica,1', 'nullable', 'email', 'max:120'],

            // Reglas específicas por método de pago
            // Tarjeta
            'tarjeta_numero' => ['required_if:metodo_pago,tarjeta', 'string', 'min:13', 'max:19', 'regex:/^[0-9\\s\\-]+$/'],
            'tarjeta_nombre' => ['required_if:metodo_pago,tarjeta', 'string', 'max:100'],
            'tarjeta_expira' => ['required_if:metodo_pago,tarjeta', 'string', 'regex:/^(0[1-9]|1[0-2])\\/\\d{2}$/'],
            'tarjeta_cvv' => ['required_if:metodo_pago,tarjeta', 'numeric', 'digits_between:3,4'],

            // PSE / transferencia
            'pse_banco' => ['required_if:metodo_pago,pse', 'string', 'max:120'],
            'pse_cedula' => ['required_if:metodo_pago,pse', 'string', 'max:40'],

            // Nequi
            'nequi_celular' => ['required_if:metodo_pago,nequi', 'string', 'regex:/^\\+?[0-9]{7,15}$/'],

            // Efectivo (puntos)
            'efectivo_punto' => ['required_if:metodo_pago,efectivo', 'nullable', Rule::in(['baloto', 'efecty'])],
        ];
    }

    public function messages(): array
    {
        return [
            'metodo_pago.required' => 'El método de pago es obligatorio.',
            'metodo_pago.in' => 'El método de pago seleccionado no es válido.',
            'comprobante_pago.image' => 'El comprobante debe ser una imagen válida.',
            'comprobante_pago.max' => 'El comprobante no puede exceder 4 MB.',
            'tipo_documento.required_if' => 'El tipo de documento es obligatorio cuando se solicita factura.',
            'numero_documento.required_if' => 'El número de documento es obligatorio cuando se solicita factura.',
            'razon_social.required_if' => 'La razón social es obligatoria cuando se solicita factura.',
            'correo_factura.required_if' => 'El correo de facturación es obligatorio cuando se solicita factura.',

            'tarjeta_numero.required_if' => 'El número de tarjeta es obligatorio para pagos con tarjeta.',
            'tarjeta_numero.regex' => 'El número de tarjeta contiene caracteres inválidos.',
            'tarjeta_nombre.required_if' => 'El nombre en la tarjeta es obligatorio para pagos con tarjeta.',
            'tarjeta_expira.required_if' => 'La fecha de expiración es obligatoria para pagos con tarjeta.',
            'tarjeta_expira.regex' => 'La fecha de expiración debe tener el formato MM/AA.',
            'tarjeta_cvv.required_if' => 'El CVV es obligatorio para pagos con tarjeta.',
            'tarjeta_cvv.digits_between' => 'El CVV debe tener 3 o 4 dígitos.',

            'pse_banco.required_if' => 'El banco es obligatorio para pagos por PSE.',
            'pse_cedula.required_if' => 'La cédula del titular es obligatoria para pagos PSE.',

            'nequi_celular.required_if' => 'El número Nequi es obligatorio para pagos por Nequi.',
            'nequi_celular.regex' => 'El número Nequi debe ser un teléfono válido (solo dígitos, opcional +).',

            'efectivo_punto.required_if' => 'Debes seleccionar un punto de pago para efectivo.',
            'efectivo_punto.in' => 'El punto de pago seleccionado no es válido.',
        ];
    }
}
