<aside class="app-sidebar shadow dz-admin-sidebar">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="{{ asset('logo_proyecto_con_nombre-removebg-preview.png') }}"
                alt="DisMusic"
                class="brand-project-logo brand-project-logo-full shadow-none"
                onerror="this.onerror=null;this.src='{{ asset('logo_proyecto-removebg-preview.png') }}';"
            />
            <img
                src="{{ asset('logo_proyecto-removebg-preview.png') }}"
                alt="DisMusic"
                class="brand-project-logo brand-project-logo-icon shadow-none"
                onerror="this.onerror=null;this.src='{{ asset('assets/img/AdminLTELogo.png') }}';"
            />
            <!--end::Brand Image-->

            <!--begin::Brand Text-->
            <span class="brand-text fw-light">DisMusic</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <li class="nav-header dz-sidebar-section">Principal</li>

                {{-- ── Dashboard ──────────────────────────────────────── --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link" id="mnuDashboard">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('estadisticas.index') }}" class="nav-link" id="mnuEstadisticas">
                        <i class="nav-icon bi bi-bar-chart-line-fill"></i>
                        <p>Estadisticas</p>
                    </a>
                </li>
                @endif

                <li class="dz-sidebar-divider" aria-hidden="true"></li>

                @canany(['user-list', 'rol-list', 'producto-list', 'proveedor-list', 'artista-list', 'categoria-list', 'catalogo-list'])
                <li class="nav-header dz-sidebar-section">Gestión</li>
                @endcanany

                {{-- ── [M-02] Seguridad y Control de Acceso ───────────── --}}
                @canany(['user-list', 'rol-list'])
                <li class="nav-item" id="mnuSeguridad">
                    <a href="#" class="nav-link" id="mnuSeguridadLink">
                        <i class="nav-icon bi bi-shield-lock-fill"></i>
                        <p>
                            Seguridad
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('user-list')
                        <li class="nav-item">
                            <a href="{{ route('usuarios.index') }}" class="nav-link" id="itemUsuario">
                                <i class="nav-icon bi bi-person-fill-gear"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        @endcan

                        @can('rol-list')
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link" id="itemRole">
                                <i class="nav-icon bi bi-key-fill"></i>
                                <p>Roles y Permisos</p>
                            </a>
                        </li>
                        @endcan

                        @canany(['rol-list', 'user-list'])
                        <li class="nav-item">
                            <a href="{{ route('admin.seguridad.index') }}" class="nav-link" id="mnuSeguridadPanel">
                                <i class="nav-icon bi bi-shield-check"></i>
                                <p>Panel de Seguridad</p>
                            </a>
                        </li>
                        @endcanany
                    </ul>
                </li>
                @endcanany

                {{-- ── [M-03] Gestión del Catálogo Musical ────────────── --}}
                @canany(['producto-list', 'artista-list', 'categoria-list', 'catalogo-list'])
                <li class="nav-item" id="mnuCatalogo">
                    <a href="#" class="nav-link" id="mnuCatalogoLink">
                        <i class="nav-icon bi bi-music-note-list"></i>
                        <p>
                            Catálogo Musical
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('producto-list')
                        <li class="nav-item">
                            <a href="{{ route('productos.index') }}" class="nav-link" id="itemProducto">
                                <i class="nav-icon bi bi-vinyl-fill"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                        @endcan

                        @can('artista-list')
                        <li class="nav-item">
                            <a href="{{ route('artistas.index') }}" class="nav-link" id="itemArtista">
                                <i class="nav-icon bi bi-mic-fill"></i>
                                <p>Artistas</p>
                            </a>
                        </li>
                        @endcan

                        @can('categoria-list')
                        <li class="nav-item">
                            <a href="{{ route('categoria.index') }}" class="nav-link" id="itemCategoria">
                                <i class="nav-icon bi bi-tags-fill"></i>
                                <p>Categorías</p>
                            </a>
                        </li>
                        @endcan

                        @can('catalogo-list')
                        <li class="nav-item">
                            <a href="{{ route('catalogo.index') }}" class="nav-link" id="itemCatalogo">
                                <i class="nav-icon bi bi-journal-bookmark-fill"></i>
                                <p>Catálogos</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                <li class="nav-header dz-sidebar-section">Operación</li>

                {{-- ── [M-04] Gestión Comercial ────────────────────────── --}}
                <li class="nav-item" id="mnuComercial">
                    <a href="#" class="nav-link" id="mnuComercialLink">
                        <i class="nav-icon bi bi-cart-check-fill"></i>
                        <p>
                            Gestión Comercial
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(auth()->user()->hasRole('admin'))
                        <li class="nav-item">
                            <a href="{{ route('admin.pedidos') }}" class="nav-link" id="mnuPedidos">
                                <i class="nav-icon bi bi-bag-check-fill"></i>
                                <p>Pedidos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.facturas.index') }}" class="nav-link" id="mnuFacturas">
                                <i class="nav-icon bi bi-receipt-cutoff"></i>
                                <p>Facturas</p>
                            </a>
                        </li>
                        @can('proveedor-list')
                        <li class="nav-item">
                            <a href="{{ route('proveedores.index') }}" class="nav-link" id="mnuProveedores">
                                <i class="nav-icon bi bi-truck"></i>
                                <p>Proveedores</p>
                            </a>
                        </li>
                        @endcan
                        @else
                        <li class="nav-item">
                            <a href="{{ route('perfil.pedidos') }}" class="nav-link" id="mnuPedidos">
                                <i class="nav-icon bi bi-bag-fill"></i>
                                <p>Mis Pedidos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('perfil.recibos') }}" class="nav-link" id="mnuRecibosFactura">
                                <i class="nav-icon bi bi-file-earmark-text-fill"></i>
                                <p>Recibos FE</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>

                {{-- ── [M-05] Administración de Clientes ──────────────── --}}
                @can('user-list')
                <li class="nav-item">
                    <a href="{{ route('admin.clientes.index') }}" class="nav-link" id="mnuClientes">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Clientes</p>
                    </a>
                </li>
                @endcan

                {{-- ── [M-06] Gestión de Inventario ────────────────────── --}}
                @can('inventario-list')
                <li class="nav-item">
                    <a href="{{ route('inventario.index') }}" class="nav-link" id="itemInventario">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Inventario</p>
                    </a>
                </li>
                @endcan

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Auto-open any treeview group that contains an active child
    ['mnuSeguridad', 'mnuCatalogo', 'mnuComercial'].forEach(function(id) {
        var group = document.getElementById(id);
        if (!group) return;
        if (group.querySelector('.nav-treeview .nav-link.active')) {
            group.classList.add('menu-open');
            var link = document.getElementById(id + 'Link');
            if (link) link.classList.add('active');
        }
    });
});
</script>
@endpush
