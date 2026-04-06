<?php
namespace Tests\Unit;

use Tests\TestCase;
use Tests\Support\TestDbSetup;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class MisPedidosViewTest extends TestCase
{
    use TestDbSetup;
    public function test_mis_pedidos_view_renders()
    {
        $this->ensureBasicTables();

        if (!Schema::hasTable('pedidos')) {
            Schema::create('pedidos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('usuario_id')->nullable();
                $table->decimal('total', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        DB::table('pedidos')->insert(['usuario_id' => 1, 'total' => 50, 'created_at' => now(), 'updated_at' => now()]);

        $resumen = [
            'totalPedidos' => 1,
            'gastoTotal' => 50.00,
            'pendientes' => 0,
            'enviados' => 1,
            'cancelados' => 0,
            'conFactura' => 0,
        ];

        $texto = '';
        $registros = new LengthAwarePaginator([], 0, 10, 1);

        $output = view('web.mis_pedidos', compact('resumen', 'registros', 'texto'))->render();

        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }
}
