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

    /* ── Product card (horizontal compact) ─────────────────── */
    .product-card {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        border: 1px solid var(--dz-border);
        border-radius: 0.9rem;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-4px);
        border-color: rgba(196, 99, 16, 0.38);
        box-shadow: 0 16px 36px rgba(196, 99, 16, 0.16);
    }

    /* Square thumbnail on the left */
    .pc-thumb {
        position: relative;
        flex-shrink: 0;
        width: 110px;
        align-self: stretch;
        overflow: hidden;
    }

    .pc-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .product-card:hover .pc-thumb img {
        transform: scale(1.05);
    }

    /* Stock badge on image */
    .pc-badge {
        position: absolute;
        top: 0.4rem;
        left: 0.4rem;
        font-size: 0.6rem;
        padding: 0.2rem 0.42rem;
        border-radius: 0.4rem;
        font-weight: 700;
        line-height: 1.3;
        box-shadow: 0 2px 6px rgba(0,0,0,0.18);
    }

    /* Right info area */
    .pc-body {
        flex: 1 1 0;
        min-width: 0;
        padding: 0.7rem 0.75rem 0.65rem;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .pc-name {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--dz-heading);
        line-height: 1.25;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
    }

    .pc-artist {
        font-size: 0.7rem;
        color: var(--dz-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pc-chips {
        display: flex;
        flex-wrap: nowrap;
        gap: 0.28rem;
        overflow: hidden;
    }

    .pc-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        padding: 0.12rem 0.38rem;
        border-radius: 999px;
        background: rgba(196, 99, 16, 0.09);
        border: 1px solid rgba(196, 99, 16, 0.2);
        color: #8a4a1d;
        font-size: 0.62rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 80px;
    }

    .pc-stats {
        display: flex;
        gap: 0.3rem;
        margin-top: auto;
        flex-wrap: nowrap;
    }

    .pc-stat {
        display: flex;
        align-items: center;
        gap: 0.22rem;
        font-size: 0.66rem;
        color: var(--dz-muted);
        white-space: nowrap;
    }

    .pc-stat i {
        font-size: 0.65rem;
        color: #c46310;
    }

    .pc-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.35rem;
        margin-top: 0.2rem;
        padding-top: 0.4rem;
        border-top: 1px solid rgba(196, 99, 16, 0.12);
    }

    .pc-price {
        font-size: 0.95rem;
        font-weight: 800;
        color: #c46310;
        white-space: nowrap;
    }

    .pc-btn {
        flex-shrink: 0;
        font-size: 0.68rem;
        padding: 0.28rem 0.6rem;
        border-radius: 0.5rem;
        border: 1px solid #c46310;
        color: #c46310;
        background: transparent;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.18s ease, color 0.18s ease;
        white-space: nowrap;
    }

    .pc-btn:hover {
        background: #c46310;
        color: #fff;
    }

    /* ── Dark mode card ──────────────────────────────────────── */
    html[data-theme='dark'] .product-card {
        background: #1a0800;
        border-color: #3d1e0a;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
    }

    html[data-theme='dark'] .pc-name {
        color: #fdf0e4;
    }

    html[data-theme='dark'] .pc-artist,
    html[data-theme='dark'] .pc-stat {
        color: #d4b4a4;
    }

    html[data-theme='dark'] .pc-chip {
        background: rgba(224, 122, 48, 0.16);
        border-color: rgba(224, 122, 48, 0.32);
        color: #f4d5c2;
    }

    html[data-theme='dark'] .pc-stat i {
        color: #e07a30;
    }

    html[data-theme='dark'] .pc-footer {
        border-top-color: rgba(224, 122, 48, 0.18);
    }

    html[data-theme='dark'] .pc-price {
        color: #e07a30;
    }

    html[data-theme='dark'] .pc-btn {
        border-color: #e07a30;
        color: #e07a30;
    }

    html[data-theme='dark'] .pc-btn:hover {
        background: #e07a30;
        color: #1a0800;
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
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        padding-right: 0.15rem;
        pointer-events: auto;
        z-index: 4;
    }

    .carousel-btn {
        width: 2.4rem;
        height: 2.4rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        border: 1px solid var(--dz-border);
        background: rgba(255, 255, 255, 0.9);
        color: var(--dz-heading);
        box-shadow: 0 4px 12px rgba(46, 18, 6, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        cursor: pointer;
        flex-shrink: 0;
    }

    .carousel-btn:hover,
    .carousel-btn:focus {
        transform: scale(1.07);
        box-shadow: 0 8px 20px rgba(46, 18, 6, 0.16);
        background: #fff;
        outline: none;
    }

    .carousel-btn[disabled] {
        opacity: 0.35;
        cursor: not-allowed;
        pointer-events: none;
    }

    .product-carousel {
        position: relative;
        padding-inline: 0;
    }

    .product-carousel-track {
        display: flex;
        gap: 0.85rem;
        overflow-x: auto;
        padding: 0.2rem 0.1rem 0.8rem;
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
        flex: 0 0 calc((100% - 3rem) / 3);
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

    .all-products-section {
        margin: 1rem 0 4rem;
        padding: 1.2rem;
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 14px 30px rgba(46, 18, 6, 0.08);
    }

    .all-products-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.8rem;
        margin-bottom: 1rem;
        padding-bottom: 0.7rem;
        border-bottom: 1px dashed rgba(196, 99, 16, 0.28);
    }

    .all-products-head h4 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--dz-heading);
    }

    .all-products-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0.85rem;
        align-items: stretch;
    }

    .all-product-card {
        border: 1px solid rgba(196, 99, 16, 0.18);
        border-radius: 0.75rem;
        background: #fff;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-width: 0;
        height: 100%;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .all-product-card:hover {
        border-color: rgba(196, 99, 16, 0.42);
        box-shadow: 0 10px 22px rgba(46, 18, 6, 0.14);
        transform: translateY(-2px);
    }

    .all-product-cover {
        position: relative;
        height: 220px;
        background: #f8f8f8;
    }

    .all-product-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .all-product-stock {
        position: absolute;
        left: 0.4rem;
        top: 0.4rem;
        border-radius: 999px;
        padding: 0.15rem 0.45rem;
        font-size: 0.62rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
    }

    .all-product-body {
        padding: 0.55rem 0.58rem 0.62rem;
        display: flex;
        flex-direction: column;
        gap: 0.26rem;
        min-height: 178px;
        flex: 1 1 auto;
    }

    .all-product-name {
        margin: 0;
        font-size: 0.83rem;
        font-weight: 700;
        line-height: 1.24;
        color: var(--dz-heading);
        min-height: 2.05rem;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }

    .all-product-artist {
        margin: 0;
        font-size: 0.72rem;
        color: var(--dz-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .all-product-discount {
        font-size: 0.66rem;
        font-weight: 700;
        color: #0f5fa8;
        letter-spacing: 0.01em;
        text-transform: uppercase;
    }

    .all-product-price {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        line-height: 1;
        color: #111827;
    }

    .all-product-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.2rem;
        min-height: 1.3rem;
    }

    .all-product-chip {
        font-size: 0.6rem;
        border-radius: 999px;
        padding: 0.1rem 0.38rem;
        background: rgba(196, 99, 16, 0.1);
        border: 1px solid rgba(196, 99, 16, 0.2);
        color: #8a4a1d;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .all-product-inline-stats {
        display: flex;
        gap: 0.4rem;
        font-size: 0.64rem;
        color: var(--dz-muted);
        margin-top: auto;
        white-space: nowrap;
        min-height: 1rem;
    }

    .all-product-cta {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.3rem;
        border: 0;
        border-radius: 0.4rem;
        background: #0f5fa8;
        color: #fff;
        text-decoration: none;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.32rem 0.48rem;
        transition: background-color 0.16s ease;
    }

    .all-product-cta:hover {
        background: #0a4a84;
        color: #fff;
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
    html[data-theme='dark'] .carousel-btn {
        background: #1a0800;
        border-color: #3d1e0a;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.55);
    }

    html[data-theme='dark'] .carousel-btn:hover {
        background: #2a1005;
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

    html[data-theme='dark'] .all-products-section {
        background: #1a0800;
        border-color: #3d1e0a;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.55);
    }

    html[data-theme='dark'] .all-products-head {
        border-bottom-color: rgba(224, 122, 48, 0.36);
    }

    html[data-theme='dark'] .all-products-head h4,
    html[data-theme='dark'] .all-product-name {
        color: #fdf0e4;
    }

    html[data-theme='dark'] .all-product-card {
        background: rgba(46, 18, 6, 0.42);
        border-color: rgba(224, 122, 48, 0.28);
    }

    html[data-theme='dark'] .all-product-card:hover {
        border-color: rgba(224, 122, 48, 0.5);
    }

    html[data-theme='dark'] .all-product-cover {
        background: #240e04;
    }

    html[data-theme='dark'] .all-product-artist,
    html[data-theme='dark'] .all-product-inline-stats {
        color: #d4b4a4;
    }

    html[data-theme='dark'] .all-product-chip {
        background: rgba(224, 122, 48, 0.16);
        border-color: rgba(224, 122, 48, 0.34);
        color: #f4d5c2;
    }

    html[data-theme='dark'] .all-product-price {
        color: #fdf0e4;
    }

    html[data-theme='dark'] .all-product-discount {
        color: #8bc4ff;
    }

    html[data-theme='dark'] .all-product-cta {
        background: #e07a30;
        color: #1a0800;
    }

    html[data-theme='dark'] .all-product-cta:hover {
        background: #f09a58;
        color: #1a0800;
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
            flex-basis: calc((100% - 1.5rem) / 2);
            min-width: 260px;
        }

        .all-products-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .carousel-btn {
            width: 2.1rem;
            height: 2.1rem;
        }

        .product-carousel-item {
            flex-basis: 82%;
            min-width: 260px;
        }

        .all-products-section {
            padding: 0.9rem;
        }

        .all-products-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.7rem;
        }

        .all-product-body {
            min-height: 166px;
        }

        .all-product-price {
            font-size: 1rem;
        }

        .all-product-cover {
            height: 190px;
        }
    }

    @media (max-width: 480px) {
        .all-products-grid {
            grid-template-columns: 1fr;
        }

        .all-product-body {
            min-height: 154px;
        }

        .all-product-cover {
            height: 220px;
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
                    </div>
                    <div class="product-carousel" data-carousel>
                        <div class="carousel-actions" aria-hidden="false">
                            <button type="button" class="carousel-btn" data-carousel-prev aria-label="Anterior">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <button type="button" class="carousel-btn" data-carousel-next aria-label="Siguiente">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                        <div class="product-carousel-track" data-carousel-track>
                        @foreach ($section['items'] as $producto)
                            <div class="product-carousel-item">
                                @php
                                    $stock  = (int) ($producto->cantidad ?? 0);
                                    $rating = round((float) ($producto->resenas_avg_puntuacion ?? 0), 1);
                                    $rCount = (int) ($producto->resenas_count ?? 0);
                                @endphp
                                <div class="product-card">
                                    {{-- Thumbnail --}}
                                    <div class="pc-thumb">
                                        @if($producto->imagen)
                                            <img src="{{ asset('uploads/productos/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                                        @else
                                            <img src="{{ asset('img/no-image.jpg') }}" alt="Sin imagen">
                                        @endif
                                        @if ($stock >= 50)
                                            <span class="pc-badge badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                        @elseif ($stock > 0)
                                            <span class="pc-badge badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                                        @else
                                            <span class="pc-badge badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                        @endif
                                    </div>

                                    {{-- Info --}}
                                    <div class="pc-body">
                                        <p class="pc-name" title="{{ $producto->nombre }}">{{ $producto->nombre }}</p>
                                        <p class="pc-artist"><i class="bi bi-person-fill me-1" style="font-size:.65rem;color:#c46310;"></i>{{ $producto->artista?->nombre ?? 'Artista N/D' }}</p>

                                        <div class="pc-chips">
                                            @if($producto->categoria)
                                                <span class="pc-chip" title="{{ $producto->categoria->nombre }}"><i class="bi bi-tags-fill"></i>{{ $producto->categoria->nombre }}</span>
                                            @endif
                                            @if($producto->catalogo)
                                                <span class="pc-chip" title="{{ $producto->catalogo->nombre }}"><i class="bi bi-journal-bookmark-fill"></i>{{ $producto->catalogo->nombre }}</span>
                                            @endif
                                        </div>

                                        <div class="pc-stats">
                                            <span class="pc-stat"><i class="bi bi-star-fill"></i>{{ number_format($rating, 1) }}</span>
                                            <span class="pc-stat"><i class="bi bi-chat-square-text"></i>{{ $rCount }}</span>
                                            <span class="pc-stat"><i class="bi bi-box-seam"></i>{{ $stock }}</span>
                                            @if($producto->anio_lanzamiento)
                                                <span class="pc-stat"><i class="bi bi-calendar3"></i>{{ $producto->anio_lanzamiento }}</span>
                                            @endif
                                        </div>

                                        <div class="pc-footer">
                                            <span class="pc-price">${{ number_format($producto->precio, 2) }}</span>
                                            <a href="{{ route('web.show', $producto->id) }}" class="pc-btn"><i class="bi bi-eye me-1"></i>Ver</a>
                                        </div>
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

    <section class="all-products-section">
        <div class="all-products-head">
            <h4><i class="bi bi-grid-3x3-gap-fill me-2"></i>Todos los productos</h4>
            <span class="section-badge">{{ $productos->total() }} registrados</span>
        </div>

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
                                <img src="{{ asset('img/no-image.jpg') }}" alt="Sin imagen">
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
                                <span class="all-product-discount"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                            @else
                                <span class="all-product-discount"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                            @endif
                            <p class="all-product-price">${{ number_format($producto->precio, 2) }}</p>

                            <div class="all-product-meta">
                                @if($producto->categoria)
                                    <span class="all-product-chip"><i class="bi bi-tags-fill me-1"></i>{{ $producto->categoria->nombre }}</span>
                                @endif
                                @if($producto->catalogo)
                                    <span class="all-product-chip"><i class="bi bi-journal-bookmark-fill me-1"></i>{{ $producto->catalogo->nombre }}</span>
                                @endif
                            </div>

                            <div class="all-product-inline-stats">
                                <span><i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($ratingAll, 1) }}</span>
                                <span><i class="bi bi-chat-left-text me-1"></i>{{ $reviewsAll }}</span>
                                <span><i class="bi bi-box-seam me-1"></i>{{ $stockAll }}</span>
                            </div>

                            <a href="{{ route('web.show', $producto->id) }}" class="all-product-cta">
                                <i class="bi bi-cart-plus"></i>
                                Ver producto
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
</div>
@endsection

@push('scripts')
<script>
    (function () {
        function initProductCarousel(root) {
            var track = root.querySelector('[data-carousel-track]');
            var prev = root.querySelector('[data-carousel-prev]');
            var next = root.querySelector('[data-carousel-next]');
            var progress = root.querySelector('[data-carousel-progress]');

            if (!track || !prev || !next) {
                return;
            }

            var dots = [];

            var getScrollAmount = function () {
                var items = Array.from(track.querySelectorAll('.product-carousel-item'));
                if (!items.length) {
                    return track.clientWidth;
                }

                if (items.length > 1) {
                    var distance = Math.abs(items[1].offsetLeft - items[0].offsetLeft);
                    if (distance > 0) {
                        return distance;
                    }
                }

                return items[0].getBoundingClientRect().width;
            };

            var getPerView = function () {
                var step = getScrollAmount();
                if (!step) {
                    return 1;
                }
                return Math.max(1, Math.floor(track.clientWidth / step));
            };

            var buildProgress = function () {
                if (!progress) {
                    return [];
                }

                progress.innerHTML = '';

                var items = Array.from(track.children);
                if (!items.length) {
                    return [];
                }

                var perView = getPerView();
                var pages = Math.max(1, items.length - perView + 1);

                return Array.from({ length: pages }, function () {
                    var dot = document.createElement('span');
                    progress.appendChild(dot);
                    return dot;
                });
            };

            var updateControls = function () {
                var maxScroll = Math.max(0, track.scrollWidth - track.clientWidth);
                var epsilon = 2;
                var canScroll = maxScroll > 6;
                prev.disabled = !canScroll || track.scrollLeft <= epsilon;
                next.disabled = !canScroll || track.scrollLeft >= (maxScroll - epsilon);

                if (!dots.length) {
                    return;
                }

                var ratio = maxScroll <= 0 ? 0 : track.scrollLeft / maxScroll;
                var activeIndex = Math.min(dots.length - 1, Math.round(ratio * (dots.length - 1)));
                dots.forEach(function (dot, index) {
                    dot.classList.toggle('is-active', index === activeIndex);
                });
            };

            prev.addEventListener('click', function () {
                if (prev.disabled) {
                    return;
                }
                var amount = getScrollAmount();
                var before = track.scrollLeft;
                track.scrollBy({ left: -amount, behavior: 'smooth' });
                setTimeout(function () {
                    if (Math.abs(track.scrollLeft - before) < 2) {
                        track.scrollLeft = Math.max(0, before - amount);
                        updateControls();
                    }
                }, 180);
            });

            next.addEventListener('click', function () {
                if (next.disabled) {
                    return;
                }
                var amount = getScrollAmount();
                var before = track.scrollLeft;
                track.scrollBy({ left: amount, behavior: 'smooth' });
                setTimeout(function () {
                    if (Math.abs(track.scrollLeft - before) < 2) {
                        track.scrollLeft = before + amount;
                        updateControls();
                    }
                }, 180);
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

            var refreshCarouselState = function () {
                dots = buildProgress();
                updateControls();
            };

            if (typeof ResizeObserver !== 'undefined') {
                var resizeObserver = new ResizeObserver(function () {
                    refreshCarouselState();
                });
                resizeObserver.observe(track);
            }

            window.addEventListener('load', refreshCarouselState, { once: true });
            requestAnimationFrame(refreshCarouselState);
            setTimeout(refreshCarouselState, 160);

            dots = buildProgress();
            updateControls();
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-carousel]').forEach(initProductCarousel);
        });
    })();
</script>
@endpush
