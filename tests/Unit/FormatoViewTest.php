<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\ProductStub;
use Tests\Support\TestDbSetup;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ViewErrorBag;

class FormatoViewTest extends TestCase
{
    use TestDbSetup;
    public function test_formato_view_renders()
    {
        $this->ensureBasicTables();

        $formato = (object)['nombre' => 'Vinilo', 'getKey' => function(){return 1;}];

        $prod = new ProductStub(3);
        $prod->categoria = (object)['nombre'=>'C'];
        $prod->formato = (object)['nombre'=>'F1'];
        $items = [$prod];
        $productos = new LengthAwarePaginator($items, 1, 10, 1);

        view()->share('errors', new ViewErrorBag());

        $output = view('web.formato', compact('formato','productos'))->render();

        $this->assertStringContainsString('Productos del formato', $output);
    }
}
