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
        $equipos = config('permission.equipos');
        $nombresTablas = config('permission.nombres_tablas');
        $nombresColumnas = config('permission.nombres_columnas');
        $pivotRol = $nombresColumnas['role_pivot_key'] ?? 'role_id';
        $pivotPermiso = $nombresColumnas['permission_pivot_key'] ?? 'permission_id';
        $permissionPk = $nombresColumnas['permission_primary_key'] ?? 'permission_id';
        $rolePk = $nombresColumnas['role_primary_key'] ?? 'role_id';

        if (empty($nombresTablas)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($equipos && empty($nombresColumnas['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($nombresTablas['permissions'], static function (Blueprint $table) use ($permissionPk) {
            // $table->engine('InnoDB');
            $table->bigIncrements($permissionPk); // permission primary key (explicit)
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($nombresTablas['roles'], static function (Blueprint $table) use ($equipos, $nombresColumnas, $rolePk) {
            // $table->engine('InnoDB');
            $table->bigIncrements($rolePk); // role primary key (explicit)
            if ($equipos || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($nombresColumnas['team_foreign_key'])->nullable();
                $table->index($nombresColumnas['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
            $table->timestamps();
            if ($equipos || config('permission.testing')) {
                $table->unique([$nombresColumnas['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });
        Schema::create($nombresTablas['model_has_permissions'], static function (Blueprint $table) use ($nombresTablas, $nombresColumnas, $pivotPermiso, $equipos, $permissionPk) {
            $table->unsignedBigInteger($pivotPermiso);

            $table->string('model_type');
            $table->unsignedBigInteger($nombresColumnas['model_morph_key']);
            $table->index([$nombresColumnas['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign($pivotPermiso)
                ->references($permissionPk)
                ->on($nombresTablas['permissions'])
                ->onDelete('cascade');
            if ($equipos) {
                $table->unsignedBigInteger($nombresColumnas['team_foreign_key']);
                $table->index($nombresColumnas['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$nombresColumnas['team_foreign_key'], $pivotPermiso, $nombresColumnas['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([$pivotPermiso, $nombresColumnas['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($nombresTablas['model_has_roles'], static function (Blueprint $table) use ($nombresTablas, $nombresColumnas, $pivotRol, $equipos, $rolePk) {
            $table->unsignedBigInteger($pivotRol);

            $table->string('model_type');
            $table->unsignedBigInteger($nombresColumnas['model_morph_key']);
            $table->index([$nombresColumnas['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign($pivotRol)
                ->references($rolePk)
                ->on($nombresTablas['roles'])
                ->onDelete('cascade');
            if ($equipos) {
                $table->unsignedBigInteger($nombresColumnas['team_foreign_key']);
                $table->index($nombresColumnas['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$nombresColumnas['team_foreign_key'], $pivotRol, $nombresColumnas['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([$pivotRol, $nombresColumnas['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($nombresTablas['role_has_permissions'], static function (Blueprint $table) use ($nombresTablas, $pivotRol, $pivotPermiso, $permissionPk, $rolePk) {
            $table->unsignedBigInteger($pivotPermiso);
            $table->unsignedBigInteger($pivotRol);

            $table->foreign($pivotPermiso)
                ->references($permissionPk)
                ->on($nombresTablas['permissions'])
                ->onDelete('cascade');

            $table->foreign($pivotRol)
                ->references($rolePk)
                ->on($nombresTablas['roles'])
                ->onDelete('cascade');

            $table->primary([$pivotPermiso, $pivotRol], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
                ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.nombres_tablas');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
};
