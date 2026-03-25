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
        Schema::create('artistas', function (Blueprint $table) {
            $table->id('artista_id');
            $table->string('nombre', 120);
            $table->string('identificador_unico', 140)->unique();
            $table->string('foto', 120)->nullable();
            $table->text('biografia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artistas');
    }
};
