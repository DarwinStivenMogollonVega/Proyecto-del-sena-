<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            if (!Schema::hasColumn('facturas', 'telefono_cliente')) {
                $table->string('telefono_cliente', 50)->nullable()->after('direccion_cliente');
            }
        });
    }

    public function down(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            if (Schema::hasColumn('facturas', 'telefono_cliente')) {
                $table->dropColumn('telefono_cliente');
            }
        });
    }
};
