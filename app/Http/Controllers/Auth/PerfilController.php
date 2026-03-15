<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Http\Requests\UserRequest;

class PerfilController extends Controller
{
    public function edit(){
        $registro=Auth::user();
        return view('autenticacion.perfil', compact('registro'));
    }
    public function update(UserRequest $request){
        $registro = Auth::user();
        $registro->name               = $request->name;
        $registro->email              = $request->email;
        $registro->telefono           = $request->telefono;
        $registro->documento_identidad = $request->documento_identidad;
        $registro->fecha_nacimiento   = $request->fecha_nacimiento;
        $registro->direccion          = $request->direccion;
        $registro->ciudad             = $request->ciudad;
        $registro->pais               = $request->pais;
        $registro->codigo_postal      = $request->codigo_postal;

        if ($request->hasFile('avatar')) {
            if ($registro->avatar && file_exists(public_path('uploads/avatars/' . $registro->avatar))) {
                unlink(public_path('uploads/avatars/' . $registro->avatar));
            }
            $file     = $request->file('avatar');
            $filename = time() . '_' . $registro->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);
            $registro->avatar = $filename;
        }

        if ($request->filled('password')) {
            $registro->password = Hash::make($request->password);
        }
        $registro->save();

        return redirect()->route('perfil.edit')->with('mensaje', 'Datos actualizados correctamente.');
    }
}
