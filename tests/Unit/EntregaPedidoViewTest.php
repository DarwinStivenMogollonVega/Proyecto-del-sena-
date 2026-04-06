<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\TestDbSetup;

class EntregaPedidoViewTest extends TestCase
{
    use TestDbSetup;
    public function test_entrega_pedido_view_renders()
    {
        $this->ensureBasicTables();

        $output = view('web.entrega_pedido', [])->render();

        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }
}
