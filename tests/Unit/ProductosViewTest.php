<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\ProductStub;
use Tests\Support\TestDbSetup;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductosViewTest extends TestCase
{
    use TestDbSetup;
    public function test_productos_view_renders()
    {
        $this->ensureBasicTables();

        $prod = new ProductStub(1);
        $prod->categoria = (object)['nombre' => 'C1'];
        $prod->formato = (object)['nombre' => 'F1'];
        $prod->artista = (object)['nombre' => 'A1'];

        $items = [$prod];
        $paginator = new LengthAwarePaginator($items, 1, 10, 1);

        $metricas = ['totalProductos' => 1, 'disponibles' => 1, 'totalCategorias' => 1, 'totalCatalogos' => 1];

        $output = view('web.productos', ['productos' => $paginator, 'metricas' => $metricas])->render();

        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }
}
