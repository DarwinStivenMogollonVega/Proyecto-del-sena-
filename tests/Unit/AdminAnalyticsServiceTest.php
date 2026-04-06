<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_categories_contains_panel()
    {
        $svc = new \App\Services\AdminAnalyticsService();
        $cats = $svc->categories();

        $slugs = array_column($cats, 'slug');
        $this->assertContains('panel', $slugs);
    }

    public function test_proveedoresData_processes_rows()
    {
        $rows = collect([
            ['proveedor' => 'P1', 'total_productos' => 2, 'total_vendidos' => 10, 'ingresos' => 100.0, 'productos_top' => 'A (5)'],
            ['proveedor' => 'P2', 'total_productos' => 1, 'total_vendidos' => 5, 'ingresos' => 50.0, 'productos_top' => 'B (3)'],
        ]);

        $svc = Mockery::mock(\App\Services\AdminAnalyticsService::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $svc->shouldReceive('proveedoresAnalytics')->andReturn(['rows' => $rows]);

        $res = $svc->proveedoresData();

        $this->assertArrayHasKey('summary', $res);
        $this->assertEquals(2, $res['summary'][0]['value']); // total proveedores
        $this->assertCount(2, $res['rows']);
        $this->assertEquals('P1', $res['rows'][0]['proveedor']);
    }

    public function test_indexSummaryStats_formats_ingreso()
    {
        $stats = [
            'totalUsuarios' => 1,
            'usuariosActivos' => 1,
            'totalPedidos' => 2,
            'totalProductos' => 3,
            'ingresoTotal' => 123.45,
            'stockBajo' => 1,
            'productosSinStock' => 0,
            'stockTotalProductos' => 100,
            'totalProveedores' => 0,
            'totalProductosConProveedor' => 0,
            'totalVendidosProveedores' => 0,
            'totalCategorias' => 4,
            'totalCatalogos' => 5,
            'totalArtistas' => 6,
        ];

        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name')->nullable();
                $table->timestamps();
            });
        }

        DB::table('roles')->insert([
            'name' => 'cliente',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->bigIncrements('usuario_id');
                $table->string('nombre')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('model_has_roles')) {
            Schema::create('model_has_roles', function (Blueprint $table) {
                $table->bigInteger('role_id');
                $table->bigInteger('model_id');
                $table->string('model_type');
            });
        }

        if (!Schema::hasTable('pedidos')) {
            Schema::create('pedidos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('usuario_id')->nullable();
                $table->decimal('total', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        $svc = Mockery::mock(\App\Services\AdminAnalyticsService::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $svc->shouldReceive('dashboardStats')->andReturn($stats);

        $res = $svc->indexSummaryStats();

        $this->assertStringContainsString('$', $res['ventas'][3]['value']);
        $this->assertEquals($stats['totalProductos'], $res['productos'][0]['value']);
    }
}
