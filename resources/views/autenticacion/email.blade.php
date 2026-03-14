@extends('autenticacion.app')
@section('titulo', 'DiscZone - Recuperar contrasena')
@section('contenido')
<div class="auth-shell">
  <section class="auth-form-panel">
    <div class="auth-card p-4 p-lg-5">
      <a href="{{ route('web.index') }}" class="auth-brand mb-4">
        <span class="auth-brand-mark"><i class="bi bi-vinyl-fill"></i></span>
        <span>
          <strong class="d-block fs-4">DiscZone</strong>
          <small class="auth-copy">Recuperacion de acceso</small>
        </span>
      </a>

      <div class="mb-4">
        <h1 class="h3 auth-heading mb-2">Recuperar contrasena</h1>
        <p class="login-box-msg text-start mb-0">Ingresa tu correo y te enviaremos un enlace para restablecer el acceso a tu cuenta.</p>
      </div>

      @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif

      @if(Session::has('mensaje'))
        <div class="alert alert-info alert-dismissible fade show mt-2">
          {{ Session::get('mensaje') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
      @endif

      <form action="{{ route('password.send-link') }}" method="post" class="mt-4">
        @csrf
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

        <div class="d-grid mb-3">
          <button type="submit" class="btn auth-btn-primary">Enviar enlace de recuperacion</button>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2">
          <span class="auth-copy">Recordaste tu clave?</span>
          <a href="{{ route('login') }}" class="auth-link fw-semibold">Volver al login</a>
        </div>
      </form>
    </div>
  </section>

  <aside class="auth-summary-panel">
    <div>
      <span class="summary-kicker"><i class="bi bi-shield-lock-fill"></i> Acceso seguro</span>
      <h2 class="summary-title mt-3 mb-3">Recupera tu cuenta sin perder el seguimiento de tus compras.</h2>
      <p class="summary-copy mb-4">El proceso de recuperacion te permite volver a entrar para revisar pedidos, continuar con tu carrito y administrar tu perfil dentro de DiscZone.</p>

      <div class="summary-grid mb-4">
        <div class="summary-pill">
          <strong>Correo verificado</strong>
          <span>El enlace llega al email asociado a tu cuenta.</span>
        </div>
        <div class="summary-pill">
          <strong>Recuperacion rapida</strong>
          <span>Puedes restablecer tu acceso en pocos pasos.</span>
        </div>
      </div>
    </div>

    <div>
      <ul class="summary-list mb-4">
        <li><i class="bi bi-check2-circle"></i><span>Retoma tus pedidos pendientes y tu historial de compras.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Protege tu cuenta con una nueva contrasena.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Mantiene la misma experiencia visual y de lectura del login.</span></li>
      </ul>

      <a href="{{ route('web.index') }}" class="summary-cta">
        <i class="bi bi-arrow-left"></i>
        Volver a la tienda
      </a>
    </div>
  </aside>
</div>
@endsection