
<?php $__env->startSection('titulo', $categoria->nombre . ' - DiscZone'); ?>

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/dz-responsive.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/formato-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/header-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('header'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="container px-4 px-lg-5">
    <section id="inicio" class="store-hero p-4 p-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="store-hero-brand">
                    <!-- Logo removido por solicitud -->
                </div>
                <h1 class="display-6 fw-bold mb-2">Productos en la categoría: <?php echo e($categoria->nombre); ?></h1>
                <p class="mb-0 hero-subtitle">Explora los productos de esta categoría.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                <a href="#productos" class="btn btn-light px-4">
                    <i class="bi bi-vinyl-fill me-1"></i> Explorar ahora
                </a>
            </div>
        </div>
    </section>
    <!-- Separador visual -->
    <hr class="d-none d-md-block mb-4">

    <div class="row g-3 mt-2 mb-4">
        <div class="col-6 col-md-3"><div class="metric-pill"><strong><?php echo e($productos->count()); ?></strong><span>Productos</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong><?php echo e($productos->where('cantidad', '>', 0)->count()); ?></strong><span>Disponibles</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong><?php echo e($productos->unique('categoria_id')->count()); ?></strong><span>Categorías</span></div></div>
        <div class="col-6 col-md-3"><div class="metric-pill"><strong>1</strong><span>Categoría</span></div></div>
    </div>

<form method="GET" action="<?php echo e(route('web.categoria.show', $categoria->getKey())); ?>" class="search-panel p-3 p-md-4 mt-4">
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

<section class="all-products-section mt-5">
    <div class="all-products-head d-flex align-items-center" style="gap:0.7rem;">
        <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-grid-3x3-gap-fill me-2"></i>Productos de la categoría
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
                            <span class="all-product-discount"><i class="bi bi-tag-fill me-1"></i>$<?php echo e(number_format(($producto->precio - ($producto->descuento ?? 0)), 2)); ?></span>
                        <?php else: ?>
                            <span class="all-product-discount"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                        <?php endif; ?>
                        <div class="all-product-meta">
                            <?php if($producto->categoria): ?>
                                <span class="all-product-chip"><i class="bi bi-tags-fill me-1"></i><?php echo e($producto->categoria->nombre); ?></span>
                            <?php endif; ?>
                            <?php if($producto->formato): ?>
                                <span class="all-product-chip"><i class="bi bi-journal-bookmark-fill me-1"></i><?php echo e($producto->formato->nombre); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="all-product-inline-stats">
                            <span><i class="bi bi-star-fill text-warning me-1"></i><?php echo e(number_format($ratingAll, 1)); ?></span>
                            <span><i class="bi bi-chat-left-text me-1"></i><?php echo e($reviewsAll); ?></span>
                            <span><i class="bi bi-box-seam me-1"></i><?php echo e($stockAll); ?></span>
                        </div>
                        <?php
                            if (auth()->check() && \Illuminate\Support\Facades\Schema::hasTable('wishlists')) {
                                $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('producto_id', $producto->getKey())->exists();
                            } else {
                                $inWishlist = session('wishlist') && array_key_exists($producto->getKey(), session('wishlist'));
                            }
                        ?>
                        <button type="button" class="all-product-wishlist-btn js-wishlist-toggle" data-product-id="<?php echo e($producto->getKey()); ?>" title="Agregar a deseados">
                            <i class="bi <?php echo e($inWishlist ? 'bi-heart-fill text-danger' : 'bi-heart'); ?>"></i>
                        </button>
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

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/categoria.blade.php ENDPATH**/ ?>