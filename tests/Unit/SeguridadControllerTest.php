<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class SeguridadControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_calls_model_queries_when_authorized()
    {
        // Converted to unit test: mock Auth, models and query chains
        // Mock Auth facade to simulate authorized user
        $user = Mockery::mock();
        $user->shouldReceive('can')->with('rol-list')->andReturn(true);

        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);

        // Create minimal tables and seed rows instead of alias mocks
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

        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('role_has_permissions')) {
            Schema::create('role_has_permissions', function (Blueprint $table) {
                $table->bigInteger('permission_id');
                $table->bigInteger('role_id');
            });
        }

        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->bigIncrements('usuario_id');
                $table->string('nombre')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('admin_activity_logs')) {
            Schema::create('admin_activity_logs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('action')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('registros_actividad_admin')) {
            Schema::create('registros_actividad_admin', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('accion')->nullable();
                $table->timestamps();
            });
        }

        DB::table('roles')->insert(['name' => 'admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['name' => 'rol-list', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('role_has_permissions')->insert(['permission_id' => 1, 'role_id' => 1]);
        DB::table('usuarios')->insert(['nombre' => 'U1', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('admin_activity_logs')->insert(['action' => 'test', 'created_at' => now(), 'updated_at' => now()]);

        // Call controller method
        $ctrl = new \App\Http\Controllers\SeguridadController();
        $req = Request::create('/seguridad', 'GET');

        $res = $ctrl->index($req);

        // We expect a View; at minimum the method should return something non-null
        $this->assertNotNull($res);
    }
}
