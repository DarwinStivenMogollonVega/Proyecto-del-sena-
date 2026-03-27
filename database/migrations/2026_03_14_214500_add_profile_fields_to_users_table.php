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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('telefono', 20)->nullable()->after('email');
            $table->string('documento_identidad', 30)->nullable()->after('telefono');
            $table->date('fecha_nacimiento')->nullable()->after('documento_identidad');
            $table->string('direccion')->nullable()->after('fecha_nacimiento');
            $table->string('ciudad', 120)->nullable()->after('direccion');
            $table->string('pais', 120)->nullable()->after('ciudad');
            $table->string('codigo_postal', 20)->nullable()->after('pais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn([
                'telefono',
                'documento_identidad',
                'fecha_nacimiento',
                'direccion',
                'ciudad',
                'pais',
                'codigo_postal',
            ]);
        });
    }
};
