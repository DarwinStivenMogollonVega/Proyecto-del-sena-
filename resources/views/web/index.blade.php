@extends('web.app')

@push('estilos')
<style>
    .store-hero {
        background:
            radial-gradient(circle at top left, rgba(196, 99, 16, 0.18), transparent 34%),
            radial-gradient(circle at 78% 82%, rgba(184, 153, 144, 0.16), transparent 36%),
            linear-gradient(145deg, rgba(255, 255, 255, 0.78) 0%, rgba(253, 242, 232, 0.94) 54%, rgba(253, 238, 224, 0.98) 100%);
        border: 1px solid rgba(255, 255, 255, 0.38);
        backdrop-filter: blur(12px);
        color: var(--dz-heading);
        border-radius: 1.4rem;
        margin-top: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(196, 99, 16, 0.16);
    }

    .store-hero h1 {
        color: #200c03;
    }

    .store-hero .hero-subtitle {
        color: #8a6a5c;
    }

    .store-hero-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 0.8rem;
    }

    .store-hero-brand img {
        width: 172px;
        max-width: 100%;
        height: auto;
        object-fit: contain;
    }

    .store-hero::before {
        content: '';
        position: absolute;
        width: 260px;
        height: 260px;
        right: -90px;
        top: -110px;
        border-radius: 50%;
        background: rgba(196, 99, 16, 0.12);
    }

    .store-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, 0.12) 34%, transparent 62%);
        transform: translateX(-135%);
        transition: transform 0.7s ease;
        pointer-events: none;
    }

    .store-hero:hover::after {
        transform: translateX(135%);
    }

    .metric-pill {
        background: rgba(255, 255, 255, 0.84);
        border: 1px solid var(--dz-border);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 0.95rem 1rem;
    }

    .metric-pill strong {
        display: block;
        color: var(--dz-heading);
        font-size: 1.2rem;
        line-height: 1;
    }

    .metric-pill span {
        color: var(--dz-muted);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        font-weight: 600;
    }

    .search-panel {
        border: 1px solid var(--dz-border);
        border-radius: 1.1rem;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        box-shadow: 0 14px 40px rgba(46, 18, 6, 0.08);
    }

    .product-card {
        border: 1px solid var(--dz-border);
        border-radius: 1.1rem;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(12px);
        transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        border-color: rgba(196, 99, 16, 0.35);
        box-shadow: 0 22px 44px rgba(196, 99, 16, 0.16);
    }

    .product-card .card-img-top {
        height: 230px;
        object-fit: cover;
    }

    .price-label {
        font-size: 1.25rem;
        font-weight: 700;
        color: #c46310;
    }

    .section-title {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--dz-border);
    }

    .section-title h3 {
        margin: 0;
        font-weight: 700;
        color: var(--dz-heading);
        font-size: 1.5rem;
    }

    .section-title .icon {
        font-size: 1.75rem;
        color: #c46310;
    }

    .section-badge {
        background: rgba(255, 255, 255, 0.82);
        border: 1px solid var(--dz-border);
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--dz-muted);
    }

    .carousel-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        margin-left: auto;
    }

    .carousel-btn {
        width: 2.8rem;
        height: 2.8rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        border: 1px solid var(--dz-border);
        background: rgba(255, 255, 255, 0.86);
        color: var(--dz-heading);
        box-shadow: 0 12px 24px rgba(46, 18, 6, 0.08);
    }

    .carousel-btn[disabled] {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .product-carousel {
        position: relative;
    }

    .product-carousel-track {
        display: flex;
        gap: 1.25rem;
        overflow-x: auto;
        padding: 0.35rem 0.15rem 1rem;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        scrollbar-width: none;
        cursor: grab;
        user-select: none;
    }

    .product-carousel-track::-webkit-scrollbar {
        display: none;
    }

    .product-carousel-track.is-dragging {
        cursor: grabbing;
        scroll-snap-type: none;
    }

    .product-carousel-item {
        flex: 0 0 calc((100% - 2.5rem) / 3);
        min-width: 280px;
        scroll-snap-align: start;
    }

    .product-carousel-progress {
        display: flex;
        gap: 0.4rem;
        margin-top: 0.4rem;
    }

    .product-carousel-progress span {
        width: 1.9rem;
        height: 0.28rem;
        border-radius: 999px;
        background: rgba(196, 99, 16, 0.16);
        transition: background-color 0.22s ease, transform 0.22s ease;
    }

    .product-carousel-progress span.is-active {
        background: #c46310;
        transform: scaleX(1.08);
    }

    .product-section {
        margin-bottom: 4rem;
        animation: slideInUp 0.4s ease;
    }

    html[data-theme='dark'] .store-hero {
        background:
            radial-gradient(circle at top left, rgba(196, 99, 16, 0.32), transparent 36%),
            radial-gradient(circle at 78% 82%, rgba(77, 32, 16, 0.42), transparent 40%),
            linear-gradient(145deg, rgba(22, 8, 0, 0.92) 0%, rgba(196, 99, 16, 0.94) 52%, rgba(77, 32, 16, 0.96) 100%);
        border-color: rgba(255,255,255,0.10);
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.45);
    }

    html[data-theme='dark'] .store-hero h1 {
        color: #fdf0e4;
    }

    html[data-theme='dark'] .store-hero .hero-subtitle {
        color: rgba(253, 240, 228, 0.80);
    }

    html[data-theme='dark'] .store-hero::before {
        background: rgba(255, 255, 255, 0.07);
    }

    html[data-theme='dark'] .metric-pill,
    html[data-theme='dark'] .search-panel,
    html[data-theme='dark'] .product-card,
    html[data-theme='dark'] .carousel-btn {
        background: #1a0800;
        border-color: #3d1e0a;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.55);
    }

    html[data-theme='dark'] .section-title {
        border-bottom-color: #3d1e0a;
    }

    html[data-theme='dark'] .section-badge {
        background: #240e04;
        color: #d4b4a4;
        border: 1px solid #3d1e0a;
    }

    html[data-theme='dark'] .carousel-btn {
        color: #fdf0e4;
    }

    html[data-theme='dark'] .product-carousel-progress span {
        background: rgba(255, 255, 255, 0.18);
    }

    html[data-theme='dark'] .product-carousel-progress span.is-active {
        background: #e07a30;
    }

    html[data-theme='dark'] .price-label {
        color: #e07a30;
    }

    html[data-theme='dark'] .search-panel .form-control::placeholder {
        color: #c4a898;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 991.98px) {
        .product-carousel-item {
            flex-basis: calc((100% - 1.25rem) / 2);
        }
    }

    @media (max-width: 767.98px) {
        .carousel-actions {
            width: 100%;
            justify-content: space-between;
        }

        .product-carousel-item {
            flex-basis: 84%;
            min-width: 260px;
        }
    }
