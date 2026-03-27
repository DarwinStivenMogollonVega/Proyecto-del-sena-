<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $credenciales = $request->validated();

        if(Auth::attempt($credenciales)){
            $request->session()->regenerate();
            $user= Auth::user();

            if($user->activo){
                return redirect()->intended();
            }else{
                Auth::logout();
                return back()
                    ->withErrors(['email' => 'Tu cuenta está inactiva. Contacta con el administrador.'])
                    ->onlyInput('email');
            }
        }
        return back()
            ->withErrors(['email' => 'Las credenciales no son correctas.'])
            ->onlyInput('email');
    }
    
}
