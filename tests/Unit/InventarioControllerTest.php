<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Tests\Support\TestDbSetup;

class InventarioControllerTest extends TestCase
{
    use TestDbSetup;
    public function test_index_and_moverStock_behaviour()
    {
        // Create usuarios and productos + movimientos tables
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->bigIncrements('usuario_id');
                $table->string('name')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
                $table->integer('cantidad')->default(0);
                $table->timestamps();
            });
        }

        $this->ensureBasicTables();

        if (!\Illuminate\Support\Facades\Schema::hasTable('movimientos_inventario')) {
            Schema::create('movimientos_inventario', function (Blueprint $table) {
                $table->bigIncrements('movimiento_inventario_id');
                $table->bigInteger('producto_id');
                $table->bigInteger('usuario_id');
                $table->string('tipo')->nullable();
                $table->integer('cantidad')->default(0);
                $table->integer('stock_anterior')->default(0);
                $table->integer('stock_nuevo')->default(0);
                $table->string('motivo')->nullable();
                $table->timestamps();
            });
        }

        \Illuminate\Support\Facades\DB::table('usuarios')->insert(['name' => 'U1', 'created_at' => now(), 'updated_at' => now()]);
        \Illuminate\Support\Facades\DB::table('productos')->insert(['nombre' => 'P1', 'cantidad' => 5, 'created_at' => now(), 'updated_at' => now()]);

        // lightweight Authorizable user
        $user = new class {
            public function can($ability, $arguments = []) { return true; }
            public function cannot($ability, $arguments = []) { return false; }
        };

        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('id')->andReturn(1);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function () use ($user) { return function () use ($user) { return $user; }; });

        $ctrl = new \App\Http\Controllers\InventarioController();

        $resIndex = $ctrl->index(Request::create('/inventario', 'GET'));
        $this->assertNotNull($resIndex);

        // moverStock: entrada +3
        $req = Request::create('/inventario/mover/1', 'POST', ['tipo' => 'entrada', 'cantidad' => 3]);
        \Illuminate\Database\Eloquent\Model::withoutEvents(function () use ($ctrl, $req) {
            $resMover = $ctrl->moverStock($req, 1);
            $this->assertNotNull($resMover);
        });

        $this->assertDatabaseHas('movimientos_inventario', ['producto_id' => 1]);
    }
}
