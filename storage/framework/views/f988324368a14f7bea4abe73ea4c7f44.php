<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="title" content="Shop | DiscZone.com" />
    <meta name="author" content="DiscZone" />
    <meta name="description" content="Shop | DiscZone.com" />
    <meta name="keywords" content="Shop, DiscZone" />
    <title><?php echo $__env->yieldContent('titulo', 'Shop - DiscZone'); ?></title>
    <script>
        (function () {
            var savedTheme = localStorage.getItem('dz-theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.documentElement.setAttribute('data-bs-theme', savedTheme === 'dark' ? 'dark' : 'light');
        })();
        // Marca inicial: evita mostrar header/nav hasta que la inicialización JS y CSS ocurran
        document.documentElement.classList.add('dz-initializing');
    </script>

    <!-- Critical CSS to avoid FOUC on logos / header while main CSS loads -->
    <style>
        /* Constrain logo visuals until external CSS loads to prevent flash */
        img.logo-dis-music,
        img.logo-light,
        img.logo-dark,
        .dz-brand-logo,
        .logo-dis-music {
            height: auto;
            display: block;
        }

        /* Default state: show light variant, hide dark variant until CSS or JS switches theme */
        .logo-dark,
        .logo-dis-music.dark {
            display: none !important;
        }

        html[data-theme='dark'] .logo-dis-music.light,
        html[data-theme='dark'] .logo-light {
            display: none !important;
        }
        html[data-theme='dark'] .logo-dis-music.dark,
        html[data-theme='dark'] .logo-dark {
            display: block !important;
        }
        /* Mientras dure la inicialización mantenemos ocultos header y nav */
        html.dz-initializing .dz-site-header,
        html.dz-initializing .dz-nav {
            visibility: hidden !important;
            opacity: 0 !important;
            transform: translateY(-6px) !important;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/favicon.ico')); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('css/app-section.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/index-section.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('css/nav-fix.css')); ?>">
    <style>
        /* Evita FOUC: oculta el nav hasta que la inicialización JS lo muestre */
        .dz-nav{opacity:0;transform:translateY(-6px);transition:opacity .28s ease, transform .28s ease}
        .dz-nav.is-ready{opacity:1;transform:none}
    </style>
    <?php echo $__env->yieldPushContent('estilos'); ?>
</head>
    <body>
    
    <?php if(View::hasSection('manual_nav')): ?>
        <?php echo $__env->yieldContent('manual_nav'); ?>
    <?php else: ?>
        <?php if(!View::hasSection('hide_nav')): ?>
            <?php echo $__env->make('web.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php
        $showHeader = request()->routeIs('web.index', 'web.productos*', 'web.formato*', 'web.categoria*');
    ?>

    <!-- Toast container for global notifications -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
        <div id="dz-global-toast" class="toast align-items-center text-bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
        </div>
    </div>

    <?php if($showHeader): ?>
        <?php echo $__env->make('web.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <main class="dz-main-content" style="padding-top:0; margin-top:0;">
        <?php echo $__env->yieldContent('contenido'); ?>
    </main>

    <?php echo $__env->make('web.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/scripts.js')); ?>"></script>
    <script src="<?php echo e(asset('js/wishlist-toggle.js')); ?>"></script>
    <script>
        (function () {
            function initSiteVisualFx() {
                var selectors = [
                    '.dz-main-content > *',
                    '.card',
                    '.dz-panel',
                    '.alert',
                    '.table-responsive',
                    '.product-card',
                    '.category-card',
                    '.checkout-summary',
                    '.profile-card',
                    '.orders-card',
                    '.store-hero',
                    '.client-hero',
                    '.orders-hero',
                    '.profile-hero',
                    '.cart-hero',
                    '.checkout-hero'
                ];

                var elements = Array.from(document.querySelectorAll(selectors.join(',')))
                    .filter(function (element, index, list) {
                        return element && list.indexOf(element) === index;
                    });

                if (!elements.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    return;
                }

                elements.forEach(function (element, index) {
                    element.classList.add('fx-reveal');
                    element.style.transitionDelay = Math.min(index * 8, 48) + 'ms';
                });

                var reveal = function (element) {
                    element.classList.add('fx-visible');
                };

                if (!('IntersectionObserver' in window)) {
                    requestAnimationFrame(function () {
                        elements.forEach(reveal);
                    });
                    return;
                }

                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) {
                            return;
                        }
                        reveal(entry.target);
                        observer.unobserve(entry.target);
                    });
                }, { threshold: 0.04, rootMargin: '0px 0px -10px 0px' });

                requestAnimationFrame(function () {
                    elements.forEach(function (element) {
                        observer.observe(element);
                    });
                });
            }

            function applyTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                document.documentElement.setAttribute('data-bs-theme', theme === 'dark' ? 'dark' : 'light');
                localStorage.setItem('dz-theme', theme);
                var buttons = document.querySelectorAll('[data-theme-toggle]');
                buttons.forEach(function (btn) {
                    var icon = btn.querySelector('i');
                    var label = btn.querySelector('[data-theme-label]');
                    if (icon) {
                        icon.className = theme === 'dark' ? 'bi bi-moon-stars-fill' : 'bi bi-sun-fill';
                    }
                    if (label) {
                        label.textContent = theme === 'dark' ? 'Oscuro' : 'Claro';
                    }
                });

                document.documentElement.classList.add('theme-shifting');
                clearTimeout(window.__dzThemeShiftTimer);
                window.__dzThemeShiftTimer = setTimeout(function () {
                    document.documentElement.classList.remove('theme-shifting');
                }, 430);
            }

            function initHoverDropdowns() {
                if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches || typeof bootstrap === 'undefined') {
                    return;
                }

                document.querySelectorAll('.navbar .dropdown').forEach(function (dropdown) {
                    var toggle = dropdown.querySelector('.dropdown-toggle');
                    if (!toggle) {
                        return;
                    }

                    var instance = bootstrap.Dropdown.getOrCreateInstance(toggle);
                    var hideTimer;

                    dropdown.addEventListener('mouseenter', function () {
                        if (hideTimer) {
                            clearTimeout(hideTimer);
                        }
                        instance.show();
                    });

                    dropdown.addEventListener('mouseleave', function () {
                        hideTimer = setTimeout(function () {
                            instance.hide();
                        }, 120);
                    });
                });
            }

            document.addEventListener('click', function (e) {
                var toggle = e.target.closest('[data-theme-toggle]');
                if (!toggle) {
                    return;
                }
                e.preventDefault();
                e.stopPropagation();
                /* Cooldown: ignora disparos rápidos (doble clic, tecla retenida, hold) */
                if (window.__dzThemeToggleLocked) {
                    return;
                }
                window.__dzThemeToggleLocked = true;
                setTimeout(function () {
                    window.__dzThemeToggleLocked = false;
                }, 700);
                toggle.classList.add('is-toggling');
                setTimeout(function () {
                    toggle.classList.remove('is-toggling');
                }, 460);
                var current = document.documentElement.getAttribute('data-theme') || 'light';
                applyTheme(current === 'dark' ? 'light' : 'dark');
            });

            applyTheme(document.documentElement.getAttribute('data-theme') || 'light');
            initSiteVisualFx();
            initHoverDropdowns();
            // Mostrar el nav una vez que las inicializaciones JS han corrido
            (function(){
                var nav = document.querySelector('.dz-nav');
                if(!nav) return;
                // pequeña espera para permitir render y estilos; evita parpadeos visibles
                setTimeout(function(){ nav.classList.add('is-ready'); }, 40);
                // Quitamos la marca de inicialización para permitir que el header se muestre
                setTimeout(function(){ document.documentElement.classList.remove('dz-initializing'); }, 60);
            })();
        })();
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/app.blade.php ENDPATH**/ ?>