</style>
@endpush

@section('header')
@endsection

@section('contenido')
<div class="container px-4 px-lg-5">
    <section id="inicio" class="store-hero p-4 p-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="store-hero-brand">
                    <img
                        src="{{ asset('logo_proyecto_con_nombre-removebg-preview.png') }}"
                        alt="DisMusic"
                        onerror="this.onerror=null;this.src='{{ asset('logo_proyecto-removebg-preview.png') }}';"
                    >
                </div>
                <h1 class="display-6 fw-bold mb-2">Descubre tu proximo disco favorito</h1>
                <p class="mb-0 hero-subtitle">Explora el catalogo, compara precios y encuentra nuevas joyas para tu coleccion.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                <a href="#productos" class="btn btn-light px-4">
                    <i class="bi bi-vinyl-fill me-1"></i> Explorar ahora
                </a>
            </div>
        </div>
    </section>

    @if (session('success'))
        <div class="alert alert-success text-center mt-3">{{ session('success') }}</div>
    @endif

    @if (session('mensaje'))
        <div class="alert alert-success text-center mt-3">{{ session('mensaje') }}</div>
    @endif

    <div class="row g-3 mt-2">
        <div class="col-6 col-md-3"><div class="metric-pill"><strong>{{ $metricas['totalProductos'] }}</strong><span>Productos</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong>{{ $metricas['disponibles'] }}</strong><span>Disponibles</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong>{{ $metricas['totalCategorias'] }}</strong><span>Categorias</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong>{{ $metricas['totalCatalogos'] }}</strong><span>Catalogos</span></div></div>
    </div>

    <form id="explorar" method="GET" action="{{ route('web.index') }}" class="search-panel p-3 p-md-4 mt-4">
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

    <section id="productos" class="mt-5">
        @foreach ([
            ['title' => 'Los mas vendidos', 'icon' => 'bi-fire', 'items' => $masMasVendidos],
            ['title' => 'Los mejor valorados', 'icon' => 'bi-star-fill', 'items' => $mejorValorados],
            ['title' => 'Ofertas especiales', 'icon' => 'bi-tag', 'items' => $ofertasEspeciales],
            ['title' => 'Disponibles ahora', 'icon' => 'bi-check2-circle', 'items' => $disponiblesAhora],
        ] as $section)
            @if($section['items']->isNotEmpty())
                <div class="product-section">
                    <div class="section-title">
                        <i class="bi {{ $section['icon'] }} icon"></i>
                        <h3>{{ $section['title'] }}</h3>
                        <span class="section-badge">{{ $section['items']->count() }} productos</span>
                        <div class="carousel-actions">
                            <button type="button" class="carousel-btn" data-carousel-prev aria-label="Anterior">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <button type="button" class="carousel-btn" data-carousel-next aria-label="Siguiente">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-carousel" data-carousel>
                        <div class="product-carousel-track" data-carousel-track>
                        @foreach ($section['items'] as $producto)
                            <div class="product-carousel-item">
                                <div class="card product-card h-100 position-relative">
                                    @if($producto->imagen)
                                        <img src="{{ asset('uploads/productos/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}">
                                    @else
                                        <img src="{{ asset('img/no-image.jpg') }}" class="card-img-top" alt="Sin imagen">
                                    @endif

                                    @php $stock = $producto->cantidad ?? 0; @endphp
                                    @if ($stock >= 50)
                                        <span class="badge bg-success position-absolute top-0 start-0 m-2 p-2 rounded-3 shadow"><i class="bi bi-check-circle me-1"></i> Disponible</span>
                                    @elseif ($stock >= 10 && $stock < 50)
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 p-2 rounded-3 shadow"><i class="bi bi-exclamation-circle me-1"></i> Pocas</span>
                                    @elseif ($stock == 0)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2 p-2 rounded-3 shadow"><i class="bi bi-x-circle me-1"></i> Agotado</span>
                                    @endif

                                    <div class="card-body text-center d-flex flex-column">
                                        <h5 class="fw-bolder">{{ $producto->nombre }}</h5>
                                        <p class="mb-2 text-muted small">
                                            @if($producto->categoria)
                                                <span class="badge bg-primary"><i class="bi bi-tags-fill me-1"></i>{{ $producto->categoria->nombre }}</span>
                                            @endif
                                            @if($section['title'] === 'Los mejor valorados')
                                                <span class="badge bg-warning ms-1"><i class="bi bi-star-fill me-1"></i>{{ number_format($producto->promedio_calificacion ?? 0, 1) }}</span>
                                            @endif
                                        </p>
                                        <p class="price-label mb-3">${{ number_format($producto->precio, 2) }}</p>
                                        <a href="{{ route('web.show', $producto->id) }}" class="btn btn-outline-dark mt-auto"><i class="bi bi-eye me-1"></i> Ver</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        <div class="product-carousel-progress" data-carousel-progress aria-hidden="true"></div>
                    </div>
                </div>
            @endif
        @endforeach

        @if($masMasVendidos->isEmpty() && $mejorValorados->isEmpty() && $ofertasEspeciales->isEmpty() && $disponiblesAhora->isEmpty())
            <div class="text-center py-5 border rounded-4 bg-light-subtle">
                <p class="text-muted mb-0">No se encontraron productos con esos filtros.</p>
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        function initProductCarousel(root) {
            var section = root.closest('.product-section');
            var track = root.querySelector('[data-carousel-track]');
            var prev = section ? section.querySelector('[data-carousel-prev]') : null;
            var next = section ? section.querySelector('[data-carousel-next]') : null;
            var progress = root.querySelector('[data-carousel-progress]');

            if (!track || !prev || !next) {
                return;
            }

            var dots = [];

            var buildProgress = function () {
                if (!progress) {
                    return [];
                }

                progress.innerHTML = '';

                var items = Array.from(track.children);
                if (!items.length) {
                    return [];
                }

                var perView = window.innerWidth < 768 ? 1 : (window.innerWidth < 992 ? 2 : 3);
                var pages = Math.max(1, items.length - perView + 1);

                return Array.from({ length: pages }, function () {
                    var dot = document.createElement('span');
                    progress.appendChild(dot);
                    return dot;
                });
            };

            var updateControls = function () {
                var maxScroll = Math.max(0, track.scrollWidth - track.clientWidth - 2);
                prev.disabled = track.scrollLeft <= 2;
                next.disabled = track.scrollLeft >= maxScroll;

                if (!dots.length) {
                    return;
                }

                var ratio = maxScroll <= 0 ? 0 : track.scrollLeft / maxScroll;
                var activeIndex = Math.min(dots.length - 1, Math.round(ratio * (dots.length - 1)));
                dots.forEach(function (dot, index) {
                    dot.classList.toggle('is-active', index === activeIndex);
                });
            };

            var getScrollAmount = function () {
                var first = track.querySelector('.product-carousel-item');
                if (!first) {
                    return track.clientWidth;
                }

                var styles = window.getComputedStyle(track);
                var gap = parseFloat(styles.columnGap || styles.gap || '0');
                return first.getBoundingClientRect().width + gap;
            };

            prev.addEventListener('click', function () {
                track.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
            });

            next.addEventListener('click', function () {
                track.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
            });

            var pointerDown = false;
            var startX = 0;
            var startScroll = 0;

            track.addEventListener('pointerdown', function (event) {
                pointerDown = true;
                startX = event.clientX;
                startScroll = track.scrollLeft;
                track.classList.add('is-dragging');
            });

            track.addEventListener('pointermove', function (event) {
                if (!pointerDown) {
                    return;
                }

                track.scrollLeft = startScroll - (event.clientX - startX);
            });

            ['pointerup', 'pointerleave', 'pointercancel'].forEach(function (eventName) {
                track.addEventListener(eventName, function () {
                    pointerDown = false;
                    track.classList.remove('is-dragging');
                });
            });

            track.addEventListener('scroll', updateControls, { passive: true });
            window.addEventListener('resize', function () {
                dots = buildProgress();
                updateControls();
            });

            dots = buildProgress();
            updateControls();
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-carousel]').forEach(initProductCarousel);
        });
    })();
</script>
@endpush
