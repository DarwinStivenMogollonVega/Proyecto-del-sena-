<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\TestDbSetup;
use Illuminate\Support\Collection;

class HomeControllerTest extends TestCase
{
    use TestDbSetup;
    public function test_home_index_renders()
    {
        $this->ensureBasicTables();

        $metricas = ['totalProductos' => 0, 'disponibles' => 0, 'totalCategorias' => 1, 'totalCatalogos' => 1];
        $empty = new Collection();

        $output = view('web.index', [
            'metricas' => $metricas,
            'masMasVendidos' => $empty,
            'mejorValorados' => $empty,
            'ofertasEspeciales' => $empty,
            'disponiblesAhora' => $empty,
        ])->render();

        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }
}
