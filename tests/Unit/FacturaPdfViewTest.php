<?php
namespace Tests\Unit;

use Tests\TestCase;
use Carbon\Carbon;

class FacturaPdfViewTest extends TestCase
{
    public function test_factura_pdf_renders()
    {
        $pedido = new class {
            public $created_at;
            public $detalles;
            public function __construct() {
                $this->created_at = Carbon::now();
                $detalle = (object) ['producto' => (object)['nombre' => 'P1'], 'cantidad' => 1, 'precio' => 10.0];
                $this->detalles = [$detalle];
            }
            public function getKey(){ return 1; }
        };

        // create factura with explicit constructor to avoid relying on globals
        $factura = new class($pedido) {
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
            public $estado_pedido = 'enviado';
            public function __construct($p) { $this->fecha_emision = Carbon::now(); $this->pedido = $p; }
            public function getKey() { return 1; }
        };

        $output = view('web.factura_pdf', compact('factura'))->render();

        $this->assertStringContainsString('Factura', $output);
        $this->assertStringContainsString('P1', $output);
    }
}
