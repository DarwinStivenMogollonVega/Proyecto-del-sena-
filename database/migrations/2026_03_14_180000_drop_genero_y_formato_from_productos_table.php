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
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'genero_musical')) {
                $table->dropColumn('genero_musical');
            }

            if (Schema::hasColumn('productos', 'formato_producto')) {
                $table->dropColumn('formato_producto');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (!Schema::hasColumn('productos', 'genero_musical')) {
                $table->string('genero_musical', 80)->nullable()->after('artista_id');
            }

            if (!Schema::hasColumn('productos', 'formato_producto')) {
                $table->enum('formato_producto', ['cd', 'vinilo', 'digital'])->default('cd')->after('anio_lanzamiento');
            }
        });
    }
};
