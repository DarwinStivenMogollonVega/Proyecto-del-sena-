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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usuario_id');
            $table->string('nombre');
            $table->string('correo_electronico')->unique();
            $table->timestamp('correo_verificado_en')->nullable();
            $table->string('contrasena');
            $table->string('token_recordar', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('tokens_restablecer_contrasena', function (Blueprint $table) {
            $table->string('correo_electronico')->primary();
            $table->string('token');
            $table->timestamp('creado_en')->nullable();
        });

        Schema::create('sesiones', function (Blueprint $table) {
            $table->string('sesion_id')->primary();
            $table->foreignId('usuario_id')->nullable()->index();
            $table->string('direccion_ip', 45)->nullable();
            $table->text('agente_usuario')->nullable();
            $table->longText('carga_util');
            $table->integer('ultima_actividad')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('tokens_restablecer_contrasena');
        Schema::dropIfExists('sesiones');
    }
};
