<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class ClienteGestionControllerTest extends TestCase
{
    public function test_index_and_show()
    {
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->bigIncrements('usuario_id');
                $table->string('name')->nullable();
                $table->string('email')->nullable();
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
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
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

        DB::table('usuarios')->insert(['name' => 'Cliente1', 'email' => 'c1@test', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('pedidos')->insert(['usuario_id' => 1, 'total' => 100.00, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('roles')->insert(['name' => 'cliente']);
        DB::table('model_has_roles')->insert(['role_id' => 1, 'model_id' => 1, 'model_type' => \App\Models\User::class]);

        $user = new class { public function can($a,$b=[]){return true;} };
        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function() use($user){ return function() use($user){ return $user; }; });

        $ctrl = new \App\Http\Controllers\ClienteGestionController();

        $resIndex = $ctrl->index(Request::create('/cliente_gestion','GET'));
        $this->assertNotNull($resIndex);

        $resShow = $ctrl->show(1);
        $this->assertNotNull($resShow);
    }
}
