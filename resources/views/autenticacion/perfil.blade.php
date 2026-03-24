@extends('web.app')

@section('titulo', 'Mi perfil - DiscZone')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/perfil-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 pb-5 profile-page">
    <section class="profile-hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1"><span class="profile-title-icon"><i class="bi bi-person-circle"></i></span>Mi perfil</h1>
                <p class="mb-0 text-white-50">Gestiona tus datos personales y seguridad de acceso desde una vista individual para tu cuenta.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('dashboard') }}" class="btn btn-light"><i class="bi bi-bar-chart-line me-1"></i> dashboard</a>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="profile-card p-3 p-lg-4">
            @if (session('mensaje'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('mensaje') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <form action="{{ route('perfil.update') }}" method="POST" id="formRegistroUsuario" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ── Avatar ──────────────────────────────── --}}
                <div class="avatar-upload-wrap">
                    <div class="avatar-ring" id="avatarRing" title="Cambiar foto">
                        @if ($registro->avatar)
                            <img src="{{ asset('uploads/avatars/' . $registro->avatar) }}" id="avatarPreview" alt="Avatar">
                        @else
                            <div class="avatar-initial" id="avatarInitial">{{ strtoupper(mb_substr(trim($registro->name), 0, 1)) }}</div>
                            <img src="" id="avatarPreview" alt="Avatar" style="display:none;">
                        @endif
                        <div class="avatar-overlay"><i class="bi bi-camera-fill"></i></div>
                    </div>
                    <input type="file" name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/webp" class="d-none">
                    <span class="avatar-hint">Haz clic en la imagen para cambiar tu foto de perfil (JPG, PNG o WEBP, máx. 2 MB)</span>
                    <div id="avatarEditOptions" style="display:none; margin-top: 1rem;">
                        <div class="mb-2">Previsualización:</div>
                        <img id="avatarEditPreview" src="" alt="Previsualización" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #f59e0b;">
                        <div class="mt-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="avatarEditCancel">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-sm" id="avatarEditSave">Guardar foto</button>
                        </div>
                    </div>
                    @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $registro->name ?? '') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $registro->email ?? '') }}" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $registro->telefono ?? '') }}" placeholder="Ejemplo: +591 70000000">
                        @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="documento_identidad" class="form-label">Documento de identidad</label>
                        <input type="text" class="form-control @error('documento_identidad') is-invalid @enderror" id="documento_identidad" name="documento_identidad" value="{{ old('documento_identidad', $registro->documento_identidad ?? '') }}" placeholder="CI, DNI o pasaporte">
                        @error('documento_identidad') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', optional($registro->fecha_nacimiento)->format('Y-m-d')) }}">
                        @error('fecha_nacimiento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control @error('ciudad') is-invalid @enderror" id="ciudad" name="ciudad" value="{{ old('ciudad', $registro->ciudad ?? '') }}">
                        @error('ciudad') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pais" class="form-label">Pais</label>
                        <input type="text" class="form-control @error('pais') is-invalid @enderror" id="pais" name="pais" value="{{ old('pais', $registro->pais ?? '') }}">
                        @error('pais') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $registro->direccion ?? '') }}" placeholder="Calle, zona, referencia">
                        @error('direccion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="codigo_postal" class="form-label">Codigo postal</label>
                        <input type="text" class="form-control @error('codigo_postal') is-invalid @enderror" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal', $registro->codigo_postal ?? '') }}">
                        @error('codigo_postal') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Nueva contrasena</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar contrasena</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-outline-secondary me-md-2" href="{{ route('cliente.dashboard') }}">Cancelar</a>
                    <button type="submit" class="btn btn-dark"><i class="bi bi-check2-circle me-1"></i> Actualizar datos</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const ring    = document.getElementById('avatarRing');
    const input   = document.getElementById('avatarInput');
    const preview = document.getElementById('avatarPreview');
    const initial = document.getElementById('avatarInitial');
    const editOptions = document.getElementById('avatarEditOptions');
    const editPreview = document.getElementById('avatarEditPreview');
    const editCancel = document.getElementById('avatarEditCancel');
    const editSave = document.getElementById('avatarEditSave');

    if (!ring || !input) return;

    ring.addEventListener('click', () => input.click());

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            // Previsualización editable
            editPreview.src = e.target.result;
            editOptions.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });

    if (editCancel) {
        editCancel.addEventListener('click', function () {
            input.value = '';
            editOptions.style.display = 'none';
        });
    }
    if (editSave) {
        editSave.addEventListener('click', function () {
            // Guardar la foto (previsualización se aplica)
            preview.src = editPreview.src;
            preview.style.display = 'block';
            if (initial) initial.style.display = 'none';
            editOptions.style.display = 'none';
        });
    }
})();
</script>
@endpush
