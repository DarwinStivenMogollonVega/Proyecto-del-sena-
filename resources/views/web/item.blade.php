@extends('web.app')

@push('estilos')
<style>
    .product-page {
        padding-top: 2rem;
        padding-bottom: 3rem;
    }

    .product-main-card,
    .rating-card,
    .review-list-card {
        background: var(--dz-surface);
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
    }

    .product-image-wrap {
        border-radius: 0.9rem;
        overflow: hidden;
        border: 1px solid var(--dz-border);
        background: var(--dz-surface-soft);
    }

    .product-image-wrap img {
        width: 100%;
        height: 460px;
        object-fit: cover;
    }

    .price-big {
        font-size: 1.6rem;
        font-weight: 700;
        color: #b45309;
    }

    .rating-summary {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        flex-wrap: wrap;
    }

    .star-view {
        display: inline-flex;
        gap: 0.18rem;
        color: #f59e0b;
    }

    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 0.2rem;
    }

    .rating-input input {
        display: none;
    }

    .rating-input label {
        cursor: pointer;
        font-size: 1.55rem;
        line-height: 1;
        color: #cbd5e1;
        transition: color 0.18s ease;
    }

    .rating-input label:hover,
    .rating-input label:hover ~ label,
    .rating-input input:checked ~ label {
        color: #f59e0b;
    }

    .review-item {
        border: 1px solid var(--dz-border);
        border-radius: 0.8rem;
        padding: 0.9rem;
        background: var(--dz-surface-soft);
    }

    .review-item + .review-item {
        margin-top: 0.75rem;
    }

    html[data-theme='dark'] .product-main-card,
    html[data-theme='dark'] .rating-card,
    html[data-theme='dark'] .review-list-card,
    html[data-theme='dark'] .product-image-wrap,
    html[data-theme='dark'] .review-item {
        background: #111827;
        border-color: #334155;
        box-shadow: 0 14px 28px rgba(2, 6, 23, 0.48);
    }

    html[data-theme='dark'] .price-big {
        color: #fbbf24;
    }

    html[data-theme='dark'] .rating-input label {
        color: #475569;
    }

    @media (max-width: 767.98px) {
        .product-image-wrap img {
            height: 320px;
        }
    }
</style>
@endpush

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
                        @if($producto->catalogo)
                            <span class="badge bg-danger"><i class="bi bi-bookmark-fill me-1"></i>{{ $producto->catalogo->nombre }}</span>
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

                    @if ($producto->cantidad >= 50)
                        <p class="text-success fw-semibold mb-2"><i class="bi bi-check-circle me-1"></i> Producto disponible</p>
                    @elseif ($producto->cantidad >= 10 && $producto->cantidad < 50)
                        <p class="text-warning fw-semibold mb-2"><i class="bi bi-exclamation-circle me-1"></i> Pocas unidades</p>
                    @elseif ($producto->cantidad == 0)
                        <p class="text-danger fw-semibold mb-2"><i class="bi bi-x-circle me-1"></i> Agotado</p>
                    @endif

                    <p class="lead">{{ $producto->descripcion }}</p>

                    <form action="{{ route('carrito.agregar') }}" method="POST" class="d-flex flex-wrap gap-2 align-items-center">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        <input class="form-control text-center" id="inputQuantity" type="number" name="cantidad" min="1" value="1" style="max-width: 5rem" />
                        <button class="btn btn-outline-dark" type="submit"><i class="bi bi-cart-fill me-1"></i> Agregar al carrito</button>
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
                        <form action="{{ route('web.resena.guardar', $producto->id) }}" method="POST">
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
