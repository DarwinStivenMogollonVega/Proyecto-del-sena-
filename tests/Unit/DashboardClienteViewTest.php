<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\ViewErrorBag;

class DashboardClienteViewTest extends TestCase
{
    public function test_dashboard_cliente_renders()
    {
        $resumen = [
            'totalPedidos' => 0,
            'gastoTotal' => 0,
            'totalUnidadesCompradas' => 0,
            'itemsCarrito' => 0,
            'totalCarrito' => 0,
            'recibosFactura' => 0,
            'pedidosPendientes' => 0,
            'pedidosEnviados' => 0,
            'pedidosCancelados' => 0,
        ];

        $ultimosPedidos = collect([]);
        $productosFrecuentes = collect([]);
        $categoriasInteres = collect([]);

        view()->share('errors', new ViewErrorBag());

        $output = view('web.dashboard_cliente', compact('resumen','ultimosPedidos','productosFrecuentes','categoriasInteres'))->render();

        $this->assertStringContainsString('Mi dashboard', $output);
    }
}
