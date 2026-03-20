@extends('autenticacion.app')
@section('titulo', 'Login Simple')
@section('contenido')
<div class="auth-card p-4 p-lg-5 mx-auto" style="max-width:400px;">
  <h2 class="mb-3">Iniciar sesión</h2>
  <form action="{{ route('login.post') }}" method="post">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Entrar</button>
  </form>
  <div class="mt-3">
    <small class="auth-copy">Tu acceso está protegido y vinculado a tus compras.</small><br>
    <a class="auth-link" href="{{ route('password.request') }}">Recuperar contraseña</a>
    <br>
    <a class="auth-link" href="{{ route('registro') }}">Registrarse</a>
  </div>
</div>
@endsection