<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Create formatos table if not exists
        if (!Schema::hasTable('formatos')) {
            Schema::create('formatos', function (Blueprint $table) {
                $table->id('formato_id');
                $table->string('nombre');
                $table->text('descripcion')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }

        // Add formato_id column to productos if not present
        if (!Schema::hasColumn('productos', 'formato_id')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->unsignedBigInteger('formato_id')->nullable()->after('catalogo_id');
            });
        }

        // If there are existing catalogos, copy them into formatos preserving ids when possible
        if (Schema::hasTable('catalogos')) {
            $catalogos = DB::table('catalogos')->get();
            foreach ($catalogos as $c) {
                // Insert with same id when possible
                $exists = DB::table('formatos')->where('formato_id', $c->catalogo_id)->exists();
                if (!$exists) {
                    DB::table('formatos')->insert([
                        'formato_id' => $c->catalogo_id,
                        'nombre' => $c->nombre,
                        'descripcion' => $c->descripcion ?? null,
                        'activo' => $c->activo ?? true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Update productos.formato_id from catalogo_id when posible
        if (Schema::hasTable('productos')) {
            DB::statement('UPDATE productos SET formato_id = catalogo_id WHERE formato_id IS NULL');
        }
    }

    public function down()
    {
        // Remove formato_id column if exists
        if (Schema::hasColumn('productos', 'formato_id')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('formato_id');
            });
        }

        // Drop formatos table
        if (Schema::hasTable('formatos')) {
            Schema::dropIfExists('formatos');
        }
    }
};
