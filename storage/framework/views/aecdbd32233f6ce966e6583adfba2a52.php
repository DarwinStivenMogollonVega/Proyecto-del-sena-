<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/nav-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php
    $homeUrl = route('web.index');
    $inicioHref = request()->routeIs('web.index') ? '#inicio' : $homeUrl . '#inicio';
    $dashboardClienteActive = request()->routeIs('cliente.dashboard');
    $misPedidosActive = request()->routeIs('perfil.pedidos');
    $misRecibosActive = request()->routeIs('perfil.recibos*');
    $miPerfilActive = request()->routeIs('perfil.edit') || request()->routeIs('perfil.update');
?>

<nav class="navbar navbar-expand-lg navbar-dark dz-nav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bold dz-brand" href="<?php echo e(route('web.index')); ?>">
                  <!-- Logos adaptados a modo claro/oscuro -->
                  <img src="<?php echo e(asset('assets/img/recurso11_con_nombre.png')); ?>" alt="DisMusic Logo" class="dz-brand-logo logo-dis-music dz-logo-custom logo-light img-fluid">
                  <img src="<?php echo e(asset('assets/img/recurso12_con_nombre.png')); ?>" alt="DisMusic Logo" class="dz-brand-logo logo-dis-music dz-logo-custom logo-dark img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link nav-cta-btn <?php echo e(request()->routeIs('web.index') ? 'active is-section-active' : ''); ?>" href="<?php echo e($inicioHref); ?>" data-scrollspy-link aria-current="<?php echo e(request()->routeIs('web.index') ? 'page' : 'false'); ?>">
                        <span class="nav-cta-icon"><i class="bi bi-house-door"></i></span>
                        <span class="nav-cta-text">Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-cta-btn <?php echo e(request()->routeIs('web.acerca') ? 'active' : ''); ?>" href="<?php echo e(route('web.acerca')); ?>">
                        <span class="nav-cta-icon"><i class="bi bi-info-circle"></i></span>
                        <span class="nav-cta-text">Acerca</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-cta-btn <?php echo e(request()->routeIs('web.wishlist') ? 'active' : ''); ?>" href="<?php echo e(route('web.wishlist')); ?>">
                        <span class="nav-cta-icon"><i class="bi bi-heart-fill"></i></span>
                        <span class="nav-cta-text">Deseados</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-cta-btn <?php echo e(request()->routeIs('web.productos') ? 'active' : ''); ?>" href="<?php echo e(route('web.productos')); ?>">
                        <span class="nav-cta-icon"><i class="bi bi-box-seam"></i></span>
                        <span class="nav-cta-text">productos</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle dropdown-cta-btn" id="navbarDropdownFormato" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-journal-bookmark-fill me-1"></i>Formato</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownFormato">
                        <?php $__currentLoopData = $catalogos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catalogo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <?php if(Route::has('web.formato.show')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('web.formato.show', $catalogo->id)); ?>"><?php echo e($catalogo->nombre); ?></a>
                                <?php else: ?>
                                    <a class="dropdown-item" href="<?php echo e(url('/formato-web/'.$catalogo->id)); ?>"><?php echo e($catalogo->nombre); ?></a>
                                <?php endif; ?>
                            </li>
                            <?php if(!$loop->last): ?>
                                <li><hr class="dropdown-divider" /></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle dropdown-cta-btn" id="navbarDropdownCategoria" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-grid-fill me-1"></i>Categorías</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategoria">
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('web.categoria.show', $categoria->id)); ?>"><?php echo e($categoria->nombre); ?></a>
                            </li>
                            <?php if(!$loop->last): ?>
                                <li><hr class="dropdown-divider" /></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <?php if(auth()->guard()->check()): ?>
                        <a class="nav-link dropdown-toggle dropdown-cta-btn" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i><?php echo e(auth()->user()->name); ?>

                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user-list', 'rol-list', 'producto-list', 'categoria-list', 'formato-list', 'pedido-list'])): ?>
                                <li><h6 class="dropdown-header text-uppercase small fw-bold">Administrador</h6></li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>"><i class="bi bi-speedometer2 me-2"></i>Panel de control</a>
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                            <?php endif; ?>

                            <li><h6 class="dropdown-header text-uppercase small fw-bold">Cliente</h6></li>
                            <li>
                                <?php if(auth()->user()->can('pedido-list')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.pedidos')); ?>"><i class="bi bi-receipt me-2"></i>Pedidos administrador</a>
                                <?php else: ?>
                                    <a class="dropdown-item <?php echo e($misPedidosActive ? 'user-route-active' : ''); ?>" href="<?php echo e(route('perfil.pedidos')); ?>" aria-current="<?php echo e($misPedidosActive ? 'page' : 'false'); ?>"><i class="bi bi-receipt me-2"></i>Mis pedidos</a>
                                <?php endif; ?>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo e($misRecibosActive ? 'user-route-active' : ''); ?>" href="<?php echo e(route('perfil.recibos')); ?>" aria-current="<?php echo e($misRecibosActive ? 'page' : 'false'); ?>"><i class="bi bi-file-earmark-text me-2"></i>Recibos factura</a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo e($miPerfilActive ? 'user-route-active' : ''); ?>" href="<?php echo e(route('perfil.edit')); ?>" aria-current="<?php echo e($miPerfilActive ? 'page' : 'false'); ?>"><i class="bi bi-person-circle me-2"></i>Mi perfil</a>
                            </li>
                            <li><hr class="dropdown-divider" /></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-web').submit();">Cerrar sesion</a>
                            </li>
                        </ul>
                        <form id="logout-form-web" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    <?php else: ?>
                        <a class="nav-link nav-cta-btn" href="<?php echo e(route('login')); ?>">
                            <span class="nav-cta-icon"><i class="bi bi-box-arrow-in-right"></i></span>
                            <span class="nav-cta-text">Iniciar sesión</span>
                        </a>
                    <?php endif; ?>
                </li>
            </ul>

            <?php if (! (View::hasSection('hide_nav_actions'))): ?>
            <a href="<?php echo e(route('carrito.mostrar')); ?>" class="btn cart-cta-btn">
                <span class="cart-cta-icon">
                    <i class="bi bi-cart-fill"></i>
                </span>
                <span class="cart-cta-text">Carrito</span>
                <span class="badge rounded-pill cart-count-badge"><?php echo e(session('carrito') ? array_sum(array_column(session('carrito'), 'cantidad')) : 0); ?></span>
            </a>
            <button type="button" class="btn ms-2 theme-switch-btn" data-theme-toggle>
                <span class="theme-switch-icon">
                    <i class="bi bi-moon-stars-fill"></i>
                </span>
                <span class="theme-switch-text" data-theme-label>Oscuro</span>
            </button>
            <?php endif; ?>
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

        // Toggle 'scrolled-pill' on cart and theme buttons to force final pill styles
        var cartBtn = document.querySelector('.cart-cta-btn');
        var themeBtn = document.querySelector('.theme-switch-btn');
        var togglePills = function () {
            var sc = window.scrollY > 10;
            if (cartBtn) cartBtn.classList.toggle('scrolled-pill', sc);
            if (themeBtn) themeBtn.classList.toggle('scrolled-pill', sc);
        };

        // Inicializar estado (por si la página carga ya scrolleada)
        onScroll();
        togglePills();
        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('scroll', togglePills, { passive: true });
    });
    
        // Interceptar formularios "Agregar al carrito" para actualizar la badge sin recargar
        document.addEventListener('DOMContentLoaded', function () {
            // Evita registrar el listener más de una vez (por inclusiones duplicadas del partial)
            if (window.__dzAddToCartInit) return;
            window.__dzAddToCartInit = true;

            // Delegación: capturamos submit de cualquier formulario que contenga un botón con clase .add-to-cart-btn
            document.body.addEventListener('submit', function (e) {
                var form = e.target;
                if (!form) return;
                if (!form.querySelector || !form.querySelector('.add-to-cart-btn')) return;

                e.preventDefault();

                var url = form.getAttribute('action');
                var method = (form.getAttribute('method') || 'POST').toUpperCase();
                var fd = new FormData(form);

                fetch(url, {
                    method: method,
                    body: fd,
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(function (res) {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                }).then(function (data) {
                    if (data && typeof data.items !== 'undefined') {
                        var badge = document.querySelector('.cart-count-badge');
                        if (badge) {
                            badge.textContent = data.items;
                            // pequeña animación de actualización
                            badge.classList.add('cart-count-updated');
                            setTimeout(function () { badge.classList.remove('cart-count-updated'); }, 800);
                        }
                        // Mostrar toast global de confirmación (usa el contenedor en web.app)
                        try {
                            var toastEl = document.getElementById('dz-global-toast');
                            if (toastEl) {
                                var body = toastEl.querySelector('.toast-body');
                                if (body) body.textContent = 'Producto agregado al carrito';
                                // Inicializar y mostrar toast via Bootstrap
                                if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
                                    var bsToast = bootstrap.Toast.getOrCreateInstance(toastEl);
                                    bsToast.show();
                                }
                            }
                        } catch (e) {
                            console.warn('No se pudo mostrar el toast del carrito', e);
                        }
                    }
                }).catch(function (err) {
                    // En caso de fallo, dejar que el comportamiento por defecto ocurra (recarga)
                    console.error('Error agregando al carrito (AJAX):', err);
                    form.submit();
                });
            }, { passive: false });
        });

</script>
<?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/partials/nav.blade.php ENDPATH**/ ?>