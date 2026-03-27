<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/header-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('header'); ?>
<?php echo $__env->make('web.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container px-4 px-lg-5">
    <section id="inicio" class="store-hero p-4 p-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="store-hero-brand">
                    <!-- Logo removido por solicitud -->
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

    <?php if(session('success')): ?>
        <div class="alert alert-success text-center mt-3"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('mensaje')): ?>
        <div class="alert alert-success text-center mt-3"><?php echo e(session('mensaje')); ?></div>
    <?php endif; ?>

    <div class="row g-3 mt-2">
        <div class="col-6 col-md-3"><div class="metric-pill"><strong><?php echo e($metricas['totalProductos']); ?></strong><span>Productos</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong><?php echo e($metricas['disponibles']); ?></strong><span>Disponibles</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong><?php echo e($metricas['totalCategorias']); ?></strong><span>Categorias</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong><?php echo e($metricas['totalCatalogos']); ?></strong><span>Catalogos</span></div></div>
    </div>

    <form id="explorar" method="GET" action="<?php echo e(route('web.index')); ?>" class="search-panel p-3 p-md-4 mt-4">
        <div class="row align-items-end g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold" for="searchInput">Buscar por nombre</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Ejemplo: Rock Clasico" name="search" value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold" for="sortSelect">Ordenar resultados</label>
                <div class="input-group">
                    <select class="form-select" id="sortSelect" name="sort" onchange="this.form.submit()">
                        <option value="">Orden predeterminado</option>
                        <option value="priceAsc" <?php echo e(request('sort') == 'priceAsc' ? 'selected' : ''); ?>>Precio: menor a mayor</option>
                        <option value="priceDesc" <?php echo e(request('sort') == 'priceDesc' ? 'selected' : ''); ?>>Precio: mayor a menor</option>
                    </select>
                    <button class="btn btn-dark" type="submit">Aplicar</button>
                </div>
            </div>
        </div>
    </form>

    <section id="productos" class="mt-5">
        <?php $__currentLoopData = [
            ['title' => 'Los mas vendidos', 'icon' => 'bi-fire', 'items' => $masMasVendidos],
            ['title' => 'Los mejor valorados', 'icon' => 'bi-star-fill', 'items' => $mejorValorados],
            ['title' => 'Ofertas especiales', 'icon' => 'bi-tag', 'items' => $ofertasEspeciales],
            ['title' => 'Disponibles ahora', 'icon' => 'bi-check2-circle', 'items' => $disponiblesAhora],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($section['items']->isNotEmpty()): ?>
                <div class="product-section">
                    <div class="section-title">
                        <i class="bi <?php echo e($section['icon']); ?> icon"></i>
                        <h3><?php echo e($section['title']); ?></h3>
                        <span class="section-badge"><?php echo e($section['items']->count()); ?> productos</span>
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
                        <?php $__currentLoopData = $section['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="product-carousel-item">
                                <?php
                                    $stock  = (int) ($producto->cantidad ?? 0);
                                    $rating = round((float) ($producto->resenas_avg_puntuacion ?? 0), 1);
                                    $rCount = (int) ($producto->resenas_count ?? 0);
                                ?>
                                <article class="all-product-card">
                                    <div class="all-product-cover">
                                        <?php if($producto->imagen): ?>
                                            <img src="<?php echo e(asset('uploads/productos/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('img/no-image.jpg')); ?>" alt="Sin imagen">
                                        <?php endif; ?>
                                        <?php if($stock >= 50): ?>
                                            <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                        <?php elseif($stock > 0): ?>
                                            <span class="all-product-stock badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                                        <?php else: ?>
                                            <span class="all-product-stock badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="all-product-body">
                                        <p class="all-product-name" title="<?php echo e($producto->nombre); ?>"><?php echo e($producto->nombre); ?></p>
                                        <p class="all-product-artist"><?php echo e($producto->artista?->nombre ?? 'Artista no especificado'); ?></p>
                                        <?php if($stock >= 50): ?>
                                            <span class="all-product-discount"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                        <?php elseif($stock > 0): ?>
                                            <span class="all-product-discount"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                                        <?php else: ?>
                                            <span class="all-product-discount"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                        <?php endif; ?>
                                        <div class="all-product-meta">
                                            <?php if($producto->categoria): ?>
                                                <span class="all-product-chip"><i class="bi bi-tags-fill me-1"></i><?php echo e($producto->categoria->nombre); ?></span>
                                            <?php endif; ?>
                                            <?php if($producto->catalogo): ?>
                                                <span class="all-product-chip"><i class="bi bi-journal-bookmark-fill me-1"></i><?php echo e($producto->catalogo->nombre); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="all-product-inline-stats">
                                            <span><i class="bi bi-star-fill text-warning me-1"></i><?php echo e(number_format($rating, 1)); ?></span>
                                            <span><i class="bi bi-chat-left-text me-1"></i><?php echo e($rCount); ?></span>
                                            <span><i class="bi bi-box-seam me-1"></i><?php echo e($stock); ?></span>
                                        </div>
                                        <?php
                                            $inWishlist = session('wishlist') && array_key_exists($producto->getKey(), session('wishlist'));
                                        ?>
                                        <?php if($inWishlist): ?>
                                            <form action="<?php echo e(route('web.wishlist.remove', $producto->getKey())); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="all-product-wishlist-btn" title="Quitar de deseados">
                                                    <i class="bi bi-heart-fill text-danger"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form action="<?php echo e(route('web.wishlist.add', $producto->getKey())); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="all-product-wishlist-btn" title="Agregar a deseados">
                                                    <i class="bi bi-heart"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('web.show', $producto->getKey())); ?>" class="all-product-cta" title="Ver producto">
                                            <i class="bi bi-eye"></i> ver
                                        </a>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="product-carousel-progress" data-carousel-progress aria-hidden="true"></div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($masMasVendidos->isEmpty() && $mejorValorados->isEmpty() && $ofertasEspeciales->isEmpty() && $disponiblesAhora->isEmpty()): ?>
            <div class="text-center py-5 border rounded-4 bg-light-subtle">
                <p class="text-muted mb-0">No se encontraron productos con esos filtros.</p>
            </div>
        <?php endif; ?>
    </section>

    <section class="all-products-section">
        <div class="all-products-head d-flex align-items-center" style="gap:0.7rem;">
            <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-grid-3x3-gap-fill me-2"></i>Todos los productos
                <span class="section-badge ms-2"><?php echo e($productos->total()); ?> registrados</span>
            </h4>
        </div><br>

        <?php if($productos->count()): ?>
            <div class="all-products-grid">
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $ratingAll = (float) ($producto->resenas_avg_puntuacion ?? 0);
                        $reviewsAll = (int) ($producto->resenas_count ?? 0);
                        $stockAll = (int) ($producto->cantidad ?? 0);
                    ?>
                    <article class="all-product-card">
                        <div class="all-product-cover">
                            <?php if($producto->imagen): ?>
                                <img src="<?php echo e(asset('uploads/productos/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>">
                            <?php else: ?>
                                <img src="<?php echo e(asset('img/no-image.jpg')); ?>" alt="Sin imagen">
                            <?php endif; ?>

                            <?php if($stockAll >= 50): ?>
                                <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                            <?php elseif($stockAll > 0): ?>
                                <span class="all-product-stock badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                            <?php else: ?>
                                <span class="all-product-stock badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                            <?php endif; ?>
                        </div>

                        <div class="all-product-body">
                            <p class="all-product-name" title="<?php echo e($producto->nombre); ?>"><?php echo e($producto->nombre); ?></p>
                            <p class="all-product-artist"><?php echo e($producto->artista?->nombre ?? 'Artista no especificado'); ?></p>
                            <?php if($stockAll >= 50): ?>
                                <span class="all-product-discount"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                            <?php elseif($stockAll > 0): ?>
                                <span class="all-product-discount"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                            <?php else: ?>
                                <span class="all-product-discount"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                            <?php endif; ?>
                            <?php if($producto->descuento > 0): ?>
                                <p class="all-product-price text-danger fw-bold">
                                    <i class="bi bi-tag-fill me-1"></i>
                                    $<?php echo e(number_format($producto->precio - $producto->descuento, 2)); ?>

                                    <span class="text-decoration-line-through text-muted ms-2">$<?php echo e(number_format($producto->precio, 2)); ?></span>
                                    <span class="badge bg-warning text-dark ms-2">- $<?php echo e(number_format($producto->descuento, 2)); ?> descuento</span>
                                </p>
                            <?php else: ?>
                                <p class="all-product-price">$<?php echo e(number_format($producto->precio, 2)); ?></p>
                            <?php endif; ?>

                            <div class="all-product-meta">
                                <?php if($producto->categoria): ?>
                                    <span class="all-product-chip"><i class="bi bi-tags-fill me-1"></i><?php echo e($producto->categoria->nombre); ?></span>
                                <?php endif; ?>
                                <?php if($producto->catalogo): ?>
                                    <span class="all-product-chip"><i class="bi bi-journal-bookmark-fill me-1"></i><?php echo e($producto->catalogo->nombre); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="all-product-inline-stats">
                                <span><i class="bi bi-star-fill text-warning me-1"></i><?php echo e(number_format($ratingAll, 1)); ?></span>
                                <span><i class="bi bi-chat-left-text me-1"></i><?php echo e($reviewsAll); ?></span>
                                <span><i class="bi bi-box-seam me-1"></i><?php echo e($stockAll); ?></span>
                            </div>

                            <?php
                                $inWishlist = session('wishlist') && array_key_exists($producto->getKey(), session('wishlist'));
                            ?>
                            <?php if($inWishlist): ?>
                                <form action="<?php echo e(route('web.wishlist.remove', $producto->getKey())); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="all-product-wishlist-btn" title="Quitar de deseados">
                                        <i class="bi bi-heart-fill text-danger"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('web.wishlist.add', $producto->getKey())); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="all-product-wishlist-btn" title="Agregar a deseados">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <a href="<?php echo e(route('web.show', $producto->getKey())); ?>" class="all-product-cta" title="Ver producto">
                                <i class="bi bi-eye"></i> ver
                            </a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                <?php echo e($productos->withQueryString()->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-4 text-muted">No se encontraron productos para mostrar.</div>
        <?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/index.blade.php ENDPATH**/ ?>