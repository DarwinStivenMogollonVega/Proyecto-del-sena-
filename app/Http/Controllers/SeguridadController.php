<?php

namespace App\Http\Controllers;

use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SeguridadController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('rol-list') || auth()->user()->can('user-list'), 403);

        $roles = Role::withCount('permissions')->withCount('users')->orderBy('name')->get();
        $usuariosAdmin = User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->latest('usuario_id')->limit(10)->get();

        $logs = AdminActivityLog::with('user')->latest('registro_actividad_admin_id')->paginate(20);

        return view('seguridad.index', compact('roles', 'usuariosAdmin', 'logs'));
    }
    /**
     * Muestra el formulario para crear un nuevo usuario de seguridad.
     */
    public function create()
    {
        // Puedes pasar datos a la vista si lo necesitas (roles, permisos, etc.)
        return view('seguridad.create');
    }
}
