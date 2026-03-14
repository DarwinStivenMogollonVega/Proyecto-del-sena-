<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('pedido_detalles')) {
            return;
        }

        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE pedido_detalles MODIFY precio DECIMAL(10,2) NOT NULL');
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE pedido_detalles ALTER COLUMN precio TYPE DECIMAL(10,2)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('pedido_detalles')) {
            return;
        }

        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE pedido_detalles MODIFY precio DECIMAL(6,2) NOT NULL');
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE pedido_detalles ALTER COLUMN precio TYPE DECIMAL(6,2)');
        }
    }
};
