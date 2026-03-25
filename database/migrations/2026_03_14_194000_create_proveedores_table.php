<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('proveedor_id');
            $table->string('nombre', 120);
            $table->string('persona_contacto', 120)->nullable();
            $table->string('telefono', 40)->nullable();
            $table->string('correo_electronico', 120)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
