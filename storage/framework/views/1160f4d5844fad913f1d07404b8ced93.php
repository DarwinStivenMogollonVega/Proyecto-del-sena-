<div class="product-carousel-item">
    <?php
        $stockLocal  = (int) ($producto->cantidad ?? 0);
        $ratingLocal = round((float) ($producto->resenas_avg_puntuacion ?? 0), 1);
        $rCountLocal  = (int) ($producto->resenas_count ?? 0);
    ?>
    <article class="all-product-card">
        <div class="all-product-cover">
            <?php if($producto->imagen): ?>
                <img src="<?php echo e(asset('uploads/productos/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>" width="400" height="300" loading="lazy">
            <?php else: ?>
                <img src="<?php echo e(asset('img/no-image.svg')); ?>" alt="Sin imagen" width="400" height="300" loading="lazy">
            <?php endif; ?>
            <?php if($stockLocal >= 50): ?>
                <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
            <?php elseif($stockLocal > 0): ?>
                <span class="all-product-stock badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Pocas unidades</span>
            <?php else: ?>
                <span class="all-product-stock badge bg-danger"><i class="bi bi-x-circle me-1"></i>Agotado</span>
            <?php endif; ?>
        </div>
        <div class="all-product-body">
            <p class="all-product-name" title="<?php echo e($producto->nombre); ?>"><?php echo e($producto->nombre); ?></p>
            <p class="all-product-artist"><?php echo e($producto->artista?->nombre ?? 'Artista no especificado'); ?></p>
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
                <?php if($producto->formato): ?>
                    <span class="all-product-chip"><i class="bi bi-journal-bookmark-fill me-1"></i><?php echo e($producto->formato->nombre); ?></span>
                <?php endif; ?>
            </div>
            <div class="all-product-inline-stats">
                <span><i class="bi bi-star-fill text-warning me-1"></i><?php echo e(number_format($ratingLocal, 1)); ?></span>
                <span><i class="bi bi-chat-left-text me-1"></i><?php echo e($rCountLocal); ?></span>
                <span><i class="bi bi-box-seam me-1"></i><?php echo e($stockLocal); ?></span>
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
</div>
<?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/partials/product-card.blade.php ENDPATH**/ ?>