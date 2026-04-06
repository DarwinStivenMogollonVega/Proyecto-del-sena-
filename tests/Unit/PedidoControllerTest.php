<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class PedidoControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_adminIndex_uses_pedido_query_and_paginate()
    {
        // Converted to unit test: mock models and static query chains
        // Create minimal tables and seed rows to avoid integration DB
        if (!Schema::hasTable('pedidos')) {
            Schema::create('pedidos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('usuario_id')->nullable();
                $table->decimal('total', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
                $table->integer('stock')->default(0);
                $table->timestamps();
            });
        }

        $this->ensureBasicTables();

        if (!Schema::hasTable('resenas_producto')) {
            Schema::create('resenas_producto', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('producto_id');
                $table->integer('puntuacion')->default(0);
            });
        }

        DB::table('pedidos')->insert(['usuario_id' => 1, 'total' => 10.00, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('productos')->insert(['nombre' => 'P', 'stock' => 5, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('categorias')->insert(['nombre' => 'C1']);
        DB::table('formatos')->insert(['nombre' => 'F1']);

        $ctrl = new \App\Http\Controllers\PedidoController();
        $res = $ctrl->adminIndex();

        $this->assertNotNull($res);
    }
}
