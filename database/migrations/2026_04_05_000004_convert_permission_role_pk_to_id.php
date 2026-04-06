<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Rename permission_id -> id if present
        if (Schema::hasTable('permissions') && Schema::hasColumn('permissions', 'permission_id')) {
            if (Schema::getConnection()->getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE `permissions` CHANGE `permission_id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;');
            }
        }

        // Rename role_id -> id if present
        if (Schema::hasTable('roles') && Schema::hasColumn('roles', 'role_id')) {
            if (Schema::getConnection()->getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE `roles` CHANGE `role_id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;');
            }
        }

        // Update foreign keys in pivot tables to reference the new id columns
        if (Schema::hasTable('role_has_permissions')) {
            Schema::table('role_has_permissions', function (Blueprint $table) {
                // drop existing foreign keys if exist
                try { $table->dropForeign(['permission_id']); } catch (\Exception $e) {}
                try { $table->dropForeign(['role_id']); } catch (\Exception $e) {}
            });
            Schema::table('role_has_permissions', function (Blueprint $table) {
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('model_has_permissions')) {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                try { $table->dropForeign(['permission_id']); } catch (\Exception $e) {}
            });
            Schema::table('model_has_permissions', function (Blueprint $table) {
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('model_has_roles')) {
            Schema::table('model_has_roles', function (Blueprint $table) {
                try { $table->dropForeign(['role_id']); } catch (\Exception $e) {}
            });
            Schema::table('model_has_roles', function (Blueprint $table) {
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        // Revert is potentially destructive; we avoid automatic rollback.
    }
};
