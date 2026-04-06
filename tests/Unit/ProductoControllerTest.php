<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class ProductoControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_lists_products()
    {
        $user = Mockery::mock();
        $user->shouldReceive('can')->with('producto-list')->andReturn(true);

        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function () use ($user) { return function () use ($user) { return $user; }; });
        \Illuminate\Support\Facades\Gate::shouldReceive('authorize')->andReturn(true);

        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
                $table->string('codigo')->nullable();
                $table->integer('categoria_id')->nullable();
                $table->timestamps();
            });
        }

        DB::table('productos')->insert(['nombre' => 'Prod A', 'codigo' => 'A1', 'categoria_id' => null, 'created_at' => now(), 'updated_at' => now()]);

        $ctrl = new \App\Http\Controllers\ProductoController();
        $req = Request::create('/productos', 'GET');

        $res = $ctrl->index($req);

        $this->assertNotNull($res);
    }

    public function test_search_returns_json()
    {
        $user = Mockery::mock();
        $user->shouldReceive('can')->with('producto-list')->andReturn(true);

        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function () use ($user) { return function () use ($user) { return $user; }; });
        \Illuminate\Support\Facades\Gate::shouldReceive('authorize')->andReturn(true);

        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
                $table->integer('categoria_id')->nullable();
                $table->timestamps();
            });
        }

        DB::table('productos')->insert(['nombre' => 'BuscarProducto', 'categoria_id' => null, 'created_at' => now(), 'updated_at' => now()]);

        $ctrl = new \App\Http\Controllers\ProductoController();
        $req = Request::create('/productos/search', 'GET', ['q' => 'Buscar']);

        $res = $ctrl->search($req);

        $this->assertStringContainsString('BuscarProducto', $res->getContent());
    }
}
