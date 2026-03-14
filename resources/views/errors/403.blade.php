@extends('plantilla.app')
@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card mb-4" style="border-radius:1rem; overflow:hidden;">
                    <div class="card-header bg-danger text-white py-3">
                        <h3 class="card-title mb-0">Acceso no autorizado</h3>
                    </div>
                    <div class="card-body p-4">
                        <p class="mb-2 fw-semibold">No tienes permisos para acceder a esta seccion.</p>
                        <p class="mb-4 text-muted">
                            Si intentaste entrar a Estadisticas, esta pantalla solo esta disponible para usuarios con rol de administrador.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="bi bi-speedometer2 me-1"></i>Ir al dashboard
                            </a>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection