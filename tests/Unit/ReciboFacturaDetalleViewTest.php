<?php
namespace Tests\Unit;

use Tests\TestCase;
use Carbon\Carbon;

class ReciboFacturaDetalleViewTest extends TestCase
{
    public function test_recibo_factura_detalle_renders()
    {
        $pedido = new class {
            public $created_at;
            public $detalles;
            public $metodo_pago = 'tarjeta';
            public function __construct() { $this->created_at = Carbon::now(); $this->detalles = [(object)['producto' => (object)['nombre'=>'P1'],'cantidad'=>1,'precio'=>10.0]]; }
            public function getKey(){ return 1; }
        };

        $factura = new class {
            public $numero_factura = 'F-1';
            public $fecha_emision;
            public $cliente_nombre = 'C';
            public $cliente_email = 'c@example.test';
            public $cliente_direccion = null;
            public $cliente_identificacion = null;
            public $pedido;
            public $subtotal = 10.0;
            public $impuestos = 0.0;
            public $total = 10.0;
            public $estado_pedido = 'pendiente';
            public function __construct() { $this->fecha_emision = Carbon::now(); }
            public function getKey(){ return 1; }
        };

        $factura->pedido = $pedido;

        $output = view('web.recibo_factura_detalle', compact('factura'))->render();

        $this->assertStringContainsString('Factura', $output);
        $this->assertStringContainsString('P1', $output);
    }
}
