<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UserRequest;

class PerfilController extends Controller
{
    public function edit(){
        $registro=Auth::user();
        return view('autenticacion.perfil', compact('registro'));
    }
    public function update(UserRequest $request){
        $registro=Auth::user();
        $registro->name = $request->name;
        $registro->email = $request->email;
        $registro->telefono = $request->telefono;
        $registro->documento_identidad = $request->documento_identidad;
        $registro->fecha_nacimiento = $request->fecha_nacimiento;
        $registro->direccion = $request->direccion;
        $registro->ciudad = $request->ciudad;
        $registro->pais = $request->pais;
        $registro->codigo_postal = $request->codigo_postal;
        if ($request->filled('password')) {
            $registro->password = Hash::make($request->password);
        }
        $registro->save();

        return redirect()->route('perfil.edit')->with('mensaje', 'Datos actualizados correctamente.');
    }
}
