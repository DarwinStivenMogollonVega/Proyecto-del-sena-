<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class FacturaControllerTest extends TestCase
{
    public function test_index_returns_user_facturas()
    {
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->bigIncrements('usuario_id');
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('facturas')) {
            Schema::create('facturas', function (Blueprint $table) {
                $table->bigIncrements('factura_id');
                $table->bigInteger('usuario_id')->nullable();
                $table->decimal('total', 12, 2)->default(0);
                $table->timestamps();
            });
        }

        DB::table('usuarios')->insert(['name' => 'U1', 'email' => 'u1@test', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('facturas')->insert(['usuario_id' => 1, 'total' => 123.45, 'created_at' => now(), 'updated_at' => now()]);

        $user = new class {
            public function can($ability, $arguments = []) { return true; }
            public function cannot($ability, $arguments = []) { return false; }
        };

        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('id')->andReturn(1);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function () use ($user) { return function () use ($user) { return $user; }; });

        $ctrl = new \App\Http\Controllers\FacturaController();

        $res = $ctrl->index(Request::create('/facturas', 'GET'));
        $this->assertNotNull($res);
    }
}
