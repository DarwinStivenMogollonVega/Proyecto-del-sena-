<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\ProductStub;
use Tests\Support\TestDbSetup;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoriaViewTest extends TestCase
{
    use TestDbSetup;
    public function test_categoria_view_renders()
    {
        $this->ensureBasicTables();

        $categoria = new class {
            public $nombre = 'C1';
            public function getKey() { return 1; }
        };

        $prod = new ProductStub(5);
        $prod->categoria = (object)['nombre'=>'C1'];
        $items = [$prod];
        $productos = new LengthAwarePaginator($items, 1, 10, 1);

        $output = view('web.categoria', compact('categoria','productos'))->render();

        $this->assertStringContainsString('Productos de la categoría', $output);
    }
}
