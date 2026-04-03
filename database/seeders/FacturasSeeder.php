<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\Factura;
use Carbon\Carbon;

class FacturasSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar pedidos pagados que no tengan factura
        $pedidos = Pedido::where('estado', 'pagado')->get();
        foreach ($pedidos as $pedido) {
            // Skip if factura already exists
            if ($pedido->factura) {
                continue;
            }

            $subtotal = 0.0;
            foreach ($pedido->detalles as $det) {
                $subtotal += ((float) $det->precio) * ((int) $det->cantidad);
            }

            $impuestos = round(floatval(env('FACTURA_IMPUESTO_RATE', 0.19)) * $subtotal, 2);
            $total = round($subtotal + $impuestos, 2);

            // Generar número de factura único sencillo
            $numero = 'FAC-' . Carbon::now()->format('Ymd') . '-' . strtoupper(substr(md5($pedido->id . microtime(true)), 0, 6));

            $numeroDocumento = $pedido->numero_documento ?? ($pedido->user->documento_identidad ?? null) ?? ($pedido->identificacion_cliente ?? null);

            Factura::firstOrCreate([
                'pedido_id' => $pedido->id ?? $pedido->getKey(),
            ], [
                'usuario_id' => $pedido->usuario_id ?? null,
                'numero_factura' => $numero,
                'fecha_emision' => Carbon::now(),
                'estado_pedido' => $pedido->estado,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'nombre_cliente' => $pedido->nombre,
                'correo_cliente' => $pedido->email,
                'telefono_cliente' => $pedido->telefono,
                'direccion_cliente' => $pedido->direccion,
                'identificacion_cliente' => $numeroDocumento,
            ]);
        }
    }
}
