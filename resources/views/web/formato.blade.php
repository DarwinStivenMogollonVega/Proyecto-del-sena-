@extends('web.app')

@section('titulo', $formato->nombre . ' - DiscZone')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/dz-responsive.css') }}">
<link rel="stylesheet" href="{{ asset('css/formato-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/header-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush
@section('header')
@include('web.partials.nav')
@endsection
@section('contenido')
<div class="container px-4 px-lg-5">
    <section id="inicio" class="store-hero p-4 p-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="store-hero-brand">
                    <!-- Logo removido por solicitud -->
                </div>
                <h1 class="display-6 fw-bold mb-2">Descubre tu proximo disco favorito</h1>
                <p class="mb-0 hero-subtitle">Explora el formato, compara precios y encuentra nuevas joyas para tu coleccion.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                <a href="#productos" class="btn btn-light px-4">
                    <i class="bi bi-vinyl-fill me-1"></i> Explorar ahora
                </a>
            </div>
        </div>
    </section>
    <!-- Separador visual -->
    <hr class="d-none d-md-block mb-4">

    <div class="row g-3 mt-2 mb-4">
        <div class="col-6 col-md-3"><div class="metric-pill"><strong>{{ $productos->count() }}</strong><span>Productos</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong>{{ $productos->where('cantidad', '>', 0)->count() }}</strong><span>Disponibles</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong>{{ $productos->unique('categoria_id')->count() }}</strong><span>Categorías</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong>1</strong><span>Formato</span></div></div>
    </div>

<form method="GET" action="{{ route('web.formato.show', $formato->getKey()) }}" class="search-panel p-3 p-md-4 mt-4">
    <div class="row align-items-end g-3">
        <div class="col-md-8">
            <label class="form-label fw-semibold" for="searchInput">Buscar por nombre</label>
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" id="searchInput" placeholder="Ejemplo: Rock Clasico" name="search" value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold" for="sortSelect">Ordenar resultados</label>
            <div class="input-group">
                <select class="form-select" id="sortSelect" name="sort" onchange="this.form.submit()">
                    <option value="">Orden predeterminado</option>
                    <option value="priceAsc" {{ request('sort') == 'priceAsc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                    <option value="priceDesc" {{ request('sort') == 'priceDesc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                </select>
                <button class="btn btn-dark" type="submit">Aplicar</button>
            </div>
        </div>
    </div>
</form>

<section class="all-products-section mt-5">
    <div class="all-products-head d-flex align-items-center" style="gap:0.7rem;">
        <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-grid-3x3-gap-fill me-2"></i>Productos del formato
            <span class="section-badge ms-2">{{ $productos->total() }} registrados</span>
        </h4>
    </div><br>

    @if ($productos->count())
        <div class="all-products-grid">
            @foreach ($productos as $producto)
                @php
                    $ratingAll = (float) ($producto->resenas_avg_puntuacion ?? 0);
                    $reviewsAll = (int) ($producto->resenas_count ?? 0);
                    $stockAll = (int) ($producto->cantidad ?? 0);
                @endphp
                <article class="all-product-card">
                    <div class="all-product-cover">
                        @if($producto->imagen)
                            <img src="{{ asset('uploads/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                        @else
                            <img src="{{ asset('img/no-image.svg') }}" alt="Sin imagen" width="400" height="300" loading="lazy">
                        @endif

                        @if ($stockAll >= 50)
                            <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                        @elseif ($stockAll > 0)
                            <span class="all-product-stock badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                        @else
                            <span class="all-product-stock badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                        @endif
                    </div>

                    <div class="all-product-body">
                        <p class="all-product-name" title="{{ $producto->nombre }}">{{ $producto->nombre }}</p>
                        <p class="all-product-artist">{{ $producto->artista?->nombre ?? 'Artista no especificado' }}</p>
                        @if ($stockAll >= 50)
                            <span class="all-product-discount"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                        @elseif ($stockAll > 0)
                            @if(!empty($producto->descuento) && $producto->descuento > 0)
                                <p class="all-product-discount carousel-price">
                                    <i class="bi bi-tag-fill me-1"></i>
                                    ${{ number_format($producto->precio * (1 - ($producto->descuento/100)), 2) }}
                                    <span class="text-decoration-line-through text-muted ms-2">${{ number_format($producto->precio, 2) }}</span>
                                    <span class="badge bg-warning text-dark ms-2">- {{ number_format($producto->descuento, 2) }}% descuento</span>
                                </p>
                            @else
                                <span class="all-product-discount"><i class="bi bi-tag-fill me-1"></i>${{ number_format($producto->precio, 2) }}</span>
                            @endif
                        @else
                            <span class="all-product-discount"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                        @endif
                        <div class="all-product-meta">
                            @if($producto->categoria)
                                <span class="all-product-chip"><i class="bi bi-tags-fill me-1"></i>{{ $producto->categoria->nombre }}</span>
                            @endif
                            @if($producto->formato)
                                <span class="all-product-chip"><i class="bi bi-journal-bookmark-fill me-1"></i>{{ $producto->formato->nombre }}</span>
                            @endif
                        </div>
                        <div class="all-product-inline-stats">
                            <span><i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($ratingAll, 1) }}</span>
                            <span><i class="bi bi-chat-left-text me-1"></i>{{ $reviewsAll }}</span>
                            <span><i class="bi bi-box-seam me-1"></i>{{ $stockAll }}</span>
                        </div>
                        @php
                            if (auth()->check() && \Illuminate\Support\Facades\Schema::hasTable('lista_deseos')) {
                                $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('producto_id', $producto->getKey())->exists();
                            } else {
                                $inWishlist = session('wishlist') && array_key_exists($producto->getKey(), session('wishlist'));
                            }
                        @endphp
                        <button type="button" class="all-product-wishlist-btn js-wishlist-toggle" data-product-id="{{ $producto->getKey() }}" title="Agregar a deseados">
                            <i class="bi {{ $inWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                        </button>
                        <a href="{{ route('web.show', $producto->getKey()) }}" class="all-product-cta" title="Ver producto">
                            <i class="bi bi-eye"></i> ver
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $productos->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-4 text-muted">No se encontraron productos para mostrar.</div>
    @endif
</section>

    @endsection
