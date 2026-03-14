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

    .navbar-dark .navbar-nav .nav-link.dropdown-toggle.show,
    .navbar-dark .navbar-nav .nav-item.dropdown.dropdown-lit > .nav-link {
        color: #fff;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.25) inset;
        border-radius: 999px;
    }

    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-link.dropdown-toggle.show,
    html[data-theme='dark'] .navbar-dark .navbar-nav .nav-item.dropdown.dropdown-lit > .nav-link {
        background: rgba(148, 163, 184, 0.2);
        box-shadow: 0 0 0 1px rgba(148, 163, 184, 0.35) inset;
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
        background: linear-gradient(135deg, #c46310, #4d2010);
        color: #fff;
        border: none;
        border-radius: 999px;
        padding: 0.5rem 1rem;
        font-weight: 700;
        box-shadow: 0 10px 24px rgba(196, 99, 16, 0.38);
        transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
    }

    .cart-cta-btn:hover {
        color: #fff;
        transform: translateY(-1px);
        filter: brightness(1.08);
        box-shadow: 0 14px 28px rgba(196, 99, 16, 0.46);
    }

    .cart-cta-btn .badge {
        background: rgba(22, 8, 0, 0.85) !important;
        color: #fff !important;
        font-weight: 700;
    }

    .cart-count-badge {
        min-width: 1.6rem;
    }

    html[data-theme='dark'] .cart-cta-btn {
        background: linear-gradient(135deg, #e07030, #7c2810);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.55);
    }

    html[data-theme='dark'] .dz-brand {
        background: rgba(148, 163, 184, 0.18);
        box-shadow: 0 0 0 1px rgba(148, 163, 184, 0.34) inset;
    }

    .theme-switch-btn {
        border: 1px solid rgba(255, 255, 255, 0.26);
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 999px;
        font-weight: 700;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
    }

    .theme-switch-btn:hover,
    .theme-switch-btn:focus {
        color: #fff;
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.34);
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
                    <a class="nav-link nav-scroll-link {{ request()->routeIs('web.index') ? 'active is-section-active' : '' }}" href="{{ $inicioHref }}" data-scrollspy-link aria-current="{{ request()->routeIs('web.index') ? 'page' : 'false' }}"><i class="bi bi-house-door"></i>Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('web.acerca') ? 'active' : '' }}" href="{{ route('web.acerca') }}"><i class="bi bi-info-circle"></i>Acerca</a>
                </li>

                <li class="nav-item dropdown {{ $catalogoActive ? 'dropdown-lit' : '' }}">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownCatalogo" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Catálogo</a>
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

                <li class="nav-item dropdown {{ $categoriaActive ? 'dropdown-lit' : '' }}">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownCategoria" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorías</a>
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

                <li class="nav-item dropdown {{ $usuarioActive ? 'dropdown-lit' : '' }}">
                    @auth
                        <a class="nav-link dropdown-toggle" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                <i class="bi-cart-fill me-1"></i>
                Carrito
                <span class="badge ms-1 rounded-pill cart-count-badge">{{ session('carrito') ? array_sum(array_column(session('carrito'), 'cantidad')) : 0 }}</span>
            </a>
            <button type="button" class="btn ms-2 theme-switch-btn" data-theme-toggle>
                <i class="bi bi-moon-stars-fill me-1"></i>
                <span data-theme-label>Oscuro</span>
            </button>
        </div>
    </div>
</nav>
