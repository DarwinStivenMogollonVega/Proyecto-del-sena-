<?php if (! $__env->hasRenderedOnce('6b95af99-029e-4833-ab5e-f959a654528b')): $__env->markAsRenderedOnce('6b95af99-029e-4833-ab5e-f959a654528b'); ?>
<style>
    .dz-admin-sidebar .sidebar-brand {
        background: var(--adm-sidebar-panel);
        border-bottom: 1px solid var(--adm-sidebar-border);
    }

    .dz-admin-sidebar .sidebar-brand .brand-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.95rem 0.8rem;
    }

    .dz-admin-sidebar .sidebar-brand .brand-project-logo-full {
        margin-right: 0;
        border-radius: 0.7rem;
        padding: 0.28rem 0.4rem;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(15, 23, 42, 0.12);
        box-shadow: 0 10px 22px rgba(2, 6, 23, 0.16);
    }

    .dz-admin-sidebar .sidebar-brand .brand-project-logo-icon {
        margin-right: 0;
        padding: 0.2rem;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(15, 23, 42, 0.12);
        box-shadow: 0 10px 22px rgba(2, 6, 23, 0.16);
    }

    html[data-theme='dark'] .dz-admin-sidebar .sidebar-brand .brand-project-logo-full,
    html[data-theme='dark'] .dz-admin-sidebar .sidebar-brand .brand-project-logo-icon {
        background: rgba(255, 255, 255, 0.94);
        border-color: rgba(255, 255, 255, 0.2);
    }
</style>
<?php endif; ?>

<aside class="app-sidebar shadow dz-admin-sidebar">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="<?php echo e(route('dashboard')); ?>" class="brand-link">
            <!-- Logos adaptados a modo claro/oscuro -->
            <img src="<?php echo e(asset('assets/img/recurso11.png')); ?>" alt="DisMusic Logo" class="brand-project-logo brand-project-logo-full logo-dis-music light shadow-none" />
            <img src="<?php echo e(asset('assets/img/recurso12.png')); ?>" alt="DisMusic Logo" class="brand-project-logo brand-project-logo-full logo-dis-music dark shadow-none" />
            <!--end::Brand Image-->

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

                
                <li class="nav-item">
                    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link" id="mnuDashboard">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if(auth()->user()->hasRole('admin')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('estadisticas.index')); ?>" class="nav-link" id="mnuEstadisticas">
                        <i class="nav-icon bi bi-bar-chart-line-fill"></i>
                        <p>Estadisticas</p>
                    </a>
                </li>
                <?php endif; ?>

                <li class="dz-sidebar-divider" aria-hidden="true"></li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-list', 'rol-list', 'producto-list', 'proveedor-list', 'artista-list', 'categoria-list', 'formato-list'])): ?>
                <li class="nav-header dz-sidebar-section">Gestión</li>
                <?php endif; ?>

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-list', 'rol-list'])): ?>
                <li class="nav-item" id="mnuSeguridad">
                    <a href="#" class="nav-link" id="mnuSeguridadLink">
                        <i class="nav-icon bi bi-shield-lock-fill"></i>
                        <p>
                            Seguridad
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('usuarios.index')); ?>" class="nav-link" id="itemUsuario">
                                <i class="nav-icon bi bi-person-fill-gear"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rol-list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('roles.index')); ?>" class="nav-link" id="itemRole">
                                <i class="nav-icon bi bi-key-fill"></i>
                                <p>Roles y Permisos</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        
                    </ul>
                </li>
                <?php endif; ?>

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['producto-list', 'artista-list', 'categoria-list', 'formato-list'])): ?>
                <li class="nav-item" id="mnuFormato">
                    <a href="#" class="nav-link" id="mnuFormatoLink">
                        <i class="nav-icon bi bi-music-note-list"></i>
                        <p>
                            Formato Musical
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('producto-list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('productos.index')); ?>" class="nav-link" id="itemProducto">
                                <i class="nav-icon bi bi-vinyl-fill"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('artista-list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('artistas.index')); ?>" class="nav-link" id="itemArtista">
                                <i class="nav-icon bi bi-mic-fill"></i>
                                <p>Artistas</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('categoria-list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('categoria.index')); ?>" class="nav-link" id="itemCategoria">
                                <i class="nav-icon bi bi-tags-fill"></i>
                                <p>Categorías</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['formato-list','producto-list'])): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('formato.index')); ?>" class="nav-link" id="itemFormato">
                                <i class="nav-icon bi bi-journal-bookmark-fill"></i>
                                <p>Formatos</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['album-list','formato-list','producto-list'])): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('albums.index')); ?>" class="nav-link" id="itemAlbum">
                                <i class="nav-icon bi bi-collection-fill"></i>
                                <p>Álbumes</p>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <li class="nav-header dz-sidebar-section">Operación</li>

                
                <li class="nav-item" id="mnuComercial">
                    <a href="#" class="nav-link" id="mnuComercialLink">
                        <i class="nav-icon bi bi-cart-check-fill"></i>
                        <p>
                            Gestión Comercial
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if(auth()->user()->hasRole('admin')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.pedidos')); ?>" class="nav-link" id="mnuPedidos">
                                <i class="nav-icon bi bi-bag-check-fill"></i>
                                <p>Pedidos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.facturas.index')); ?>" class="nav-link" id="mnuFacturas">
                                <i class="nav-icon bi bi-receipt-cutoff"></i>
                                <p>Facturas</p>
                            </a>
                        </li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('proveedor-list')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('proveedores.index')); ?>" class="nav-link" id="mnuProveedores">
                                <i class="nav-icon bi bi-truck"></i>
                                <p>Proveedores</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php else: ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('perfil.pedidos')); ?>" class="nav-link" id="mnuPedidos">
                                <i class="nav-icon bi bi-bag-fill"></i>
                                <p>Mis Pedidos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('perfil.recibos')); ?>" class="nav-link" id="mnuRecibosFactura">
                                <i class="nav-icon bi bi-file-earmark-text-fill"></i>
                                <p>Recibos FE</p>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.clientes.index')); ?>" class="nav-link" id="mnuClientes">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Clientes</p>
                    </a>
                </li>
                <?php endif; ?>

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inventario-list')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('inventario.index')); ?>" class="nav-link" id="itemInventario">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Inventario</p>
                    </a>
                </li>
                <?php endif; ?>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>

<!-- Mobile backdrop for sidebar -->
<div class="sidebar-mobile-backdrop d-md-none" id="sidebarBackdrop" aria-hidden="true"></div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Auto-open any treeview group that contains an active child
    ['mnuSeguridad', 'mnuFormato', 'mnuComercial'].forEach(function(id) {
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
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/plantilla/menu.blade.php ENDPATH**/ ?>