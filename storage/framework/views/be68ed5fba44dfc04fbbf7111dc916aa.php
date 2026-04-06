<?php $__env->startSection('hide_nav'); ?><?php $__env->stopSection(); ?>
<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/item-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('manual_nav'); ?>
    <?php echo $__env->make('web.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<section class="product-page">
    <div class="container px-4 px-lg-5">
        <?php if(session('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <?php echo e(session('mensaje')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <div class="product-main-card p-3 p-lg-4 mb-4">
            <div class="row gx-4 gx-lg-5 align-items-start">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="product-image-wrap">
                        <img src="<?php echo e(asset('uploads/productos/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="small text-muted mb-1">SKU: <?php echo e($producto->codigo); ?></div>
                    <h1 class="h2 fw-bold mb-2"><?php echo e($producto->nombre); ?></h1>

                    <p class="mb-2">
                        <?php if($producto->categoria): ?>
                            <span class="badge bg-primary me-1"><i class="bi bi-tags-fill me-1"></i><?php echo e($producto->categoria->nombre); ?></span>
                        <?php endif; ?>
                        <?php if($producto->formato): ?>
                            <span class="badge bg-danger"><i class="bi bi-bookmark-fill me-1"></i><?php echo e($producto->formato->nombre); ?></span>
                        <?php endif; ?>
                        <?php if($producto->artista): ?>
                            <span class="badge bg-success ms-2"><i class="bi bi-music-note-beamed me-1"></i><?php echo e($producto->artista->nombre); ?></span>
                        <?php endif; ?>
                        <?php if($producto->proveedor): ?>
                            <span class="text-muted d-block mt-1">Proveedor: <?php echo e($producto->proveedor->nombre); ?></span>
                        <?php endif; ?>
                        <?php if($producto->anio_lanzamiento): ?>
                            <span class="text-muted d-block">Año: <?php echo e($producto->anio_lanzamiento); ?></span>
                        <?php endif; ?>
                    </p>

                    <?php if(!empty($producto->descuento) && $producto->descuento > 0): ?>
                        <div class="small text-muted">Precio anterior</div>
                        <div class="text-muted"><s>$<?php echo e(number_format($producto->precio, 2)); ?></s></div>
                        <div class="price-big mb-3">$<?php echo e(number_format($producto->precio * (1 - ($producto->descuento/100)), 2)); ?></div>
                        <div class="mb-2"><span class="badge bg-warning text-dark">- <?php echo e(number_format($producto->descuento, 2)); ?>% descuento</span></div>
                    <?php else: ?>
                        <div class="price-big mb-3">$<?php echo e(number_format($producto->precio, 2)); ?></div>
                    <?php endif; ?>

                    <div class="rating-summary mb-3">
                        <div class="star-view" aria-label="Promedio de calificacion">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="bi <?php echo e($i <= round($promedio) ? 'bi-star-fill' : 'bi-star'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <strong><?php echo e(number_format($promedio, 1)); ?></strong>
                        <span class="text-muted">(<?php echo e($totalResenas); ?> calificaciones)</span>
                    </div>

                    <p class="lead"><?php echo e($producto->descripcion); ?></p>

                    <form action="<?php echo e(route('carrito.agregar')); ?>" method="POST" class="d-flex flex-wrap gap-2 align-items-center">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="producto_id" value="<?php echo e($producto->getKey()); ?>">
                        <input class="form-control text-center" id="inputQuantity" type="number" name="cantidad" min="1" value="1" style="max-width: 5rem" />
                        <button class="btn btn-outline-dark add-to-cart-btn" type="submit"><i class="bi bi-cart-fill me-1"></i> Agregar al carrito</button>
                        <?php
                            if (auth()->check() && \Illuminate\Support\Facades\Schema::hasTable('lista_deseos')) {
                                $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('producto_id', $producto->getKey())->exists();
                            } else {
                                $wishlist = session('wishlist', []);
                                $inWishlist = in_array($producto->getKey(), $wishlist);
                            }
                        ?>
                        <button type="button" class="all-product-wishlist-btn js-wishlist-toggle" data-product-id="<?php echo e($producto->getKey()); ?>" title="Agregar a deseados">
                            <i class="bi <?php echo e($inWishlist ? 'bi-heart-fill text-danger' : 'bi-heart'); ?>"></i>
                        </button>
                        <a class="btn btn-outline-secondary" href="javascript:history.back()">Regresar</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="rating-card p-3 p-lg-4 h-100">
                    <h3 class="h5 fw-bold mb-3">Califica este producto</h3>

                    <?php if(auth()->guard()->check()): ?>
                        <form action="<?php echo e(route('web.resena.guardar', $producto->getKey())); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <label class="form-label fw-semibold">Tu puntuacion</label>
                            <div class="rating-input mb-3">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="star-<?php echo e($i); ?>" name="puntuacion" value="<?php echo e($i); ?>" <?php echo e((int) old('puntuacion', optional($miResena)->puntuacion) === $i ? 'checked' : ''); ?>>
                                    <label for="star-<?php echo e($i); ?>" title="<?php echo e($i); ?> estrellas"><i class="bi bi-star-fill"></i></label>
                                <?php endfor; ?>
                            </div>
                            <?php $__errorArgs = ['puntuacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mb-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <div class="mb-3">
                                <label for="comentario" class="form-label fw-semibold">Comentario (opcional)</label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="4" maxlength="600" placeholder="Comparte tu opinion sobre el producto"><?php echo e(old('comentario', optional($miResena)->comentario)); ?></textarea>
                                <?php $__errorArgs = ['comentario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <button type="submit" class="btn btn-dark"><?php echo e($miResena ? 'Actualizar calificacion' : 'Guardar calificacion'); ?></button>
                        </form>
                    <?php else: ?>
                        <p class="text-muted mb-3">Debes iniciar sesion para dejar una calificacion.</p>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-dark">Iniciar sesion</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="review-list-card p-3 p-lg-4">
                    <h3 class="h5 fw-bold mb-3">Opiniones de clientes</h3>

                    <?php $__empty_1 = true; $__currentLoopData = $producto->resenas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resena): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article class="review-item">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-1">
                                <strong><?php echo e($resena->user->name ?? 'Cliente'); ?></strong>
                                <small class="text-muted"><?php echo e($resena->created_at?->format('d/m/Y')); ?></small>
                            </div>
                            <div class="star-view mb-2">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi <?php echo e($i <= (int) $resena->puntuacion ? 'bi-star-fill' : 'bi-star'); ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <?php if(!empty($resena->comentario)): ?>
                                <p class="mb-0"><?php echo e($resena->comentario); ?></p>
                            <?php else: ?>
                                <p class="mb-0 text-muted">Sin comentario adicional.</p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted mb-0">Aun no hay calificaciones para este producto. Se la primera persona en opinar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/item.blade.php ENDPATH**/ ?>