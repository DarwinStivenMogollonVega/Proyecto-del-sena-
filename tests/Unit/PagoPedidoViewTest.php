<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\TestDbSetup;

class PagoPedidoViewTest extends TestCase
{
    use TestDbSetup;
    public function test_pago_pedido_view_renders()
    {
        // Ensure the basic tables / seeds and shared view variables exist
        $this->ensureBasicTables();

        $carrito = collect([]);
        $datos = [];
        $entrega = null;
        $pago = [];

        $initialObLevel = ob_get_level();

        try {
            $output = view('web.pago_pedido', compact('carrito', 'datos', 'entrega', 'pago'))->render();

            $this->assertIsString($output);
            $this->assertNotEmpty($output);
        } finally {
            // Close only the output buffers opened during this test to avoid touching PHPUnit's buffers
            while (ob_get_level() > $initialObLevel) {
                @ob_end_clean();
            }
        }
    }
}
