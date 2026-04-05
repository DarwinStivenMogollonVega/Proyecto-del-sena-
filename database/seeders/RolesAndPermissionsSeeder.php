<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear los roles (incluyendo guard_name explícito)
        $guard = config('auth.defaults.guard') ?? 'web';
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guard]);
        $clienteRole = Role::firstOrCreate(['name' => 'cliente', 'guard_name' => $guard]);
        
        // Definir permisos
        $adminPermissions = [
            'user-list', 'user-create', 'user-edit', 'user-delete', 'user-activate',
            'rol-list', 'rol-create', 'rol-edit', 'rol-delete',
            'producto-list', 'producto-create', 'producto-edit', 'producto-delete',
            'proveedor-list', 'proveedor-create', 'proveedor-edit', 'proveedor-delete',
            'artista-list', 'artista-create', 'artista-edit', 'artista-delete',
            'inventario-list', 'inventario-edit',
            'pedido-list', 'pedido-anulate',
            'categoria-list', 'categoria-create', 'categoria-edit', 'categoria-delete',
            'formato-list', 'formato-create', 'formato-edit', 'formato-delete',
        ];


        $clientePermissions = ['pedido-view', 'pedido-cancel','perfil'];

        // Crear y asignar permisos
        foreach ($adminPermissions as $permiso) {
            $permission = Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => $guard,
            ]);
            $adminRole->givePermissionTo($permission);
        }

        foreach ($clientePermissions as $permiso) {
            $permission = Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => $guard,
            ]);
            $clienteRole->givePermissionTo($permission);
        }

        // Crear usuarios y asignar roles
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@prueba.com'],
            ['name' => 'Admin', 'password' => bcrypt('admin123456')]
        );
        // Recargar desde la BD para garantizar que el PK esté presente
        $adminUser = User::where('email', 'admin@prueba.com')->first();
        if (!$adminUser || !$adminUser->getKey()) {
            throw new \RuntimeException('No se pudo crear/recuperar el usuario admin; el id es nulo.');
        }
        $adminUser->assignRole($adminRole);

        $clienteUser = User::firstOrCreate(
            ['email' => 'cliente@prueba.com'],
            ['name' => 'Cliente', 'password' => bcrypt('cliente123456')]
        );
        // Recargar desde la BD para garantizar que el PK esté presente
        $clienteUser = User::where('email', 'cliente@prueba.com')->first();
        if (!$clienteUser || !$clienteUser->getKey()) {
            throw new \RuntimeException('No se pudo crear/recuperar el usuario cliente; el id es nulo.');
        }
        $clienteUser->assignRole($clienteRole);
    }
}
