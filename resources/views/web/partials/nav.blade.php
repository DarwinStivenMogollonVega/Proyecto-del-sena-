@php
    $homeUrl = route('web.index');
    $inicioHref = request()->routeIs('web.index') ? '#inicio' : $homeUrl . '#inicio';
    $catalogoActive = request()->routeIs('web.catalogo.show');
    $categoriaActive = request()->routeIs('web.categoria.show');
    $dashboardClienteActive = request()->routeIs('cliente.dashboard');
    $misPedidosActive = request()->routeIs('perfil.pedidos');
    $misRecibosActive = request()->routeIs('perfil.recibos*');
    $miPerfilActive = request()->routeIs('perfil.edit') || request()->routeIs('perfil.update');
    $usuarioActive = request()->routeIs('dashboard')
        || $dashboardClienteActive
        || request()->routeIs('carrito.mostrar')
        || request()->routeIs('perfil.*')
        || $misPedidosActive
        || $miPerfilActive;
@endphp

@once
<style>
    .dz-nav {
        backdrop-filter: blur(6px);
        position: sticky;
        top: 0;
        z-index: 1055;
        background: linear-gradient(120deg, var(--dz-navbar-grad-1), var(--dz-navbar-grad-2));
        box-shadow: var(--dz-navbar-shadow);
    }

    .dz-nav .dropdown-menu {
        z-index: 1060;
    }

    .dz-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        letter-spacing: 0.02em;
        padding: 0.28rem 0.55rem;
        border-radius: 0.65rem;
        background: rgba(255, 255, 255, 0.14);
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.20) inset;
    }

    .dz-brand-logo {
        width: 172px;
        max-width: 100%;
        height: auto;
        border-radius: 0.25rem;
        object-fit: contain;
    }

    .dz-brand-logo-full {
        width: 172px;
    }

    .dz-brand-logo-icon {
        width: 2.15rem;
        height: 2.15rem;
        border-radius: 50%;
        object-fit: cover;
        display: none;
        padding: 0.18rem;
    }

    .nav-scroll-link {
        border-radius: 999px;
        padding: 0.5rem 0.9rem !important;
        transition: background-color 0.22s ease, color 0.22s ease, box-shadow 0.22s ease;
    }

    .navbar-dark .navbar-nav .nav-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: rgba(255, 255, 255, 0.98) !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.24);
    }

    .navbar-dark .navbar-nav .nav-link:hover,
    .navbar-dark .navbar-nav .nav-link:focus {
        color: #ffffff !important;
    }

    .navbar-dark .navbar-nav .nav-link.nav-scroll-link.is-section-active,
    .navbar-dark .navbar-nav .nav-link.nav-scroll-link.active {
        color: #fff;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.25) inset;
    }

    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.nav-scroll-link.is-section-active,
    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.nav-scroll-link.active {
        background: rgba(148, 163, 184, 0.2);
        box-shadow: 0 0 0 1px rgba(148, 163, 184, 0.35) inset;
    }

    .navbar-dark .navbar-nav .nav-link.dropdown-toggle:not(.dropdown-cta-btn).show,
    .navbar-dark .navbar-nav .nav-item.dropdown.dropdown-lit > .nav-link:not(.dropdown-cta-btn) {
        color: #fff;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.25) inset;
        border-radius: 999px;
    }

    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.dropdown-toggle:not(.dropdown-cta-btn).show,
    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-item.dropdown.dropdown-lit > .nav-link:not(.dropdown-cta-btn) {
        background: rgba(148, 163, 184, 0.2);
        box-shadow: 0 0 0 1px rgba(148, 163, 184, 0.35) inset;
    }

    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn {
        position: relative;
        overflow: hidden;
        isolation: isolate;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 0.9rem !important;
        border: 1px solid rgba(255, 255, 255, 0.26);
        color: #fff !important;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 999px;
        font-weight: 700;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
        transition: transform 0.25s ease, background-color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }

    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 22% 50%, rgba(255, 255, 255, 0.22), transparent 56%);
        opacity: 0.8;
        transition: opacity 0.25s ease, transform 0.3s ease;
        pointer-events: none;
        z-index: 0;
    }

    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn > * {
        position: relative;
        z-index: 1;
    }

    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn > i {
        transition: transform 0.35s ease;
    }

    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn:hover,
    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn:focus,
    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn.show {
        color: #fff !important;
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.34);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn:hover::before,
    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn:focus::before,
    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn.show::before {
        opacity: 1;
        transform: translateX(7px);
    }

    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn:hover > i,
    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn:focus > i,
    .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn.show > i {
        transform: rotate(-12deg);
    }

    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn {
        background: rgba(148, 163, 184, 0.12);
        border-color: rgba(148, 163, 184, 0.28);
    }

    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn:hover,
    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn:focus,
    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.dropdown-cta-btn.show {
        background: rgba(148, 163, 184, 0.22);
        border-color: rgba(148, 163, 184, 0.38);
    }

    .navbar-dark .navbar-nav .nav-link.nav-cta-btn {
        position: relative;
        overflow: hidden;
        isolation: isolate;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.5rem 0.9rem !important;
        border: 1px solid rgba(255, 255, 255, 0.26);
        color: #fff !important;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 999px;
        font-weight: 700;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
        transition: transform 0.25s ease, background-color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }

    .navbar-dark .navbar-nav .nav-link.nav-cta-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 22% 50%, rgba(255, 255, 255, 0.22), transparent 56%);
        opacity: 0.8;
        transition: opacity 0.25s ease, transform 0.3s ease;
        pointer-events: none;
        z-index: 0;
    }

    .navbar-dark .navbar-nav .nav-link.nav-cta-btn > * {
        position: relative;
        z-index: 1;
    }

    .navbar-dark .navbar-nav .nav-link.nav-cta-btn .nav-cta-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.7rem;
        height: 1.7rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.2);
    }

    .navbar-dark .navbar-nav .nav-link.nav-cta-btn .nav-cta-icon i {
        margin-right: 0 !important;
        transition: transform 0.35s ease;
    }

    .navbar-dark .navbar-nav .nav-link.nav-cta-btn .nav-cta-text {
        min-width: auto;
    }

    .navbar-dark .navbar-nav .nav-link.nav-cta-btn:hover,
    .navbar-dark .navbar-nav .nav-link.nav-cta-btn:focus {
        color: #fff !important;
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.34);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .navbar-dark .navbar-nav .nav-link.nav-cta-btn:hover::before,
    .navbar-dark .navbar-nav .nav-link.nav-cta-btn:focus::before {
        opacity: 1;
        transform: translateX(7px);
    }

    .navbar-dark .navbar-nav .nav-link.nav-cta-btn:hover .nav-cta-icon i,
    .navbar-dark .navbar-nav .nav-link.nav-cta-btn:focus .nav-cta-icon i {
        transform: rotate(-12deg);
    }

    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.nav-cta-btn {
        background: rgba(148, 163, 184, 0.12);
        border-color: rgba(148, 163, 184, 0.28);
    }

    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.nav-cta-btn:hover,
    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.nav-cta-btn:focus {
        background: rgba(148, 163, 184, 0.22);
        border-color: rgba(148, 163, 184, 0.38);
    }

    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.nav-cta-btn .nav-cta-icon {
        background: rgba(148, 163, 184, 0.24);
        box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.28);
    }

    .dropdown-menu .dropdown-item.user-route-active {
        background: #fdf2ea;
        color: #c46310;
        font-weight: 600;
    }

    html[data-theme='dark'] .dropdown-menu .dropdown-item.user-route-active {
        background: #4d2010;
        color: #fdf0e4;
    }

    .cart-cta-btn {
        position: relative;
        overflow: hidden;
        isolation: isolate;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: 1px solid rgba(255, 255, 255, 0.26);
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 999px;
        padding: 0.5rem 1rem;
        font-weight: 700;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
        transition: transform 0.25s ease, background-color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }

    .cart-cta-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 22% 50%, rgba(255, 255, 255, 0.22), transparent 56%);
        opacity: 0.8;
        transition: opacity 0.25s ease, transform 0.3s ease;
        pointer-events: none;
        z-index: 0;
    }

    .cart-cta-btn > * {
        position: relative;
        z-index: 1;
    }

    .cart-cta-btn .cart-cta-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.7rem;
        height: 1.7rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.2);
    }

    .cart-cta-btn .cart-cta-icon i {
        transition: transform 0.35s ease;
    }

    .cart-cta-btn .cart-cta-text {
        min-width: 3.65rem;
    }

    .cart-cta-btn:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.34);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .cart-cta-btn:hover::before,
    .cart-cta-btn:focus::before {
        opacity: 1;
        transform: translateX(7px);
    }

    .cart-cta-btn:hover .cart-cta-icon i,
    .cart-cta-btn:focus .cart-cta-icon i {
        transform: rotate(-12deg);
    }

    .cart-cta-btn .badge {
        background: rgba(22, 8, 0, 0.72) !important;
        color: #fff !important;
        font-weight: 700;
    }

    .cart-count-badge {
        min-width: 1.6rem;
    }

    html[data-theme='dark'] .cart-cta-btn {
        background: rgba(148, 163, 184, 0.12);
        border-color: rgba(148, 163, 184, 0.28);
    }

    html[data-theme='dark'] .cart-cta-btn:hover,
    html[data-theme='dark'] .cart-cta-btn:focus {
        background: rgba(148, 163, 184, 0.22);
        border-color: rgba(148, 163, 184, 0.38);
    }

    html[data-theme='dark'] .cart-cta-btn .cart-cta-icon {
        background: rgba(148, 163, 184, 0.24);
        box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.28);
    }

    html[data-theme='dark'] .dz-brand {
        background: rgba(148, 163, 184, 0.18);
        box-shadow: 0 0 0 1px rgba(148, 163, 184, 0.34) inset;
    }

    .theme-switch-btn {
        position: relative;
        overflow: hidden;
        isolation: isolate;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: 1px solid rgba(255, 255, 255, 0.26);
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 999px;
        font-weight: 700;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
        transition: transform 0.25s ease, background-color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }

    .theme-switch-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 22% 50%, rgba(255, 255, 255, 0.22), transparent 56%);
        opacity: 0.8;
        transition: opacity 0.25s ease, transform 0.3s ease;
        pointer-events: none;
        z-index: 0;
    }

    .theme-switch-btn > * {
        position: relative;
        z-index: 1;
    }

    .theme-switch-btn .theme-switch-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.7rem;
        height: 1.7rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.2);
    }

    .theme-switch-btn .theme-switch-icon i {
        transition: transform 0.35s ease;
    }

    .theme-switch-btn .theme-switch-text {
        min-width: 3.65rem;
    }

    .theme-switch-btn:hover,
    .theme-switch-btn:focus {
        color: #fff;
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.34);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .theme-switch-btn:hover::before,
    .theme-switch-btn:focus::before {
        opacity: 1;
        transform: translateX(7px);
    }

    .theme-switch-btn.is-toggling .theme-switch-icon i {
        animation: themeIconSpin 0.45s ease;
    }

    @keyframes themeIconSpin {
        0% {
            transform: rotate(0deg) scale(1);
        }
        45% {
            transform: rotate(125deg) scale(1.18);
        }
        100% {
            transform: rotate(180deg) scale(1);
        }
    }

    html[data-theme='dark'] .theme-switch-btn {
        background: rgba(148, 163, 184, 0.12);
        border-color: rgba(148, 163, 184, 0.28);
    }

    html[data-theme='dark'] .theme-switch-btn:hover,
    html[data-theme='dark'] .theme-switch-btn:focus {
        background: rgba(148, 163, 184, 0.22);
        border-color: rgba(148, 163, 184, 0.38);
    }

    html[data-theme='dark'] .theme-switch-btn .theme-switch-icon {
        background: rgba(148, 163, 184, 0.24);
        box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.28);
    }

    @media (max-width: 991.98px) {
        #navbarSupportedContent {
            padding-top: 0.85rem;
        }

        #navbarSupportedContent .navbar-nav {
            gap: 0.35rem;
            margin-bottom: 0.85rem !important;
        }

        #navbarSupportedContent .btn {
            width: 100%;
            justify-content: center;
        }

        .cart-cta-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .theme-switch-btn {
            width: 100%;
            justify-content: center;
            margin-left: 0 !important;
            margin-top: 0.5rem;
        }

        .dz-brand-logo-full {
            width: 148px;
        }
    }

    @media (max-width: 575.98px) {
        .dz-brand {
            padding: 0.22rem;
        }

        .dz-brand-logo-full {
            display: none;
        }

        .dz-brand-logo-icon {
            display: inline-block;
        }
    }
