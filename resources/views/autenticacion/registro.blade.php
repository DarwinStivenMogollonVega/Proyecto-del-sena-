@extends('autenticacion.app')
@push('estilos')
<style>
  .register-brand .auth-brand-mark-full {
    width: min(15rem, 62vw);
    height: 4.2rem;
    padding: 0.28rem 0.4rem;
  }
  .register-brand .auth-brand-mark-icon {
    width: 3.4rem;
    height: 3.4rem;
  }
  @media (max-width: 575.98px) {
    .register-brand .auth-brand-mark-icon {
      width: 4rem;
      height: 4rem;
    }
  }

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
@section('titulo', 'DisMusic - Registro')
@section('contenido')
<div class="auth-shell">
  <section class="auth-form-panel">
    <div class="auth-card p-4 p-lg-5">
      <a href="{{ route('web.index') }}" class="auth-brand register-brand mb-4">
        <span class="auth-brand-mark auth-brand-mark-full">
          <img src="{{ asset('assets/img/recurso11.png') }}" alt="DisMusic Logo" class="auth-brand-icon light" />
          <img src="{{ asset('assets/img/recurso12.png') }}" alt="DisMusic Logo" class="auth-brand-icon dark" />
        </span>
        <span class="auth-brand-mark auth-brand-mark-icon">
          <img src="{{ asset('assets/img/recurso11.png') }}" alt="DisMusic Logo" class="auth-brand-icon light" />
          <img src="{{ asset('assets/img/recurso12.png') }}" alt="DisMusic Logo" class="auth-brand-icon dark" />
        </span>
      </a>
      <div class="mb-4">
        <h1 class="h3 auth-heading mb-2">Crear cuenta</h1>
        <p class="login-box-msg text-start mb-0">Regístrate para acceder a tus pedidos, carrito y perfil.</p>
      </div>
      @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif
      <form action="{{ route('registro.store') }}" method="post" class="mt-4">
        @csrf
        <div class="input-group mb-3">
          <div class="form-floating">
            <input id="registerName" type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre" required />
            <label for="registerName">Nombre</label>
          </div>
          <div class="input-group-text"><span class="bi bi-person"></span></div>
        </div>
        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <div class="input-group mb-3">
          <div class="form-floating">
            <input id="registerEmail" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="correo@ejemplo.com" required />
            <label for="registerEmail">Correo electrónico</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>
        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="registerPassword" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" required />
            <label for="registerPassword">Contraseña</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>
        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="registerPasswordConfirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmar contraseña" required />
            <label for="registerPasswordConfirmation">Confirmar contraseña</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>
        @error('password_confirmation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <div class="d-grid mb-3">
          <button type="submit" class="btn auth-btn-primary">Registrarse</button>
        </div>
        <div class="mt-3">
          <small class="auth-copy">¿Ya tienes cuenta?</small><br>
          <a class="auth-link" href="{{ route('login') }}">Iniciar sesión</a>
        </div>
      </form>
    </div>
  </section>
  <aside class="auth-summary-panel">
    <div>
      <h2 class="summary-title mt-3 mb-3">Tu tienda para descubrir, guardar y comprar discos sin perder el hilo.</h2>
      <p class="summary-copy mb-4">Regístrate para revisar productos, seguir tus pedidos y completar compras con rapidez.</p>
      <div class="summary-grid mb-4">
        <div class="summary-pill">
          <strong>Catalogos</strong>
          <span>Explora colecciones curadas por estilo o temporada.</span>
        </div>
        <div class="summary-pill">
          <strong>Categorias</strong>
          <span>Filtra por genero, formato o tipo de producto.</span>
        </div>
        <div class="summary-pill">
          <strong>Carrito</strong>
          <span>Retoma tu selección y finaliza la compra rápido.</span>
        </div>
        <div class="summary-pill">
          <strong>Pedidos</strong>
          <span>Consulta estados y el historial de tus compras.</span>
        </div>
      </div>
      <ul class="summary-list mb-4">
        <li><i class="bi bi-check2-circle"></i><span>Acceso directo a tu perfil y a tus pedidos recientes.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Colores y estilo alineados con la experiencia principal de la pagina.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Diseno adaptable para escritorio y movil sin perder legibilidad.</span></li>
      </ul>
    </div>
  </aside>
</div>
@endsection

      