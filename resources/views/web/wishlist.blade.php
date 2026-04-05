@extends('web.app')

@section('hide_nav')@endsection

@section('titulo', 'Lista de Deseados - DiscZone')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/wishlist-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/index-section.css') }}">

@endpush
@include('web.partials.nav')
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
                                    @php $stock = (int) ($p->cantidad ?? 0); @endphp
                                    @if ($stock >= 50)
                                        <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                    @elseif ($stock > 0)
                                        <span class="all-product-stock badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                                    @else
                                        <span class="all-product-stock badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                    @endif
                                </div>
                                <div class="all-product-body">
                                    @php
                                        $rating = round((float) ($p->resenas_avg_puntuacion ?? 0), 1);
                                        $rCount = (int) ($p->resenas_count ?? 0);
                                        $stock = (int) ($p->cantidad ?? 0);
                                    @endphp
                                    <p class="all-product-name" title="{{ $p->nombre }}">{{ $p->nombre }}</p>
                                    <p class="all-product-artist">{{ $p->artista?->nombre ?? '' }}</p>

                                    @if ($stock >= 50)
                                        <span class="all-product-discount"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                    @elseif ($stock > 0)
                                        <span class="all-product-discount"><i class="bi bi-tag-fill me-1"></i>${{ number_format(($p->precio - ($p->descuento ?? 0)), 2) }}</span>
                                    @else
                                        <span class="all-product-discount"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                    @endif

                                    <div class="all-product-meta">
                                        @if($p->categoria)
                                            <span class="all-product-chip"><i class="bi bi-tags-fill me-1"></i>{{ $p->categoria->nombre }}</span>
                                        @endif
                                        @if($p->formato)
                                            <span class="all-product-chip"><i class="bi bi-journal-bookmark-fill me-1"></i>{{ $p->formato->nombre }}</span>
                                        @endif
                                    </div>

                                    <div class="all-product-inline-stats">
                                        <span><i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($rating, 1) }}</span>
                                        <span><i class="bi bi-chat-left-text me-1"></i>{{ $rCount }}</span>
                                        <span><i class="bi bi-box-seam me-1"></i>{{ $stock }}</span>
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
                                    @php $stock = (int) ($item['cantidad'] ?? 0); @endphp
                                    @if ($stock >= 50)
                                        <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                    @elseif ($stock > 0)
                                        <span class="all-product-stock badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                                    @else
                                        <span class="all-product-stock badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                    @endif
                                </div>
                                <div class="all-product-body">
                                    @php
                                        $stock = (int) ($item['cantidad'] ?? 0);
                                        $rating = isset($item['resenas_avg_puntuacion']) ? round((float) $item['resenas_avg_puntuacion'], 1) : 0.0;
                                        $rCount = (int) ($item['resenas_count'] ?? 0);
                                    @endphp
                                    <p class="all-product-name" title="{{ $item['nombre'] }}">{{ $item['nombre'] }}</p>
                                    <p class="all-product-artist">{{ $item['artista'] ?? '' }}</p>

                                    @if ($stock >= 50)
                                        <span class="all-product-discount"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                    @elseif ($stock > 0)
                                        <span class="all-product-discount"><i class="bi bi-tag-fill me-1"></i>${{ number_format(($item['precio'] ?? 0) - ($item['descuento'] ?? 0), 2) }}</span>
                                    @else
                                        <span class="all-product-discount"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                    @endif

                                    <div class="all-product-meta"></div>

                                    <div class="all-product-inline-stats">
                                        <span><i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($rating, 1) }}</span>
                                        <span><i class="bi bi-chat-left-text me-1"></i>{{ $rCount }}</span>
                                        <span><i class="bi bi-box-seam me-1"></i>{{ $stock }}</span>
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
