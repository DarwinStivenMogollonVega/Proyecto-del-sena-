<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = [
            'productos',
            'categorias',
            'catalogos',
            'artistas',
            'albums',
            'proveedors', // table name may vary (proveedors/proveedores)
            'proveedores',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'activo')) {
                Schema::table($table, function (Blueprint $tableBlueprint) {
                    $tableBlueprint->boolean('activo')->default(true);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'productos',
            'categorias',
            'catalogos',
            'artistas',
            'albums',
            'proveedors',
            'proveedores',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'activo')) {
                Schema::table($table, function (Blueprint $tableBlueprint) {
                    $tableBlueprint->dropColumn('activo');
                });
            }
        }
    }
};
