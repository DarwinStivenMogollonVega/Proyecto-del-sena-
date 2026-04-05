<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('lista_deseos')) {
            // Create table without forcing foreign keys; add FKs later if referenced tables exist.
            Schema::create('lista_deseos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('producto_id');
                $table->timestamps();

                $table->unique(['user_id', 'producto_id']);
            });

            // Add foreign keys only if referenced tables are present to avoid ordering issues.
            if (Schema::hasTable('users')) {
                Schema::table('lista_deseos', function (Blueprint $table) {
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                });
            }

            if (Schema::hasTable('productos')) {
                Schema::table('lista_deseos', function (Blueprint $table) {
                    $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
                });
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('lista_deseos');
    }
};
