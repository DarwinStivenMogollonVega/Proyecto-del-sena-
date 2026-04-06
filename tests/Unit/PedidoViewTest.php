<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\TestDbSetup;

class PedidoViewTest extends TestCase
{
    use TestDbSetup;
    public function test_pedido_view_renders()
    {
        $this->ensureBasicTables();

        $carrito = collect([]);
        $datos = [];
        $entrega = null;
        $pago = [];

        $output = view('web.pedido', compact('carrito','datos','entrega','pago'))->render();

        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }
}
