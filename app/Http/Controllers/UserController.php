<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('user-list'); 
        $texto = trim((string) $request->input('texto'));

        $registros = User::with('roles')
            ->when($texto !== '', function ($query) use ($texto) {
                $query->where(function ($subQuery) use ($texto) {
                    $subQuery->where('name', 'like', "%{$texto}%")
                        ->orWhere('email', 'like', "%{$texto}%");
                });
            })
            ->orderByDesc((new User())->getKeyName())
            ->paginate(10);

        return view('usuario.index', compact('registros','texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('user-create'); 
        $roles=Role::all();
        return view('usuario.action', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->authorize('user-create');
        $validated = $request->validated();

        $registro=new User();
        $registro->name = $validated['name'];
        $registro->email = $validated['email'];
        $registro->password = bcrypt($validated['password']);
        $registro->activo = $validated['activo'];
        $registro->save();

        $registro->assignRole($validated['role']);
        return redirect()->route('usuarios.index')->with('mensaje', 'Registro '.$registro->name. '  agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('user-edit'); 
        $roles=Role::all();
        $registro=User::findOrFail($id);
        return view('usuario.action', compact('registro','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $this->authorize('user-edit');
        $validated = $request->validated();

        $registro=User::findOrFail($id);
        $registro->name = $validated['name'];
        $registro->email = $validated['email'];
        if (!empty($validated['password'])) {
            $registro->password = bcrypt($validated['password']);
        }
        $registro->activo = $validated['activo'];
        $registro->save();

        $registro->syncRoles([$validated['role']]);

        return redirect()->route('usuarios.index')->with('mensaje', 'Registro '.$registro->name. '  actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorize('user-delete');
        $registro=User::findOrFail($id);
        $registro->delete();

        return redirect()->route('usuarios.index')->with('mensaje', $registro->name. ' eliminado correctamente.');
    }

    public function toggleStatus(User $usuario){
        $this->authorize('user-activate'); 
        $usuario->activo=!$usuario->activo;
        $usuario->save();
        return redirect()->route('usuarios.index')->with('mensaje', 'Estado del usuario actualizado correctamente.');
    }
}
