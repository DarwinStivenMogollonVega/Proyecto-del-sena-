@extends('web.app')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/item-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush
@include('web.partials.nav')
@section('contenido')
<section class="product-page">
    <div class="container px-4 px-lg-5">
        @if (session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <div class="product-main-card p-3 p-lg-4 mb-4">
            <div class="row gx-4 gx-lg-5 align-items-start">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="product-image-wrap">
                        <img src="{{ asset('uploads/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="small text-muted mb-1">SKU: {{ $producto->codigo }}</div>
                    <h1 class="h2 fw-bold mb-2">{{ $producto->nombre }}</h1>

                    <p class="mb-2">
                        @if($producto->categoria)
                            <span class="badge bg-primary me-1"><i class="bi bi-tags-fill me-1"></i>{{ $producto->categoria->nombre }}</span>
                        @endif
                        @if($producto->formato)
                            <span class="badge bg-danger"><i class="bi bi-bookmark-fill me-1"></i>{{ $producto->formato->nombre }}</span>
                        @endif
                        @if($producto->artista)
                            <span class="badge bg-success ms-2"><i class="bi bi-music-note-beamed me-1"></i>{{ $producto->artista->nombre }}</span>
                        @endif
                        @if($producto->proveedor)
                            <span class="text-muted d-block mt-1">Proveedor: {{ $producto->proveedor->nombre }}</span>
                        @endif
                        @if($producto->anio_lanzamiento)
                            <span class="text-muted d-block">Año: {{ $producto->anio_lanzamiento }}</span>
                        @endif
                    </p>

                    <div class="price-big mb-3">${{ number_format($producto->precio, 2) }}</div>

                    <div class="rating-summary mb-3">
                        <div class="star-view" aria-label="Promedio de calificacion">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= round($promedio) ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                        <strong>{{ number_format($promedio, 1) }}</strong>
                        <span class="text-muted">({{ $totalResenas }} calificaciones)</span>
                    </div>

                    <p class="lead">{{ $producto->descripcion }}</p>

                    <form action="{{ route('carrito.agregar') }}" method="POST" class="d-flex flex-wrap gap-2 align-items-center">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->getKey() }}">
                        <input class="form-control text-center" id="inputQuantity" type="number" name="cantidad" min="1" value="1" style="max-width: 5rem" />
                        <button class="btn btn-outline-dark add-to-cart-btn" type="submit"><i class="bi bi-cart-fill me-1"></i> Agregar al carrito</button>
                        @php
                            if (auth()->check() && \Illuminate\Support\Facades\Schema::hasTable('wishlists')) {
                                $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('producto_id', $producto->getKey())->exists();
                            } else {
                                $wishlist = session('wishlist', []);
                                $inWishlist = in_array($producto->getKey(), $wishlist);
                            }
                        @endphp
                        <button type="button" class="all-product-wishlist-btn js-wishlist-toggle" data-product-id="{{ $producto->getKey() }}" title="Agregar a deseados">
                            <i class="bi {{ $inWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                        </button>
                        <a class="btn btn-outline-secondary" href="javascript:history.back()">Regresar</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="rating-card p-3 p-lg-4 h-100">
                    <h3 class="h5 fw-bold mb-3">Califica este producto</h3>

                    @auth
                        <form action="{{ route('web.resena.guardar', $producto->getKey()) }}" method="POST">
                            @csrf

                            <label class="form-label fw-semibold">Tu puntuacion</label>
                            <div class="rating-input mb-3">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star-{{ $i }}" name="puntuacion" value="{{ $i }}" {{ (int) old('puntuacion', optional($miResena)->puntuacion) === $i ? 'checked' : '' }}>
                                    <label for="star-{{ $i }}" title="{{ $i }} estrellas"><i class="bi bi-star-fill"></i></label>
                                @endfor
                            </div>
                            @error('puntuacion')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror

                            <div class="mb-3">
                                <label for="comentario" class="form-label fw-semibold">Comentario (opcional)</label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="4" maxlength="600" placeholder="Comparte tu opinion sobre el producto">{{ old('comentario', optional($miResena)->comentario) }}</textarea>
                                @error('comentario')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-dark">{{ $miResena ? 'Actualizar calificacion' : 'Guardar calificacion' }}</button>
                        </form>
                    @else
                        <p class="text-muted mb-3">Debes iniciar sesion para dejar una calificacion.</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-dark">Iniciar sesion</a>
                    @endauth
                </div>
            </div>

            <div class="col-lg-7">
                <div class="review-list-card p-3 p-lg-4">
                    <h3 class="h5 fw-bold mb-3">Opiniones de clientes</h3>

                    @forelse($producto->resenas as $resena)
                        <article class="review-item">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-1">
                                <strong>{{ $resena->user->name ?? 'Cliente' }}</strong>
                                <small class="text-muted">{{ $resena->created_at?->format('d/m/Y') }}</small>
                            </div>
                            <div class="star-view mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= (int) $resena->puntuacion ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                            @if(!empty($resena->comentario))
                                <p class="mb-0">{{ $resena->comentario }}</p>
                            @else
                                <p class="mb-0 text-muted">Sin comentario adicional.</p>
                            @endif
                        </article>
                    @empty
                        <p class="text-muted mb-0">Aun no hay calificaciones para este producto. Se la primera persona en opinar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
