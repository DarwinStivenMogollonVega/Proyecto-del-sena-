<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CarritoControllerTest extends TestCase
{
    public function test_agregar_and_cart_operations()
    {
        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
                $table->string('codigo')->nullable();
                $table->decimal('precio', 10, 2)->default(0);
                $table->string('imagen')->nullable();
                $table->integer('cantidad')->default(0);
                $table->timestamps();
            });
        }

        DB::table('productos')->insert(['nombre' => 'P1', 'codigo' => 'C1', 'precio' => 10, 'imagen' => '', 'created_at' => now(), 'updated_at' => now()]);

        $ctrl = new \App\Http\Controllers\CarritoController();

        $req = Request::create('/carrito/agregar','POST',['producto_id' => 1, 'cantidad' => 2]);
        $res = $ctrl->agregar($req);
        $this->assertNotNull($res);

        $resMostrar = $ctrl->mostrar();
        $this->assertNotNull($resMostrar);

        $reqSumar = Request::create('/carrito/sumar','POST',['producto_id' => 1]);
        $ctrl->sumar($reqSumar);

        $reqRestar = Request::create('/carrito/restar','POST',['producto_id' => 1]);
        $ctrl->restar($reqRestar);

        $resVaciar = $ctrl->vaciar();
        $this->assertNotNull($resVaciar);
    }
}
