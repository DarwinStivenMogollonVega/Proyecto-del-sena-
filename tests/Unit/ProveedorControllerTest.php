<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class ProveedorControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_returns_resumen()
    {
        $user = Mockery::mock();
        $user->shouldReceive('can')->with('proveedor-list')->andReturn(true);

        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function () use ($user) { return function () use ($user) { return $user; }; });
        \Illuminate\Support\Facades\Gate::shouldReceive('authorize')->andReturn(true);

        if (!Schema::hasTable('proveedors') && !Schema::hasTable('proveedores')) {
            Schema::create('proveedores', function (Blueprint $table) {
                $table->bigIncrements('proveedor_id');
                $table->string('nombre')->nullable();
                $table->boolean('activo')->default(true);
            });
        }

        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
                $table->bigInteger('proveedor_id')->nullable();
            });
        }

        DB::table('proveedores')->insert(['nombre' => 'Prov1', 'activo' => true]);
        DB::table('productos')->insert(['nombre' => 'P1', 'proveedor_id' => 1]);

        $ctrl = new \App\Http\Controllers\ProveedorController();
        $req = Request::create('/proveedores', 'GET');

        $res = $ctrl->index($req);

        $this->assertNotNull($res);
    }
}
