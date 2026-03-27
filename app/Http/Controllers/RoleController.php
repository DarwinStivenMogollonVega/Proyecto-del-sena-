<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('rol-list'); 
        $texto=$request->input('texto');
        $registros=Role::with('permissions')->where('name', 'like',"%{$texto}%")
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        return view('role.index', compact('registros','texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('rol-create'); 
        $permissions=Permission::all();
        return view('role.action',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('rol-create');
        $validated = $request->validated();

        $registro = Role::create(['name' => $validated['name']]);
        $registro->syncPermissions($validated['permissions']);
        return redirect()->route('roles.index')->with('mensaje', 'Rol '.$registro->name. ' creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('rol-edit'); 
        $registro=Role::findOrFail($id);
        $permissions = Permission::all();        
        return view('role.action', compact('registro', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $this->authorize('rol-edit');
        $registro=Role::findOrFail($id);
        $validated = $request->validated();

        $registro->update(['name' => $validated['name']]);
        $registro->syncPermissions($validated['permissions']);
        return redirect()->route('roles.index')->with('mensaje', 'Registro '.$registro->name. '  actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('rol-delete'); 
        $registro=Role::findOrFail($id);
        $registro->delete();

        return redirect()->route('roles.index')->with('mensaje', $registro->name. ' eliminado correctamente.');
    }
}
