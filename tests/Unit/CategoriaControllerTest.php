<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Tests\Support\TestDbSetup;

class CategoriaControllerTest extends TestCase
{
    use TestDbSetup;
    public function test_index_and_attach_detach()
    {
        // Ensure basic tables (categorias, formatos, artistas)
        $this->ensureBasicTables();

        if (!\Illuminate\Support\Facades\Schema::hasTable('productos')) {
            \Illuminate\Support\Facades\Schema::create('productos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
                $table->integer('categoria_id')->nullable();
                $table->timestamps();
            });
        }

        DB::table('productos')->insert(['nombre' => 'P1']);

        $user = new class { public function can($a,$b=[]){return true;} };
        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function() use($user){ return function() use($user){ return $user; }; });
        \Illuminate\Support\Facades\Gate::shouldReceive('authorize')->andReturn(true);

        $ctrl = new \App\Http\Controllers\CategoriaController();

        Model::withoutEvents(function () use ($ctrl) {
            $resIndex = $ctrl->index(Request::create('/categoria','GET'));
            $this->assertNotNull($resIndex);

            $categoria = \App\Models\Categoria::first();
            $reqAttach = Request::create('/categoria/attach','POST',['product_id' => 1]);
            $resAttach = $ctrl->attachProducto($reqAttach, $categoria);
            $this->assertStringContainsString('success', $resAttach->getContent());

            $producto = \App\Models\Producto::first();
            $resDetach = $ctrl->detachProducto($categoria, $producto);
            $this->assertStringContainsString('success', $resDetach->getContent());
        });
    }
}
