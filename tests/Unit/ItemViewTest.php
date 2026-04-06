<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\ProductStub;
use Tests\Support\TestDbSetup;

class ItemViewTest extends TestCase
{
    use TestDbSetup;
    public function test_item_view_renders()
    {
        $this->ensureBasicTables();

        $prod = new ProductStub(2);
        $prod->categoria = (object)['nombre' => 'C1'];
        $prod->formato = (object)['nombre' => 'F1'];
        $prod->artista = (object)['nombre' => 'A1'];
        $prod->imagen = null;
        $prod->descripcion = 'Desc';

        $promedio = 4.5;
        $totalResenas = 0;
        $miResena = null;

        $rendered = view('web.item', [
            'producto' => $prod,
            'promedio' => $promedio,
            'totalResenas' => $totalResenas,
            'miResena' => $miResena,
        ])->render();

        $this->assertIsString($rendered);
        $this->assertNotEmpty($rendered);
    }
}
