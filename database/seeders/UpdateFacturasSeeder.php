<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Factura;

class UpdateFacturasSeeder extends Seeder
{
    public function run(): void
    {
        $facturas = Factura::whereNull('identificacion_cliente')->get();
        foreach ($facturas as $f) {
            $pedido = $f->pedido;
            $numero = $pedido->numero_documento ?? ($pedido->user->documento_identidad ?? null) ?? null;
            if ($numero) {
                $f->identificacion_cliente = $numero;
                $f->save();
            }
        }
    }
}
