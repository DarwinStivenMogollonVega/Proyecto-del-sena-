@extends('web.app')
@section('titulo', $categoria->nombre . ' - DiscZone')

@push('estilos')
<style>
    .categoria-hero {
        background: linear-gradient(135deg, #fdf2ea 0%, #f8d8bc 55%, #fdeee0 100%);
        border: 1px solid #e8cfc0;
        border-radius: 1rem;
        color: var(--dz-heading);
        overflow: hidden;
        position: relative;
        box-shadow: 0 20px 40px -24px rgba(196, 99, 16, 0.28);
    }

    .categoria-hero h1 {
        color: #200c03;
    }

    .categoria-hero .hero-subtitle {
        color: #8a6a5c;
    }

    .categoria-hero::after {
        content: '';
        position: absolute;
        right: -70px;
        top: -80px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(196, 99, 16, 0.12);
    }

    .categoria-filter {
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        background: var(--dz-surface);
        box-shadow: 0 10px 24px rgba(46, 18, 6, 0.06);
    }

    .categoria-card {
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .categoria-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(196, 99, 16, 0.15);
    }

    .categoria-card .card-img-top {
        height: 250px;
        object-fit: cover;
    }

    .categoria-title {
        color: var(--dz-heading);
        font-weight: 700;
    }

    .categoria-card .card-body {
        color: var(--dz-text);
    }

    .categoria-card .price-label,
    .categoria-card .text-success {
        color: #c46310;
    }

    html[data-theme='dark'] .categoria-hero {
        background: linear-gradient(135deg, #160800 0%, #c46310 55%, #4d2010 100%);
        border-color: rgba(255,255,255,0.10);
        color: #fdf0e4;
        box-shadow: 0 20px 40px -24px rgba(0,0,0,0.65);
    }

    html[data-theme='dark'] .categoria-hero h1 {
        color: #fdf0e4;
    }

    html[data-theme='dark'] .categoria-hero .hero-subtitle {
        color: rgba(253, 240, 228, 0.80);
    }

    html[data-theme='dark'] .categoria-filter,
    html[data-theme='dark'] .categoria-card {
        background: #1a0800;
        border-color: #3d1e0a;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.55);
    }

    html[data-theme='dark'] .categoria-title,
    html[data-theme='dark'] .categoria-card .card-body,
    html[data-theme='dark'] .categoria-card h5,
    html[data-theme='dark'] .categoria-card .text-muted {
        color: #f0e0d2 !important;
    }

    html[data-theme='dark'] .categoria-card .text-success {
        color: #e07a30 !important;
    }

    html[data-theme='dark'] .categoria-filter .form-control::placeholder {
        color: #c4a898;
    }

    @media (max-width: 575.98px) {
        .categoria-card .card-img-top {
            height: 210px;
        }

        .categoria-filter .input-group {
            flex-wrap: wrap;
        }

        .categoria-filter .input-group > * {
            width: 100%;
        }
    }
</style>
@endpush
@section('header')
@endsection
@section('contenido')
<div class="container px-4 px-lg-5 mt-4">
    <div class="categoria-hero p-4 p-lg-5 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold mb-1">{{ $categoria->nombre }}</h1>
                <p class="mb-0 hero-subtitle">Explora productos de esta categoria con filtros rapidos.</p>
            </div>
            <a href="{{ route('web.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left me-1"></i> Volver al inicio
            </a>
        </div>
    </div>
</div>

<form method="GET" action="{{ route('web.categoria.show', $categoria->id) }}">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="categoria-filter p-3 p-md-4">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Buscar productos..."
                            aria-label="Buscar productos" name="search" value="{{ request('search') }}">
                        <button class="btn btn-outline-dark" type="submit" id="searchButton">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="sortSelect">Ordenar por:</label>
                        <select class="form-select" id="sortSelect" name="sort" onchange="this.form.submit()">
                            <option value="">Seleccionar...</option>
                            <option value="priceAsc" {{ request('sort') == 'priceAsc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                            <option value="priceDesc" {{ request('sort') == 'priceDesc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="container mt-5">
    <h2 class="text-center mb-4 categoria-title">Productos de {{ $categoria->nombre }}</h2>

    @if($productos->count())
        <div class="row">
            @foreach ($productos as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card categoria-card h-100 shadow-sm position-relative">
                        @if($producto->imagen)
                            <img src="{{ asset('uploads/productos/' . $producto->imagen) }}" 
                                 class="card-img-top" alt="{{ $producto->nombre }}">
                        @else
                            <img src="{{ asset('img/no-image.jpg') }}" class="card-img-top" alt="Sin imagen">
                        @endif

                        <div class="card-body text-center">
                            <h5 class="fw-bolder">{{ $producto->nombre }}</h5>

                      @php
        $stock = $producto->cantidad ?? 0;
    @endphp

    @if ($stock >= 50)
        <span class="badge bg-success position-absolute top-0 start-0 m-2 p-2 rounded-3 shadow">
          <i class="bi bi-check-circle me-1"></i>
            Producto disponible
        </span>
    @elseif ($stock >= 10 && $stock < 50)
        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 p-2 rounded-3 shadow">
          <i class="bi bi-exclamation-circle me-1"></i>
            Pocas unidades
        </span>
    @elseif ($stock == 0)
        <span class="badge bg-danger position-absolute top-0 start-0 m-2 p-2 rounded-3 shadow">
          <i class="bi bi-x-circle me-1"></i>
            Agotado
        </span>
    @endif

                            <!-- Badges con íconos -->
                            <p class="mb-1 text-muted small">
                                @if($producto->categoria)
                                    <span class="badge bg-primary">
                                        <i class="bi bi-tags-fill me-1"></i>{{ $producto->categoria->nombre }}
                                    </span>
                                @endif
                                @if($producto->catalogo)
                                    <span class="badge bg-danger ms-1">
                                        <i class="bi bi-bookmark-fill me-1"></i>{{ $producto->catalogo->nombre }}
                                    </span>
                                @endif
                            </p>

                            <p class="fw-bold text-success mb-2">
                                ${{ number_format($producto->precio, 2) }}
                            </p>

                            <!-- Botón Ver producto -->
                            <a href="{{ route('web.show', $producto->id) }}" class="btn btn-outline-dark flex-shrink-0">
                                <i class="bi bi-eye me-1"></i> Ver producto
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $productos->appends(request()->query())->links() }}
        </div>
    @else
        <p class="text-center text-muted">No hay productos en esta categoría.</p>
    @endif
</div>
@endsection
