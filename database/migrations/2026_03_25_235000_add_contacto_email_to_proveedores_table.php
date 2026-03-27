<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proveedores', function (Blueprint $table) {
            if (!Schema::hasColumn('proveedores', 'contacto')) {
                $table->string('contacto', 120)->nullable()->after('nombre');
            }
            if (!Schema::hasColumn('proveedores', 'email')) {
                $table->string('email', 120)->nullable()->after('telefono');
            }
        });
    }

    public function down(): void
    {
        Schema::table('proveedores', function (Blueprint $table) {
            if (Schema::hasColumn('proveedores', 'contacto')) {
                $table->dropColumn('contacto');
            }
            if (Schema::hasColumn('proveedores', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
