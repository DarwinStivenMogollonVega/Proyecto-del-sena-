<?php
namespace Tests\Support;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ViewErrorBag;

trait TestDbSetup
{
    /**
     * Ensure the minimal tables and seed rows used by many view composers exist.
     */
    protected function ensureBasicTables(): void
    {
        if (!Schema::hasTable('categorias')) {
            Schema::create('categorias', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable();
            });
        }
        if (!Schema::hasTable('formatos')) {
            Schema::create('formatos', function (Blueprint $table) {
                $table->bigIncrements('formato_id');
                $table->string('nombre')->nullable();
            });
        }
        if (!Schema::hasTable('artistas')) {
            Schema::create('artistas', function (Blueprint $table) {
                $table->bigIncrements('artista_id');
                $table->string('nombre')->nullable();
            });
        }

        // Insert default rows if empty
        if (DB::table('categorias')->count() == 0) {
            DB::table('categorias')->insert(['nombre' => 'C1']);
        }
        if (DB::table('formatos')->count() == 0) {
            DB::table('formatos')->insert(['nombre' => 'F1']);
        }
        if (DB::table('artistas')->count() == 0) {
            DB::table('artistas')->insert(['nombre' => 'A1']);
        }

        // Ensure $errors exists for blade
        view()->share('errors', new ViewErrorBag());
    }
}
