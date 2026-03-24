@extends('web.app')

@section('title', 'Método no permitido')

@section('contenido')
<section class="d-flex align-items-center justify-content-center" style="min-height: 80vh; background: #1a0e07;">
    <div class="text-center">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="max-width: 120px; margin-bottom: 2rem;">
        <h1 class="display-4 fw-bold" style="color: #ff9900;">405</h1>
        <h2 class="mb-3" style="color: #fff;">Método no permitido</h2>
        <p class="lead mb-4" style="color: #bfa77a;">
            Lo sentimos, la acción que intentaste no está permitida.<br>
            Por favor, navega usando los botones y formularios del sitio.
        </p>
        <a href="{{ route('web.index') }}" class="btn btn-warning px-4" style="background:#d87c23; border:none; color:#fff; font-weight:600; border-radius:12px;">
            <i class="bi bi-house-door me-1"></i> Ir al inicio
        </a>
    </div>
</section>
@endsection
