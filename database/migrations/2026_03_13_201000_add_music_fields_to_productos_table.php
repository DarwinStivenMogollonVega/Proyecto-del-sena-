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
        if (!Schema::hasColumn('productos', 'artista_id')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->foreignId('artista_id')->nullable()->constrained('artistas', 'artista_id')->nullOnDelete()->after('catalogo_id');
                $table->string('genero_musical', 80)->nullable()->after('artista_id');
                $table->unsignedSmallInteger('anio_lanzamiento')->nullable()->after('genero_musical');
                $table->enum('formato_producto', ['cd', 'vinilo', 'digital'])->default('cd')->after('anio_lanzamiento');
                $table->json('lista_canciones')->nullable()->after('descripcion');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('artista_id');
            $table->dropColumn(['genero_musical', 'anio_lanzamiento', 'formato_producto', 'lista_canciones']);
        });
    }
};
