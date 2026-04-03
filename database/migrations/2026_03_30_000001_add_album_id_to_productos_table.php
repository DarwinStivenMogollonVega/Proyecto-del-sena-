<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('productos', 'album_id')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->foreignId('album_id')
                    ->nullable()
                    ->constrained('albums', 'album_id')
                    ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['album_id']);
            $table->dropColumn('album_id');
        });
    }
};
