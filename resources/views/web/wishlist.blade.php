@extends('web.app')

@section('titulo', 'Lista de Deseados - DiscZone')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/wishlist-section.css') }}">
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 mt-5">
    <section class="wishlist-hero p-4 p-lg-5 mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold mb-2">Tus discos deseados</h1>
                <p class="mb-0 hero-subtitle">Guarda tus favoritos para no perderlos de vista y comprarlos después.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('web.index') }}" class="btn btn-light px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la tienda
                </a>
            </div>
        </div>
    </section>

    <div class="wishlist-section bg-white rounded shadow-sm p-4">
        <h2 class="text-center mb-4">Lista de Deseados</h2>
        @if(session('wishlist') && count(session('wishlist')) > 0)
            <div class="row">
                @foreach(session('wishlist') as $item)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card wishlist-card h-100 shadow-sm">
                            <img src="{{ asset('uploads/productos/' . ($item['imagen'] ?? 'no-image.jpg')) }}" class="card-img-top" alt="{{ $item['nombre'] }}">
                            <div class="card-body text-center">
                                <h5 class="fw-bolder">{{ $item['nombre'] }}</h5>
                                <span class="d-block mb-2">{{ $item['artista'] ?? '' }}</span>
                                <span class="badge bg-dark mb-2">${{ number_format($item['precio'], 2) }}</span>
                                <a href="{{ route('web.show', $item['id']) }}" class="btn btn-sm btn-outline-primary">Ver producto</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">No hay productos en la lista de deseados.</p>
        @endif
    </div>
</div>
@endsection
