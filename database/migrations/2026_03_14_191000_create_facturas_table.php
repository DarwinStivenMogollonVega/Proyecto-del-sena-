<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->unique()->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('numero_factura', 40)->nullable()->unique();
            $table->timestamp('fecha_emision');
            $table->string('estado_pedido', 30)->default('pendiente');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('impuestos', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('cliente_nombre', 120);
            $table->string('cliente_email', 120);
            $table->string('cliente_direccion', 255)->nullable();
            $table->string('cliente_identificacion', 80)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
