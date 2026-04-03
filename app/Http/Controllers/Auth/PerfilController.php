<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Intervention\Image\Facades\Image;

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
            $registro->telefono           = null; // Initialize telefono

            // Assemble full phone with dial code if provided
            $phone = null;
            if ($request->filled('telefono')) {
                $local = preg_replace('/\D+/', '', $request->telefono);
                $code = preg_replace('/\D+/', '', $request->input('phone_code', ''));
                if ($code) {
                    $phone = '+' . ltrim($code, '+') . $local;
                } else {
                    $phone = $local;
                }
            }
            $registro->telefono = $phone;
        $registro->documento_identidad = $request->documento_identidad;
        $registro->fecha_nacimiento   = $request->fecha_nacimiento;
        $registro->direccion          = $request->direccion;
        $registro->ciudad             = $request->ciudad;
        $registro->pais               = $request->pais;
        $registro->codigo_postal      = $request->codigo_postal;

        // determine desired output size (clamped to configured min/max)
        $outSize = (int) $request->input('avatar_output_size', 300);
        $minOut = (int) config('avatar.crop_min', 100);
        $maxOut = (int) config('avatar.crop_max', 800);
        if ($outSize < $minOut) $outSize = $minOut;
        if ($outSize > $maxOut) $outSize = $maxOut;

        if ($request->hasFile('avatar')) {
            if ($registro->avatar && file_exists(public_path('uploads/avatars/' . $registro->avatar))) {
                unlink(public_path('uploads/avatars/' . $registro->avatar));
            }
            $file = $request->file('avatar');
            $ext = strtolower($file->getClientOriginalExtension());
            $ext = in_array($ext, ['jpg','jpeg','png','webp']) ? $ext : 'jpg';
            $filename = time() . '_' . $registro->getKey() . '.' . $ext;
            // ensure directory exists
            $dir = public_path('uploads/avatars');
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            try {
                $img = Image::make($file->getRealPath())->orientate();
                // ensure it covers and crop to desired square size
                $img->fit($outSize, $outSize, function ($constraint) {
                    // allow upscaling so small images are enlarged to cover
                }, 'center');
                // optimize quality
                if (in_array($ext, ['jpg','jpeg'])) {
                    $img->encode('jpg', 80);
                } elseif ($ext === 'webp') {
                    $img->encode('webp', 80);
                } else {
                    $img->encode('png');
                }
                $img->save($dir . DIRECTORY_SEPARATOR . $filename);
                $registro->avatar = $filename;
            } catch (\Throwable $e) {
                // fallback to simple move
                $file->move($dir, $filename);
                $registro->avatar = $filename;
            }
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
                $dir = public_path('uploads/avatars');
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                try {
                    $img = Image::make($decoded)->orientate();
                    $img->fit($outSize, $outSize, function ($constraint) {}, 'center');
                    if (in_array($ext, ['jpg','jpeg'])) {
                        $img->encode('jpg', 80);
                    } elseif ($ext === 'webp') {
                        $img->encode('webp', 80);
                    } else {
                        $img->encode('png');
                    }
                    $img->save($dir . DIRECTORY_SEPARATOR . $filename);
                    $registro->avatar = $filename;
                } catch (\Throwable $e) {
                    file_put_contents($dir . DIRECTORY_SEPARATOR . $filename, $decoded);
                    $registro->avatar = $filename;
                }
            }
        }

        if ($request->filled('password')) {
            $registro->password = Hash::make($request->password);
        }
        $registro->save();

        // If the client expects JSON (AJAX request), return a JSON response with avatar URL
        if ($request->wantsJson() || $request->expectsJson() || $request->ajax()) {
            $avatarUrl = $registro->avatar ? asset('uploads/avatars/' . $registro->avatar) : null;
            return response()->json([
                'success' => true,
                'saved' => true,
                'avatar_url' => $avatarUrl,
                'user' => ['id' => $registro->getKey(), 'name' => $registro->name]
            ]);
        }

        return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado correctamente.');
    }
}
