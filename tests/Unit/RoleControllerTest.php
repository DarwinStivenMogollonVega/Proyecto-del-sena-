<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class RoleControllerTest extends TestCase
{
    public function test_index_and_create()
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
            });
        }
        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
            });
        }

        DB::table('roles')->insert(['name' => 'admin']);
        DB::table('permissions')->insert(['name' => 'rol-list']);
        if (!Schema::hasTable('role_has_permissions')) {
            Schema::create('role_has_permissions', function (Blueprint $table) {
                $table->bigInteger('permission_id');
                $table->bigInteger('role_id');
            });
        }
        DB::table('role_has_permissions')->insert(['permission_id' => 1, 'role_id' => 1]);

        $user = new class { public function can($a,$b=[]){return true;} };
        \Illuminate\Support\Facades\Auth::shouldReceive('check')->andReturn(true);
        \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
        \Illuminate\Support\Facades\Auth::shouldReceive('userResolver')->andReturnUsing(function() use($user){ return function() use($user){ return $user; }; });
        \Illuminate\Support\Facades\Gate::shouldReceive('authorize')->andReturn(true);

        $ctrl = new \App\Http\Controllers\RoleController();
        $res1 = $ctrl->index(Request::create('/roles','GET'));
        $this->assertNotNull($res1);

        $res2 = $ctrl->create();
        $this->assertNotNull($res2);
    }
}
