<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;


class RegisterController extends Controller
{
    public function showRegistroForm(){
        return view('autenticacion.registro');
    }

    public function registrar(RegisterRequest $request){
        $validated = $request->validated();

        $usuario = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'activo' => 1, // Activar automáticamente
        ]);

        $clienteRol=Role::where('name','cliente')->first();
        if($clienteRol){
            $usuario->assignRole($clienteRol);
        }
        Auth::login($usuario);
        return redirect()->route('web.index')->with('mensaje', 'Registro exitoso. ¡Bienvenido!');
    }
}
