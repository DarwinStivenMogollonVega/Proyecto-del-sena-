@extends('autenticacion.app')
@push('estilos')
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/registro.css') }}">
@endpush
@section('titulo', 'DisMusic - Registro')
@section('contenido')
<div class="auth-shell">
  <section class="auth-form-panel">
    <div class="auth-card p-4 p-lg-5">
      <a href="{{ route('web.index') }}" class="auth-brand register-brand mb-4">
        <span class="auth-brand-mark auth-brand-mark-full">
          <img src="{{ asset('assets/img/recurso12.png') }}" alt="DisMusic Logo" class="auth-brand-icon dark" />
        </span>
        <span class="auth-brand-mark auth-brand-mark-icon">
          <img src="{{ asset('assets/img/recurso11.png') }}" alt="DisMusic Logo" class="auth-brand-icon light" />
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
      @if($errors->any())
        <div class="alert alert-danger" role="alert">
          <strong>Revisa los siguientes errores:</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form id="registerForm" action="{{ route('registro.store') }}" method="post" class="mt-4">
        @csrf
        <div class="input-group mb-3">
          <div class="form-floating">
            <input id="registerName" type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre" minlength="3" maxlength="100" title="El nombre no puede contener números a menos que tenga al menos 5 palabras." required />
            <label for="registerName">Nombre</label>
          </div>
          <div class="input-group-text"><span class="bi bi-person"></span></div>
        </div>
        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <div id="registerNameClientFeedback" class="invalid-feedback d-none">El nombre no puede contener números a menos que tenga al menos 5 palabras.</div>
        <div class="input-group mb-3">
          <div class="form-floating">
            <input id="registerEmail" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="correo@ejemplo.com" maxlength="100" required />
            <label for="registerEmail">Correo electrónico</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>
        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="registerPassword" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" minlength="8" required />
            <label for="registerPassword">Contraseña</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>
        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="registerPasswordConfirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmar contraseña" minlength="8" required />
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

@push('scripts')
<script>
(() => {
  const nameInput = document.getElementById('registerName');
  const registerForm = document.getElementById('registerForm');
  const nameClientFeedback = document.getElementById('registerNameClientFeedback');
  const passwordInput = document.getElementById('registerPassword');
  const confirmationInput = document.getElementById('registerPasswordConfirmation');

  function nameHasDigitAndTooFewWords(val) {
    const v = (val || '').trim();
    if (!v) return false;
    if (!/\d/.test(v)) return false; // no digits => ok
    const words = v.split(/\s+/).filter(Boolean);
    return words.length < 5;
  }

  nameInput?.addEventListener('input', function () {
    const invalid = nameHasDigitAndTooFewWords(this.value);
    if (invalid) {
      this.classList.add('is-invalid');
      if (nameClientFeedback) { nameClientFeedback.classList.remove('d-none'); }
    } else {
      this.classList.remove('is-invalid');
      if (nameClientFeedback) { nameClientFeedback.classList.add('d-none'); }
    }
  });

  // form submit guard for browsers without JS validation or to give immediate feedback
  registerForm?.addEventListener('submit', function (ev) {
    const v = nameInput ? nameInput.value : '';
    if (nameHasDigitAndTooFewWords(v)) {
      ev.preventDefault(); ev.stopPropagation();
      if (nameInput) nameInput.classList.add('is-invalid');
      if (nameClientFeedback) { nameClientFeedback.classList.remove('d-none'); }
      // focus the field so user can edit
      if (nameInput) nameInput.focus();
      return false;
    }
    return true;
  });

  const validatePasswords = () => {
    if (!passwordInput || !confirmationInput) return;
    if (confirmationInput.value.length > 0 && passwordInput.value !== confirmationInput.value) {
      confirmationInput.classList.add('is-invalid');
    } else {
      confirmationInput.classList.remove('is-invalid');
    }
  };

  passwordInput?.addEventListener('input', validatePasswords);
  confirmationInput?.addEventListener('input', validatePasswords);
})();
</script>
@endpush

      