@extends('web.app')

@section('titulo', 'Lista de Deseados - DiscZone')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/wishlist-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/index-section.css') }}">
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 mt-5 wishlist-container">
    <section class="wishlist-hero p-4 p-lg-5 mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold mb-2 wishlist-title">Tus discos deseados</h1>
                <p class="mb-0 hero-subtitle">Guarda tus favoritos para no perderlos de vista y comprarlos después.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('web.index') }}" class="btn btn-light px-4 wishlist-back-btn">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la tienda
                </a>
            </div>
        </div>
    </section>

    <div class="wishlist-section rounded shadow-sm p-4">
        <h2 class="text-center mb-4 wishlist-section-title">Lista de Deseados</h2>
        @if(auth()->check() && \Illuminate\Support\Facades\Schema::hasTable('wishlists'))
            @php
                $items = \App\Models\Wishlist::where('user_id', auth()->id())->with('producto')->get();
            @endphp
            @if($items->isNotEmpty())
                <div class="row wishlist-list">
                    @foreach($items as $entry)
                        @php $p = $entry->producto; @endphp
                        @if(!$p) @continue @endif
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 wishlist-item-col">
                            <article class="all-product-card">
                                <div class="all-product-cover">
                                    @if(!empty($p->imagen))
                                        <img src="{{ asset('uploads/productos/' . $p->imagen) }}" alt="{{ $p->nombre }}">
                                    @else
                                        <img src="{{ asset('img/no-image.svg') }}" alt="Sin imagen" width="400" height="300" loading="lazy">
                                    @endif
                                    <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                </div>
                                <div class="all-product-body">
                                    <p class="all-product-name" title="{{ $p->nombre }}">{{ $p->nombre }}</p>
                                    <p class="all-product-artist">{{ $p->artista?->nombre ?? '' }}</p>
                                    <div class="all-product-meta"></div>
                                    <div class="all-product-inline-stats">
                                        <span><i class="bi bi-star-fill text-warning me-1"></i>0.0</span>
                                        <span><i class="bi bi-chat-left-text me-1"></i>0</span>
                                        <span><i class="bi bi-box-seam me-1"></i>{{ $p->cantidad ?? 0 }}</span>
                                    </div>
                                    <button type="button" class="all-product-wishlist-btn js-wishlist-toggle" data-product-id="{{ $p->getKey() }}" title="Quitar de deseados">
                                        <i class="bi bi-heart-fill text-danger"></i>
                                    </button>
                                    <a href="{{ route('web.show', $p->getKey()) }}" class="all-product-cta" title="Ver producto">
                                        <i class="bi bi-eye"></i> ver
                                    </a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-muted wishlist-empty">No hay productos en la lista de deseados.</p>
            @endif
        @else
            @if(session('wishlist') && count(session('wishlist')) > 0)
                <div class="row wishlist-list">
                    @foreach(session('wishlist') as $item)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 wishlist-item-col">
                            <article class="all-product-card">
                                <div class="all-product-cover">
                                    @if(!empty($item['imagen']))
                                        <img src="{{ asset('uploads/productos/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}">
                                    @else
                                        <img src="{{ asset('img/no-image.svg') }}" alt="Sin imagen" width="400" height="300" loading="lazy">
                                    @endif
                                    <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                </div>
                                <div class="all-product-body">
                                    <p class="all-product-name" title="{{ $item['nombre'] }}">{{ $item['nombre'] }}</p>
                                    <p class="all-product-artist">{{ $item['artista'] ?? '' }}</p>
                                    <div class="all-product-meta"></div>
                                    <div class="all-product-inline-stats">
                                        <span><i class="bi bi-star-fill text-warning me-1"></i>0.0</span>
                                        <span><i class="bi bi-chat-left-text me-1"></i>0</span>
                                        <span><i class="bi bi-box-seam me-1"></i>{{ $item['cantidad'] ?? 0 }}</span>
                                    </div>
                                    <button type="button" class="all-product-wishlist-btn js-wishlist-toggle" data-product-id="{{ $item['id'] }}" title="Quitar de deseados">
                                        <i class="bi bi-heart-fill text-danger"></i>
                                    </button>
                                    <a href="{{ route('web.show', $item['id']) }}" class="all-product-cta" title="Ver producto">
                                        <i class="bi bi-eye"></i> ver
                                    </a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-muted wishlist-empty">No hay productos en la lista de deseados.</p>
            @endif
        @endif
    </div>
</div>
@endsection
