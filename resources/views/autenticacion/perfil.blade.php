@extends('web.app')

@section('titulo', 'Mi perfil - DiscZone')

@push('estilos')
<style>
    .profile-page {
        background: radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.12), transparent 30%), radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.09), transparent 28%), linear-gradient(180deg, rgba(255, 255, 255, 0.72), rgba(255, 255, 255, 0));
        border-radius: 1rem;
        padding-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .profile-hero {
        margin-top: 1.5rem;
        border-radius: 1rem;
        color: #fff;
        padding: 2rem;
        background: radial-gradient(circle at 14% 20%, rgba(245, 158, 11, 0.35), transparent 42%), radial-gradient(circle at 82% 15%, rgba(59, 130, 246, 0.2), transparent 35%), linear-gradient(130deg, #111827 0%, #7c2d12 52%, #0f172a 100%);
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.24);
        position: relative;
        overflow: hidden;
    }

    .profile-title-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.8rem;
        background: rgba(255, 255, 255, 0.18);
        margin-right: 0.6rem;
    }

    .profile-card {
        background: var(--dz-surface);
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
    }

    html[data-theme='dark'] .profile-page {
        background: radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.15), transparent 30%), radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.14), transparent 28%), linear-gradient(180deg, rgba(31, 41, 55, 0.65), rgba(17, 24, 39, 0));
    }

    html[data-theme='dark'] .profile-card {
        background: #111827;
        border-color: #334155;
        box-shadow: 0 12px 24px rgba(2, 6, 23, 0.55);
    }

    @media (max-width: 575.98px) {
        .profile-hero {
            padding: 1.25rem;
        }

        .profile-title-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.6rem;
        }
    }
</style>
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
                <a href="{{ route('cliente.dashboard') }}" class="btn btn-light"><i class="bi bi-bar-chart-line me-1"></i> Mi dashboard</a>
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

            <form action="{{ route('perfil.update') }}" method="POST" id="formRegistroUsuario">
                @csrf
                @method('PUT')
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
