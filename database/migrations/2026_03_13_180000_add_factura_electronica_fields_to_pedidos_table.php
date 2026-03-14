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
            $table->boolean('requiere_factura_electronica')->default(false)->after('comprobante_pago');
            $table->string('tipo_documento', 20)->nullable()->after('requiere_factura_electronica');
            $table->string('numero_documento', 40)->nullable()->after('tipo_documento');
            $table->string('razon_social', 140)->nullable()->after('numero_documento');
            $table->string('correo_factura', 120)->nullable()->after('razon_social');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'requiere_factura_electronica',
                'tipo_documento',
                'numero_documento',
                'razon_social',
                'correo_factura',
            ]);
        });
    }
};
