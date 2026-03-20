@extends('autenticacion.app')
@section('titulo', 'DiscZone - Restablecer contrasena')
@push('estilos')
<style>
  /* Modo oscuro inspirado en perfil */
  html[data-theme='dark'] .auth-shell {
    background: radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.15), transparent 30%), radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.14), transparent 28%), linear-gradient(180deg, rgba(31, 41, 55, 0.65), rgba(17, 24, 39, 0));
  }
  html[data-theme='dark'] .auth-card {
    background: #111827;
    border-color: #334155;
    box-shadow: 0 12px 24px rgba(2, 6, 23, 0.55);
  }
  html[data-theme='dark'] .auth-form-panel {
    background: transparent;
  }
  html[data-theme='dark'] .auth-summary-panel {
    background: linear-gradient(130deg, #111827 0%, #7c2d12 52%, #0f172a 100%);
    color: #fff;
  }
  html[data-theme='dark'] .summary-title,
  html[data-theme='dark'] .summary-copy,
  html[data-theme='dark'] .summary-pill strong,
  html[data-theme='dark'] .summary-pill span,
  html[data-theme='dark'] .summary-list li {
    color: #fff !important;
  }
</style>
@endpush
@section('contenido')
<div class="auth-shell">
  <section class="auth-form-panel">
    <div class="auth-card p-4 p-lg-5">
      <a href="{{ route('web.index') }}" class="auth-brand mb-4">
        <span class="auth-brand-mark"><i class="bi bi-vinyl-fill"></i></span>
        <span>
          <strong class="d-block fs-4">DiscZone</strong>
          <small class="auth-copy">Nueva contrasena</small>
        </span>
      </a>

      <div class="mb-4">
        <h1 class="h3 auth-heading mb-2">Restablecer contrasena</h1>
        <p class="login-box-msg text-start mb-0">Define una nueva clave para recuperar el acceso a tu cuenta y seguir comprando con normalidad.</p>
      </div>

      @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('password.update') }}" method="post" class="mt-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="loginEmail" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="correo@ejemplo.com" />
            <label for="loginEmail">Correo electronico</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>
        @error('email')
          <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
        @enderror

        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="loginPassword" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nueva contrasena" />
            <label for="loginPassword">Nueva contrasena</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>
        @error('password')
          <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
        @enderror

        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmar contrasena" />
            <label for="password_confirmation">Confirmar contrasena</label>
          </div>
          <div class="input-group-text"><span class="bi bi-shield-lock"></span></div>
        </div>
        @error('password_confirmation')
          <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
        @enderror

        <div class="d-grid mb-3">
          <button type="submit" class="btn auth-btn-primary">Actualizar contrasena</button>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2">
          <span class="auth-copy">Quieres volver al acceso principal?</span>
          <a href="{{ route('login') }}" class="auth-link fw-semibold">Ir al login</a>
        </div>
      </form>
    </div>
  </section>

  <aside class="auth-summary-panel">
    <div>
      <span class="summary-kicker"><i class="bi bi-key-fill"></i> Restablecimiento</span>
      <h2 class="summary-title mt-3 mb-3">Vuelve a entrar y continua donde dejaste tu experiencia en DiscZone.</h2>
      <p class="summary-copy mb-4">Una vez cambies tu contrasena, podras seguir gestionando tus pedidos, revisar tu carrito y explorar nuevas colecciones desde tu cuenta.</p>

      <div class="summary-grid mb-4">
        <div class="summary-pill">
          <strong>Acceso renovado</strong>
          <span>Actualiza tu clave y protege mejor tu perfil.</span>
        </div>
        <div class="summary-pill">
          <strong>Sin perder historial</strong>
          <span>Tus pedidos y datos seguiran disponibles al iniciar sesion.</span>
        </div>
      </div>
    </div>

    <div>
      <ul class="summary-list mb-4">
        <li><i class="bi bi-check2-circle"></i><span>Recuperas el acceso a tu cuenta de forma guiada.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Podras retomar compras, carrito y seguimiento de pedidos.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>La vista mantiene el mismo lenguaje visual del login renovado.</span></li>
      </ul>

      <a href="{{ route('web.index') }}" class="summary-cta">
        <i class="bi bi-arrow-left"></i>
        Volver a la tienda
      </a>
    </div>
  </aside>
</div>
@endsection

      