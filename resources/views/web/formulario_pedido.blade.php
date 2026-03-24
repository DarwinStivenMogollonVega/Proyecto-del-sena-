@extends('web.app')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/formulario_pedido_section.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/formulario-pedido-responsive.css') }}">
@endpush
@section('contenido')
<section class="formulario-pedido-wrap py-5" style="margin-top: 0rem;">
    @include('web.partials.checkout_steps', ['currentStep' => 1])

    <div class="container px-4 px-lg-5 my-3 my-lg-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Título y subtítulo fuera de la tarjeta -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-1">Finalizar compra</h2>
                    <p class="mb-0 text-white-50">Completa tus datos para confirmar el pedido y recibir la entrega.</p>
                </div>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('carrito.mostrar') }}" class="btn btn-outline-light btn-lg px-4 shadow-sm fw-semibold rounded-pill">
                            <i class="bi bi-arrow-left me-2"></i> Volver al carrito
                        </a>
                    </div>
                <!-- Tarjeta principal con mayor margen superior -->
                <div class="checkout-card p-4 p-lg-5 mt-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Revisa los datos del formulario:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('pedido.datos.guardar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h5 class="fw-bold mb-4">Información del cliente</h5>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="nombre" class="checkout-label">Nombre completo</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', auth()->user()->name ?? '') }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="email" class="checkout-label">Correo electrónico</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="telefono" class="checkout-label">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', auth()->user()->telefono ?? '') }}" required>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h5 class="fw-bold mb-3">Resumen</h5>
                        <div class="bg-light rounded p-3 mb-4">
                            <span class="text-muted">Nombre:</span> <strong>{{ old('nombre', auth()->user()->name ?? '') }}</strong><br>
                            <span class="text-muted">Correo:</span> <strong>{{ old('email', auth()->user()->email ?? '') }}</strong><br>
                            <span class="text-muted">Teléfono:</span> <strong>{{ old('telefono', auth()->user()->telefono ?? '') }}</strong>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                            <button type="submit" class="btn btn-dark px-4 flex-fill" style="background:#d87c23; border:none; color:#fff; font-weight:600; border-radius:12px;">
                                Continuar a entrega <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>