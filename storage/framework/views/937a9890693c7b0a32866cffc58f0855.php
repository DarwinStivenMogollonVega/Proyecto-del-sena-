<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link d-none d-md-inline-block" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
                <!-- Mobile sidebar toggle (visible on small screens) -->
                <a class="nav-link d-md-none" href="#" role="button" data-sidebar-toggle>
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="<?php echo e(route('dashboard')); ?>" class="nav-link navbar-nav-link">Panel principal</a></li>
            <li class="nav-item d-none d-md-block"><a href="<?php echo e(route('web.index')); ?>" class="nav-link navbar-nav-link">Tienda</a></li>
            <li class="nav-item d-none d-md-block"><a href="<?php echo e(route('admin.guia')); ?>" class="nav-link navbar-nav-link">Soporte</a></li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item me-2">
                <button type="button" class="btn nav-cta-btn admin-theme-toggle" data-theme-toggle>
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
                <?php if(Auth::check()): ?>
                <?php
                    $adminName = Auth::user()->name;
                    $adminInitial = strtoupper(mb_substr(trim($adminName), 0, 1));
                    $adminEmail = Auth::user()->email;
                    $adminSince = optional(Auth::user()->created_at)->format('M Y');
                ?>
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle admin-profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php $avatarPath = 'uploads/avatars/' . (Auth::user()->avatar ?? ''); ?>
                        <?php if(!empty(Auth::user()->avatar)): ?>
                            <img src="<?php echo e(asset($avatarPath)); ?>" alt="Avatar" class="admin-profile-avatar-img" style="width:32px; height:32px; border-radius:50%; object-fit:cover; display:inline-block; vertical-align:middle;" />
                        <?php else: ?>
                            <span class="admin-profile-avatar" aria-hidden="true"><?php echo e($adminInitial); ?></span>
                        <?php endif; ?>
                        <span class="admin-profile-meta d-none d-md-flex">
                            <span class="admin-profile-name"><?php echo e($adminName); ?></span>
                            <span class="admin-profile-role">Administrador</span>
                        </span>
                        <i class="bi bi-chevron-down admin-profile-caret" aria-hidden="true"></i>
                    </a>

                
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header admin-user-header">
                        <div class="admin-user-avatar-lg">
                            <?php if(!empty(Auth::user()->avatar)): ?>
                                <img src="<?php echo e(asset($avatarPath)); ?>" alt="Avatar" style="width:100%; height:100%; object-fit:cover; border-radius:999px;" />
                            <?php else: ?>
                                <?php echo e($adminInitial); ?>

                            <?php endif; ?>
                        </div>
                        <p class="admin-user-title"><?php echo e($adminName); ?></p>
                        <p class="admin-user-email"><?php echo e($adminEmail ?: 'Sin correo registrado'); ?></p>
                        <div class="admin-user-badges">
                            <span class="admin-user-badge"><i class="bi bi-shield-check me-1"></i>Administrador</span>
                            <?php if($adminSince): ?>
                                <span class="admin-user-badge"><i class="bi bi-calendar3 me-1"></i>Desde <?php echo e($adminSince); ?></span>
                            <?php endif; ?>
                        </div>
                    </li>

                    <li class="admin-user-quick-links">
                        <a href="<?php echo e(route('dashboard')); ?>" class="admin-user-quick-link">
                            <i class="bi bi-speedometer2"></i>
                            <span>Panel de control</span>
                        </a>
                        <a href="<?php echo e(route('admin.pedidos')); ?>" class="admin-user-quick-link">
                            <i class="bi bi-receipt"></i>
                            <span>Ver pedidos</span>
                        </a>
                    </li>

                    <li class="user-footer">
                        <a href="<?php echo e(route('perfil.edit')); ?>" class="btn nav-cta-btn btn-default btn-flat admin-user-action">Perfil</a>
                        <a href="#" onclick="document.getElementById('logout-form').submit();" class="btn nav-cta-btn btn-default btn-flat float-end admin-user-action admin-user-logout">Cerrar sesión</a>
                    </li>
                    <form action="<?php echo e(route('logout')); ?>" id="logout-form" method="post" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>
                </ul>
            </li>
            <?php endif; ?>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/plantilla/header.blade.php ENDPATH**/ ?>