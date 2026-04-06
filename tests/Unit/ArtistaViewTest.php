<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\ProductStub;
use Tests\Support\TestDbSetup;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ViewErrorBag;

class ArtistaViewTest extends TestCase
{
    use TestDbSetup;
    public function test_artista_view_renders()
    {
        $this->ensureBasicTables();

        $artista = (object)['nombre' => 'A1', 'foto' => null, 'biografia' => null, 'getKey' => function(){return 1;}];

        $prod = new ProductStub(4);
        $prod->categoria = (object)['nombre'=>'C'];
        $prod->formato = (object)['nombre'=>'F'];
        $items = [$prod];
        $productos = new LengthAwarePaginator($items, 1, 10, 1);

        view()->share('errors', new ViewErrorBag());

        $output = view('web.artista', compact('artista','productos'))->render();

        $this->assertStringContainsString('Productos del artista', $output);
    }
}
