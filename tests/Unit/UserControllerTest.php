<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class UserControllerTest extends TestCase
{
    public function test_index_and_create_return_views()
    {
        // Create minimal usuarios table
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->bigIncrements('usuario_id');
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('password')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name')->nullable();
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

        DB::table('usuarios')->insert(['name' => 'U1', 'email' => 'u1@example.test', 'password' => 'x', 'activo' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('roles')->insert(['name' => 'admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()]);

        // Provide a lightweight Authorizable user object for auth()->user()->can
        $user = new class {
            public function can($ability, $arguments = []) { return true; }
            public function cannot($ability, $arguments = []) { return false; }
        };

        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('id')->andReturn(1);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function () use ($user) { return function () use ($user) { return $user; }; });
        \Illuminate\Support\Facades\Gate::shouldReceive('authorize')->andReturn(true);

        $ctrl = new \App\Http\Controllers\UserController();

        $resIndex = $ctrl->index(Request::create('/usuarios', 'GET'));
        $this->assertNotNull($resIndex);

        $resCreate = $ctrl->create();
        $this->assertNotNull($resCreate);
    }
}
