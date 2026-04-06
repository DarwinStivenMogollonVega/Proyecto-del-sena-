<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CatalogoControllerTest extends TestCase
{
    public function test_index_and_create()
    {
        if (!Schema::hasTable('formatos')) {
            Schema::create('formatos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
            });
        }
        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
            });
        }

        DB::table('formatos')->insert(['nombre' => 'F1']);
        DB::table('productos')->insert(['nombre' => 'P1']);

        $user = new class { public function can($a,$b=[]){return true;} };
        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function() use($user){ return function() use($user){ return $user; }; });
        \Illuminate\Support\Facades\Gate::shouldReceive('authorize')->andReturn(true);

        $ctrl = new \App\Http\Controllers\CatalogoController();

        $resIndex = $ctrl->index(Request::create('/catalogo','GET'));
        $this->assertNotNull($resIndex);

        $resCreate = $ctrl->create();
        $this->assertNotNull($resCreate);
    }
}