</style>
@endonce

<nav class="navbar navbar-expand-lg navbar-dark dz-nav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bold dz-brand" href="{{ route('web.index') }}">
            <img
                src="{{ asset('logo_proyecto_con_nombre-removebg-preview.png') }}"
                alt="DisMusic"
                class="dz-brand-logo dz-brand-logo-full"
                onerror="this.onerror=null;this.src='{{ asset('logo_proyecto-removebg-preview.png') }}';"
            >
            <img
                src="{{ asset('logo_proyecto-removebg-preview.png') }}"
                alt="DisMusic"
                class="dz-brand-logo dz-brand-logo-icon"
                onerror="this.onerror=null;this.src='{{ asset('assets/img/AdminLTELogo.png') }}';"
            >
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link nav-scroll-link nav-cta-btn {{ request()->routeIs('web.index') ? 'active is-section-active' : '' }}" href="{{ $inicioHref }}" data-scrollspy-link aria-current="{{ request()->routeIs('web.index') ? 'page' : 'false' }}">
                        <span class="nav-cta-icon"><i class="bi bi-house-door"></i></span>
                        <span class="nav-cta-text">Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-cta-btn {{ request()->routeIs('web.acerca') ? 'active' : '' }}" href="{{ route('web.acerca') }}">
                        <span class="nav-cta-icon"><i class="bi bi-info-circle"></i></span>
                        <span class="nav-cta-text">Acerca</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle dropdown-cta-btn" id="navbarDropdownCatalogo" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-journal-bookmark-fill me-1"></i>Catálogo</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCatalogo">
                        @foreach($catalogos as $catalogo)
                            <li>
                                <a class="dropdown-item" href="{{ route('web.catalogo.show', $catalogo->id) }}">{{ $catalogo->nombre }}</a>
                            </li>
                            @if(!$loop->last)
                                <li><hr class="dropdown-divider" /></li>
                            @endif
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle dropdown-cta-btn" id="navbarDropdownCategoria" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-grid-fill me-1"></i>Categorías</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategoria">
                        @foreach($categorias as $categoria)
                            <li>
                                <a class="dropdown-item" href="{{ route('web.categoria.show', $categoria->id) }}">{{ $categoria->nombre }}</a>
                            </li>
                            @if(!$loop->last)
                                <li><hr class="dropdown-divider" /></li>
                            @endif
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    @auth
                        <a class="nav-link dropdown-toggle dropdown-cta-btn" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                            @canany(['user-list', 'rol-list', 'producto-list', 'categoria-list', 'catalogo-list', 'pedido-list'])
                                <li><h6 class="dropdown-header text-uppercase small fw-bold">Administrador</h6></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Panel de control</a>
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                            @endcanany

                            <li><h6 class="dropdown-header text-uppercase small fw-bold">Cliente</h6></li>
                            <li>
                                <a class="dropdown-item {{ $dashboardClienteActive ? 'user-route-active' : '' }}" href="{{ route('cliente.dashboard') }}" aria-current="{{ $dashboardClienteActive ? 'page' : 'false' }}"><i class="bi bi-bar-chart-line me-2"></i>Mi dashboard</a>
                            </li>
                            <li>
                                @if(auth()->user()->can('pedido-list'))
                                    <a class="dropdown-item" href="{{ route('admin.pedidos') }}"><i class="bi bi-receipt me-2"></i>Pedidos administrador</a>
                                @else
                                    <a class="dropdown-item {{ $misPedidosActive ? 'user-route-active' : '' }}" href="{{ route('perfil.pedidos') }}" aria-current="{{ $misPedidosActive ? 'page' : 'false' }}"><i class="bi bi-receipt me-2"></i>Mis pedidos</a>
                                @endif
                            </li>
                            <li>
                                <a class="dropdown-item {{ $misRecibosActive ? 'user-route-active' : '' }}" href="{{ route('perfil.recibos') }}" aria-current="{{ $misRecibosActive ? 'page' : 'false' }}"><i class="bi bi-file-earmark-text me-2"></i>Recibos factura</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ $miPerfilActive ? 'user-route-active' : '' }}" href="{{ route('perfil.edit') }}" aria-current="{{ $miPerfilActive ? 'page' : 'false' }}"><i class="bi bi-person-circle me-2"></i>Mi perfil</a>
                            </li>
                            <li><hr class="dropdown-divider" /></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-web').submit();">Cerrar sesion</a>
                            </li>
                        </ul>
                        <form id="logout-form-web" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                    @endauth
                </li>
            </ul>

            <a href="{{ route('carrito.mostrar') }}" class="btn cart-cta-btn">
                <span class="cart-cta-icon">
                    <i class="bi bi-cart-fill"></i>
                </span>
                <span class="cart-cta-text">Carrito</span>
                <span class="badge rounded-pill cart-count-badge">{{ session('carrito') ? array_sum(array_column(session('carrito'), 'cantidad')) : 0 }}</span>
            </a>
            <button type="button" class="btn ms-2 theme-switch-btn" data-theme-toggle>
                <span class="theme-switch-icon">
                    <i class="bi bi-moon-stars-fill"></i>
                </span>
                <span class="theme-switch-text" data-theme-label>Oscuro</span>
            </button>
        </div>
    </div>
</nav>
