<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('artistas', 'slug')) {
            Schema::table('artistas', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('nombre');
            });

            // Backfill slug values for existing rows.
            $artists = DB::table('artistas')->select('artista_id', 'nombre')->get();
            foreach ($artists as $artist) {
                $base = Str::slug($artist->nombre ?: 'artista');
                $slug = $base;
                $i = 2;
                while (DB::table('artistas')->where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i;
                    $i++;
                }
                DB::table('artistas')->where('artista_id', $artist->artista_id)->update(['slug' => $slug]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('artistas', 'slug')) {
            Schema::table('artistas', function (Blueprint $table) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            });
        }
    }
};
