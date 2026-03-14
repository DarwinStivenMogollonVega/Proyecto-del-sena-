@extends('autenticacion.app')
@push('estilos')
<style>
  .login-brand .auth-brand-mark-full {
    width: min(15rem, 62vw);
    height: 4.2rem;
    padding: 0.28rem 0.4rem;
  }

  .login-brand .auth-brand-mark-icon {
    width: 3.4rem;
    height: 3.4rem;
  }

  @media (max-width: 575.98px) {
    .login-brand .auth-brand-mark-icon {
      width: 4rem;
      height: 4rem;
    }
  }
</style>
@endpush
@section('titulo', 'DisMusic - Login')
@section('contenido')
<div class="auth-shell">
  <section class="auth-form-panel">
    <div class="auth-card p-4 p-lg-5">
      <a href="{{ route('web.index') }}" class="auth-brand login-brand mb-4">
        <span class="auth-brand-mark auth-brand-mark-full">
          <img
            src="{{ asset('logo_proyecto_con_nombre-removebg-preview.png') }}"
            alt="DisMusic"
            class="auth-brand-icon"
            onerror="this.onerror=null;this.src='{{ asset('logo_proyecto-removebg-preview.png') }}';"
          >
        </span>
        <span class="auth-brand-mark auth-brand-mark-icon">
          <img
            src="{{ asset('logo_proyecto-removebg-preview.png') }}"
            alt="DisMusic"
            class="auth-brand-icon"
            onerror="this.onerror=null;this.src='{{ asset('assets/img/AdminLTELogo.png') }}';"
          >
        </span>
      </a>

      <div class="mb-4">
        <h1 class="h3 auth-heading mb-2">Inicia sesion</h1>
        <p class="login-box-msg text-start mb-0">Accede a tus pedidos, carrito y perfil para continuar tu compra.</p>
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

      <form action="{{ route('login.post') }}" method="post" class="mt-4">
        @csrf
        <div class="input-group mb-3">
          <div class="form-floating">
            <input id="loginEmail" type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="correo@ejemplo.com" />
            <label for="loginEmail">Correo electronico</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>

        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="loginPassword" type="password" name="password" class="form-control" placeholder="Contrasena" />
            <label for="loginPassword">Contrasena</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
          <small class="auth-copy">Tu acceso esta protegido y vinculado a tus compras.</small>
          <a class="auth-link" href="{{ route('password.request') }}">Recuperar contrasena</a>
        </div>

        <div class="d-grid mb-3">
          <button type="submit" class="btn auth-btn-primary">Entrar a DisMusic</button>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2">
          <span class="auth-copy">Prefieres seguir explorando primero?</span>
          <a href="{{ route('web.index') }}" class="auth-link fw-semibold">Volver a la tienda</a>
        </div>
      </form>
    </div>
  </section>

  <aside class="auth-summary-panel">
    <div>
      <h2 class="summary-title mt-3 mb-3">Tu tienda para descubrir, guardar y comprar discos sin perder el hilo.</h2>
      <p class="summary-copy mb-4">Desde aqui puedes entrar a tu cuenta y retomar tu experiencia: revisar productos, seguir tus pedidos y completar compras con rapidez.</p>

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
          <span>Retoma tu seleccion y finaliza la compra rapido.</span>
        </div>
        <div class="summary-pill">
          <strong>Pedidos</strong>
          <span>Consulta estados y el historial de tus compras.</span>
        </div>
      </div>
    </div>

    <div>
      <ul class="summary-list mb-4">
        <li><i class="bi bi-check2-circle"></i><span>Acceso directo a tu perfil y a tus pedidos recientes.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Colores y estilo alineados con la experiencia principal de la pagina.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Diseno adaptable para escritorio y movil sin perder legibilidad.</span></li>
      </ul>
    </div>
  </aside>
</div>
@endsection

