<?php $__env->startSection('titulo', 'Lista de Deseados - DiscZone'); ?>

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/wishlist-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/index-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container px-4 px-lg-5 mt-5 wishlist-container">
    <section class="wishlist-hero p-4 p-lg-5 mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold mb-2 wishlist-title">Tus discos deseados</h1>
                <p class="mb-0 hero-subtitle">Guarda tus favoritos para no perderlos de vista y comprarlos después.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                <a href="<?php echo e(route('web.index')); ?>" class="btn btn-light px-4 wishlist-back-btn">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la tienda
                </a>
            </div>
        </div>
    </section>

    <div class="wishlist-section rounded shadow-sm p-4">
        <h2 class="text-center mb-4 wishlist-section-title">Lista de Deseados</h2>
        <?php if(auth()->check() && \Illuminate\Support\Facades\Schema::hasTable('wishlists')): ?>
            <?php
                $items = \App\Models\Wishlist::where('user_id', auth()->id())->with('producto')->get();
            ?>
            <?php if($items->isNotEmpty()): ?>
                <div class="row wishlist-list">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $p = $entry->producto; ?>
                        <?php if(!$p): ?> <?php continue; ?> <?php endif; ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 wishlist-item-col">
                            <article class="all-product-card">
                                <div class="all-product-cover">
                                    <?php if(!empty($p->imagen)): ?>
                                        <img src="<?php echo e(asset('uploads/productos/' . $p->imagen)); ?>" alt="<?php echo e($p->nombre); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('img/no-image.svg')); ?>" alt="Sin imagen" width="400" height="300" loading="lazy">
                                    <?php endif; ?>
                                    <?php $stock = (int) ($p->cantidad ?? 0); ?>
                                    <?php if($stock >= 50): ?>
                                        <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                    <?php elseif($stock > 0): ?>
                                        <span class="all-product-stock badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                                    <?php else: ?>
                                        <span class="all-product-stock badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                    <?php endif; ?>
                                </div>
                                <div class="all-product-body">
                                    <?php
                                        $rating = round((float) ($p->resenas_avg_puntuacion ?? 0), 1);
                                        $rCount = (int) ($p->resenas_count ?? 0);
                                        $stock = (int) ($p->cantidad ?? 0);
                                    ?>
                                    <p class="all-product-name" title="<?php echo e($p->nombre); ?>"><?php echo e($p->nombre); ?></p>
                                    <p class="all-product-artist"><?php echo e($p->artista?->nombre ?? ''); ?></p>

                                    <?php if($stock >= 50): ?>
                                        <span class="all-product-discount"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                    <?php elseif($stock > 0): ?>
                                        <span class="all-product-discount"><i class="bi bi-tag-fill me-1"></i>$<?php echo e(number_format(($p->precio - ($p->descuento ?? 0)), 2)); ?></span>
                                    <?php else: ?>
                                        <span class="all-product-discount"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                    <?php endif; ?>

                                    <div class="all-product-meta">
                                        <?php if($p->categoria): ?>
                                            <span class="all-product-chip"><i class="bi bi-tags-fill me-1"></i><?php echo e($p->categoria->nombre); ?></span>
                                        <?php endif; ?>
                                        <?php if($p->formato): ?>
                                            <span class="all-product-chip"><i class="bi bi-journal-bookmark-fill me-1"></i><?php echo e($p->formato->nombre); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="all-product-inline-stats">
                                        <span><i class="bi bi-star-fill text-warning me-1"></i><?php echo e(number_format($rating, 1)); ?></span>
                                        <span><i class="bi bi-chat-left-text me-1"></i><?php echo e($rCount); ?></span>
                                        <span><i class="bi bi-box-seam me-1"></i><?php echo e($stock); ?></span>
                                    </div>

                                    <button type="button" class="all-product-wishlist-btn js-wishlist-toggle" data-product-id="<?php echo e($p->getKey()); ?>" title="Quitar de deseados">
                                        <i class="bi bi-heart-fill text-danger"></i>
                                    </button>
                                    <a href="<?php echo e(route('web.show', $p->getKey())); ?>" class="all-product-cta" title="Ver producto">
                                        <i class="bi bi-eye"></i> ver
                                    </a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted wishlist-empty">No hay productos en la lista de deseados.</p>
            <?php endif; ?>
        <?php else: ?>
            <?php if(session('wishlist') && count(session('wishlist')) > 0): ?>
                <div class="row wishlist-list">
                    <?php $__currentLoopData = session('wishlist'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 wishlist-item-col">
                            <article class="all-product-card">
                                <div class="all-product-cover">
                                    <?php if(!empty($item['imagen'])): ?>
                                        <img src="<?php echo e(asset('uploads/productos/' . $item['imagen'])); ?>" alt="<?php echo e($item['nombre']); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('img/no-image.svg')); ?>" alt="Sin imagen" width="400" height="300" loading="lazy">
                                    <?php endif; ?>
                                    <?php $stock = (int) ($item['cantidad'] ?? 0); ?>
                                    <?php if($stock >= 50): ?>
                                        <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                    <?php elseif($stock > 0): ?>
                                        <span class="all-product-stock badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
                                    <?php else: ?>
                                        <span class="all-product-stock badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                    <?php endif; ?>
                                </div>
                                <div class="all-product-body">
                                    <?php
                                        $stock = (int) ($item['cantidad'] ?? 0);
                                        $rating = isset($item['resenas_avg_puntuacion']) ? round((float) $item['resenas_avg_puntuacion'], 1) : 0.0;
                                        $rCount = (int) ($item['resenas_count'] ?? 0);
                                    ?>
                                    <p class="all-product-name" title="<?php echo e($item['nombre']); ?>"><?php echo e($item['nombre']); ?></p>
                                    <p class="all-product-artist"><?php echo e($item['artista'] ?? ''); ?></p>

                                    <?php if($stock >= 50): ?>
                                        <span class="all-product-discount"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                    <?php elseif($stock > 0): ?>
                                        <span class="all-product-discount"><i class="bi bi-tag-fill me-1"></i>$<?php echo e(number_format(($item['precio'] ?? 0) - ($item['descuento'] ?? 0), 2)); ?></span>
                                    <?php else: ?>
                                        <span class="all-product-discount"><i class="bi bi-x-circle me-1"></i>Agotado</span>
                                    <?php endif; ?>

                                    <div class="all-product-meta"></div>

                                    <div class="all-product-inline-stats">
                                        <span><i class="bi bi-star-fill text-warning me-1"></i><?php echo e(number_format($rating, 1)); ?></span>
                                        <span><i class="bi bi-chat-left-text me-1"></i><?php echo e($rCount); ?></span>
                                        <span><i class="bi bi-box-seam me-1"></i><?php echo e($stock); ?></span>
                                    </div>

                                    <button type="button" class="all-product-wishlist-btn js-wishlist-toggle" data-product-id="<?php echo e($item['id']); ?>" title="Quitar de deseados">
                                        <i class="bi bi-heart-fill text-danger"></i>
                                    </button>
                                    <a href="<?php echo e(route('web.show', $item['id'])); ?>" class="all-product-cta" title="Ver producto">
                                        <i class="bi bi-eye"></i> ver
                                    </a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted wishlist-empty">No hay productos en la lista de deseados.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/wishlist.blade.php ENDPATH**/ ?>