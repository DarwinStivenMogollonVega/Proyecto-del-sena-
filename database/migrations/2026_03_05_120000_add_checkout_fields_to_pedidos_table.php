<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('nombre')->after('usuario_id');
            $table->string('email')->after('nombre');
            $table->string('telefono', 30)->after('email');
            $table->string('direccion')->after('telefono');
            $table->string('metodo_pago', 30)->after('direccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'email', 'telefono', 'direccion', 'metodo_pago']);
        });
    }
};
