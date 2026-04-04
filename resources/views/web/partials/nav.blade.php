@push('estilos')
<link rel="stylesheet" href="{{ asset('css/nav-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush

@php
    $homeUrl = route('web.index');
    $inicioHref = request()->routeIs('web.index') ? '#inicio' : $homeUrl . '#inicio';
    $dashboardClienteActive = request()->routeIs('cliente.dashboard');
    $misPedidosActive = request()->routeIs('perfil.pedidos');
    $misRecibosActive = request()->routeIs('perfil.recibos*');
    $miPerfilActive = request()->routeIs('perfil.edit') || request()->routeIs('perfil.update');
@endphp

<nav class="navbar navbar-expand-lg navbar-dark dz-nav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bold dz-brand" href="{{ route('web.index') }}">
                  <!-- Logos adaptados a modo claro/oscuro -->
                  <img src="{{ asset('assets/img/recurso11_con_nombre.png') }}" alt="DisMusic Logo" class="dz-brand-logo logo-dis-music dz-logo-custom logo-light img-fluid">
                  <img src="{{ asset('assets/img/recurso12_con_nombre.png') }}" alt="DisMusic Logo" class="dz-brand-logo logo-dis-music dz-logo-custom logo-dark img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link nav-cta-btn {{ request()->routeIs('web.index') ? 'active is-section-active' : '' }}" href="{{ $inicioHref }}" data-scrollspy-link aria-current="{{ request()->routeIs('web.index') ? 'page' : 'false' }}">
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
                <li class="nav-item">
                    <a class="nav-link nav-cta-btn {{ request()->routeIs('web.wishlist') ? 'active' : '' }}" href="{{ route('web.wishlist') }}">
                        <span class="nav-cta-icon"><i class="bi bi-heart-fill"></i></span>
                        <span class="nav-cta-text">Deseados</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-cta-btn {{ request()->routeIs('web.productos') ? 'active' : '' }}" href="{{ route('web.productos') }}">
                        <span class="nav-cta-icon"><i class="bi bi-box-seam"></i></span>
                        <span class="nav-cta-text">productos</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle dropdown-cta-btn" id="navbarDropdownFormato" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-journal-bookmark-fill me-1"></i>Formato</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownFormato">
                        @foreach($catalogos as $catalogo)
                            <li>
                                @if(Route::has('web.formato.show'))
                                    <a class="dropdown-item" href="{{ route('web.formato.show', $catalogo->id) }}">{{ $catalogo->nombre }}</a>
                                @else
                                    <a class="dropdown-item" href="{{ url('/formato-web/'.$catalogo->id) }}">{{ $catalogo->nombre }}</a>
                                @endif
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
                            @canany(['user-list', 'rol-list', 'producto-list', 'categoria-list', 'formato-list', 'pedido-list'])
                                <li><h6 class="dropdown-header text-uppercase small fw-bold">Administrador</h6></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Panel de control</a>
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                            @endcanany

                            <li><h6 class="dropdown-header text-uppercase small fw-bold">Cliente</h6></li>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nav = document.querySelector('.dz-nav');
        if (!nav) return;

        var onScroll = function () {
            if (window.scrollY > 10) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        };

        // Inicializar estado (por si la página carga ya scrolleada)
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    });
</script>
