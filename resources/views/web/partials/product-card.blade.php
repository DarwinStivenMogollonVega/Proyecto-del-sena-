<div class="product-carousel-item">
    @php
        $stockLocal  = (int) ($producto->cantidad ?? 0);
        $ratingLocal = round((float) ($producto->resenas_avg_puntuacion ?? 0), 1);
        $rCountLocal  = (int) ($producto->resenas_count ?? 0);
    @endphp
    <article class="all-product-card">
        <div class="all-product-cover">
            @if($producto->imagen)
                <img src="{{ asset('uploads/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" width="400" height="300" loading="lazy">
            @else
                <img src="{{ asset('img/no-image.svg') }}" alt="Sin imagen" width="400" height="300" loading="lazy">
            @endif
            @if ($stockLocal >= 50)
                <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
            @elseif ($stockLocal > 0)
                <span class="all-product-stock badge bg-warning text-dark"><i class="bi bi-tag-fill me-1"></i>${{ number_format(($producto->precio - ($producto->descuento ?? 0)), 2) }}</span>
            @else
                <span class="all-product-stock badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
            @endif
        </div>
        <div class="all-product-body">
            <p class="all-product-name" title="{{ $producto->nombre }}">{{ $producto->nombre }}</p>
            <p class="all-product-artist">{{ $producto->artista?->nombre ?? 'Artista no especificado' }}</p>
            @if($producto->descuento > 0)
                <p class="all-product-price text-danger fw-bold">
                    <i class="bi bi-tag-fill me-1"></i>
                    ${{ number_format($producto->precio - $producto->descuento, 2) }}
                    <span class="text-decoration-line-through text-muted ms-2">${{ number_format($producto->precio, 2) }}</span>
                    <span class="badge bg-warning text-dark ms-2">- ${{ number_format($producto->descuento, 2) }} descuento</span>
                </p>
            @else
                <p class="all-product-price">${{ number_format($producto->precio, 2) }}</p>
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
                <span><i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($ratingLocal, 1) }}</span>
                <span><i class="bi bi-chat-left-text me-1"></i>{{ $rCountLocal }}</span>
                <span><i class="bi bi-box-seam me-1"></i>{{ $stockLocal }}</span>
            </div>
            @php
                if (auth()->check() && \Illuminate\Support\Facades\Schema::hasTable('wishlists')) {
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
</div>
