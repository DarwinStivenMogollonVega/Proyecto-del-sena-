<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('dashboard')}}" class="nav-link">Panel principal</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('web.index')}}" class="nav-link">Tienda</a></li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('admin.guia') }}" class="nav-link">Soporte</a></li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item me-2">
                <button type="button" class="btn admin-theme-toggle" data-theme-toggle>
                    <i class="bi bi-moon-stars-fill me-1"></i>
                    <span data-theme-label>Oscuro</span>
                </button>
            </li>
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            @if(Auth::check())
            @php
                $adminName = Auth::user()->name;
                $adminInitial = strtoupper(mb_substr(trim($adminName), 0, 1));
                $adminEmail = Auth::user()->email;
                $adminSince = optional(Auth::user()->created_at)->format('M Y');
            @endphp
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle admin-profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="admin-profile-avatar" aria-hidden="true">{{ $adminInitial }}</span>
                    <span class="admin-profile-meta d-none d-md-flex">
                        <span class="admin-profile-name">{{ $adminName }}</span>
                        <span class="admin-profile-role">Administrador</span>
                    </span>
                    <i class="bi bi-chevron-down admin-profile-caret" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header admin-user-header">
                        <div class="admin-user-avatar-lg">{{ $adminInitial }}</div>
                        <p class="admin-user-title">{{ $adminName }}</p>
                        <p class="admin-user-email">{{ $adminEmail ?: 'Sin correo registrado' }}</p>
                        <div class="admin-user-badges">
                            <span class="admin-user-badge"><i class="bi bi-shield-check me-1"></i>Administrador</span>
                            @if($adminSince)
                                <span class="admin-user-badge"><i class="bi bi-calendar3 me-1"></i>Desde {{ $adminSince }}</span>
                            @endif
                        </div>
                    </li>

                    <li class="admin-user-quick-links">
                        <a href="{{ route('dashboard') }}" class="admin-user-quick-link">
                            <i class="bi bi-speedometer2"></i>
                            <span>Panel de control</span>
                        </a>
                        <a href="{{ route('admin.pedidos') }}" class="admin-user-quick-link">
                            <i class="bi bi-receipt"></i>
                            <span>Ver pedidos</span>
                        </a>
                    </li>

                    <li class="user-footer">
                        <a href="{{route('perfil.edit')}}" class="btn btn-default btn-flat admin-user-action">Perfil</a>
                        <a href="#" onclick="document.getElementById('logout-form').submit();" class="btn btn-default btn-flat float-end admin-user-action admin-user-logout">Cerrar sesión</a>
                    </li>
                    <form action="{{route('logout')}}" id="logout-form" method="post" class="d-none">
                        @csrf
                    </form>
                </ul>
            </li>
            @endif
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>