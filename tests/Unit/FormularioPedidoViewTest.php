<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\TestDbSetup;

class FormularioPedidoViewTest extends TestCase
{
    use TestDbSetup;
    public function test_formulario_pedido_view_renders()
    {
        $this->ensureBasicTables();

        $output = view('web.formulario_pedido', [])->render();

        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }
}
