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
        $method = $this->input('metodo_pago');

        $rules = [
            'metodo_pago' => ['required', 'string', 'max:30', Rule::in(['tarjeta', 'pse', 'nequi', 'efectivo'])],
            // comprobante obligatorio para todos los métodos de pago
            'comprobante_pago' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'requiere_factura_electronica' => ['nullable', 'boolean'],
            'tipo_documento' => ['required_if:requiere_factura_electronica,1', 'nullable', Rule::in(['nit', 'cedula'])],
            'numero_documento' => ['required_if:requiere_factura_electronica,1', 'nullable', 'digits_between:6,10'],
            'razon_social' => ['required_if:requiere_factura_electronica,1', 'nullable', 'string', 'max:140'],
            'correo_factura' => ['required_if:requiere_factura_electronica,1', 'nullable', 'email', 'max:120'],
        ];

        // Add rules only for the selected payment method to avoid validating unrelated fields
        switch ($method) {
            case 'tarjeta':
                $rules['tarjeta_numero'] = ['required', 'digits_between:13,19'];
                $rules['tarjeta_nombre'] = ['required', 'string', 'max:100', 'regex:/^[\p{L}\s]+$/u'];
                $rules['tarjeta_expira'] = ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'];
                $rules['tarjeta_cvv'] = ['required', 'digits_between:3,4'];
                break;
            case 'pse':
                $rules['pse_banco'] = ['required', 'string', 'max:120'];
                $rules['pse_cedula'] = ['required', 'digits_between:6,10'];
                break;
            case 'nequi':
                $rules['nequi_celular'] = ['required', 'digits:10'];
                break;
            case 'efectivo':
                $rules['efectivo_punto'] = ['required', Rule::in(['baloto', 'efecty'])];
                break;
            default:
                // no extra rules
                break;
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        // strip non-digits for numeric payment fields so rules like digits_between work
        $input = $this->all();
        if (isset($input['tarjeta_numero'])) {
            $input['tarjeta_numero'] = preg_replace('/\D+/', '', $input['tarjeta_numero']);
        }
        if (isset($input['tarjeta_cvv'])) {
            $input['tarjeta_cvv'] = preg_replace('/\D+/', '', $input['tarjeta_cvv']);
        }
        if (isset($input['pse_cedula'])) {
            $input['pse_cedula'] = preg_replace('/\D+/', '', $input['pse_cedula']);
        }
        if (isset($input['nequi_celular'])) {
            $input['nequi_celular'] = preg_replace('/\D+/', '', $input['nequi_celular']);
        }
        if (isset($input['numero_documento'])) {
            $input['numero_documento'] = preg_replace('/\D+/', '', $input['numero_documento']);
        }
        $this->merge($input);
    }

    public function messages(): array
    {
        return [
            'metodo_pago.required' => 'El método de pago es obligatorio.',
            'metodo_pago.in' => 'El método de pago seleccionado no es válido.',
            'comprobante_pago.image' => 'El comprobante debe ser una imagen válida.',
            'comprobante_pago.mimes' => 'El comprobante debe estar en formato JPG, PNG o WEBP.',
            'comprobante_pago.max' => 'El comprobante no puede exceder 4 MB.',
            'comprobante_pago.required' => 'El comprobante de pago es obligatorio para el método de pago seleccionado.',
            'tipo_documento.required_if' => 'El tipo de documento es obligatorio cuando se solicita factura.',
            'numero_documento.required_if' => 'El número de documento es obligatorio cuando se solicita factura.',
            'razon_social.required_if' => 'La razón social es obligatoria cuando se solicita factura.',
            'correo_factura.required_if' => 'El correo de facturación es obligatorio cuando se solicita factura.',

            'tarjeta_numero.required' => 'El número de tarjeta es obligatorio para pagos con tarjeta.',
            'tarjeta_numero.digits_between' => 'El número de tarjeta debe tener entre 13 y 19 dígitos.',
            'tarjeta_nombre.required' => 'El nombre en la tarjeta es obligatorio para pagos con tarjeta.',
            'tarjeta_nombre.regex' => 'El nombre en la tarjeta solo puede contener letras y espacios.',
            'tarjeta_expira.required' => 'La fecha de expiración es obligatoria para pagos con tarjeta.',
            'tarjeta_expira.regex' => 'La fecha de expiración debe tener el formato MM/AA.',
            'tarjeta_cvv.required' => 'El CVV es obligatorio para pagos con tarjeta.',
            'tarjeta_cvv.digits_between' => 'El CVV debe tener 3 o 4 dígitos.',

            'pse_banco.required' => 'El banco es obligatorio para pagos por PSE.',
            'pse_cedula.required' => 'La cédula del titular es obligatoria para pagos PSE.',
            'pse_cedula.digits_between' => 'La cédula debe tener entre 6 y 10 dígitos.',

            'nequi_celular.required' => 'El número Nequi es obligatorio para pagos por Nequi.',
            'nequi_celular.digits' => 'El número Nequi debe tener exactamente 10 dígitos.',

            'efectivo_punto.required' => 'Debes seleccionar un punto de pago para efectivo.',
            'efectivo_punto.in' => 'El punto de pago seleccionado no es válido.',
        ];
    }
}
