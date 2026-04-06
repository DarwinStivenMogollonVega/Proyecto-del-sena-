<?php
namespace Tests\Unit;

use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class RecibosFacturaViewTest extends TestCase
{
    public function test_recibos_factura_renders()
    {
        $reg = new class {
            public $numero_factura = 'F-1';
            public $pedido;
            public $fecha_emision;
            public $estado_pedido = 'enviado';
            public $cliente_nombre = 'C';
            public $cliente_email = 'c@example.test';
            public $total = 10.0;
            public function __construct() { $this->pedido = new class { public function getKey(){return 1;} }; $this->fecha_emision = Carbon::now(); }
        };

        $registros = new LengthAwarePaginator([$reg], 1, 10, 1);
        $resumen = ['totalRecibos' => 1, 'montoFacturado' => 10.0];
        $texto = '';

        $output = view('web.recibos_factura', compact('registros','resumen','texto'))->render();

        $this->assertStringContainsString('Historial de facturas', $output);
        $this->assertStringContainsString('F-1', $output);
    }
}
