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
        Schema::create('registros_actividad_admin', function (Blueprint $table) {
            $table->id('registro_actividad_admin_id');
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->string('metodo', 10);
            $table->string('nombre_ruta', 120)->nullable();
            $table->string('url', 255);
            $table->string('direccion_ip', 45)->nullable();
            $table->string('agente_usuario', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_actividad_admin');
    }
};
