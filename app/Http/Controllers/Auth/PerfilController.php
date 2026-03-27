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
            $filename = time() . '_' . $registro->getKey() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);
            $registro->avatar = $filename;
        }

        // Remove avatar when requested and no new file uploaded
        if (!$request->hasFile('avatar') && $request->input('remove_avatar') == '1') {
            if ($registro->avatar && file_exists(public_path('uploads/avatars/' . $registro->avatar))) {
                unlink(public_path('uploads/avatars/' . $registro->avatar));
            }
            $registro->avatar = null;
        }

        // If the client sent a cropped image (base64), save it (takes precedence over standard file)
        $cropped = $request->input('avatar_cropped');
        if ($cropped && is_string($cropped) && strpos($cropped, 'data:image') === 0) {
            // remove existing file
            if ($registro->avatar && file_exists(public_path('uploads/avatars/' . $registro->avatar))) {
                unlink(public_path('uploads/avatars/' . $registro->avatar));
            }
            // parse base64
            [$meta, $data] = explode(',', $cropped, 2) + [null, null];
            $ext = 'jpg';
            if (strpos($meta, 'image/png') !== false) $ext = 'png';
            if (strpos($meta, 'image/webp') !== false) $ext = 'webp';
            $decoded = base64_decode($data);
            if ($decoded !== false) {
                $filename = time() . '_' . $registro->getKey() . '_crop.' . $ext;
                file_put_contents(public_path('uploads/avatars/' . $filename), $decoded);
                $registro->avatar = $filename;
            }
        }

        if ($request->filled('password')) {
            $registro->password = Hash::make($request->password);
        }
        $registro->save();

        return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado correctamente.');
    }
}
