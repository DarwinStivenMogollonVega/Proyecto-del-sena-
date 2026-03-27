<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pedido-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/header-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('contenido'); ?>
<section class="cart-wrap">
    <div class="container px-4 px-lg-5">
        <?php
            $total = 0;
            $itemsCount = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
                $itemsCount += $item['cantidad'];
            }
        ?>

        <div class="cart-hero mb-4">
            <h2 class="fs-3 fw-bold">Tu carrito de compra</h2>
            <p class="mb-2">
                <?php echo e($itemsCount); ?> producto(s) seleccionado(s) para completar tu pedido.
            </p>
        </div>
        <!-- Separador visual -->
        <hr class="d-none d-md-block mb-4">

        <div class="row">
            <?php $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="cart-shell mb-4">
                        <div class="cart-table-head">
                            <div class="row">
                                <div class="col-6 col-md-5"><strong>Producto</strong></div>
                                <div class="col-2 col-md-2 text-center"><strong>Precio</strong></div>
                                <div class="col-2 col-md-2 text-center"><strong>Cantidad</strong></div>
                                <div class="col-2 col-md-3 text-end"><strong>Subtotal</strong></div>
                            </div>
                        </div>
                        <div class="p-0" id="cartItems">
                            <div class="row align-items-center cart-row">
                                <div class="col-md-5 d-flex align-items-center">
                                    <img src="<?php echo e(asset('uploads/productos/' . $item['imagen'])); ?>"
                                    class="cart-thumb" alt="<?php echo e($item['nombre']); ?>">
                                    <div class="ms-3">
                                        <h6 class="cart-product-name"><?php echo e($item['nombre']); ?></h6>
                                        <small class="cart-product-code"><?php echo e($item['codigo']); ?></small>
                                    </div>
                                </div>

                                <div class="col-md-2 text-center cart-price">
                                    <div class="cart-label-mobile">Precio</div>
                                    <span class="cart-price-value">$<?php echo e(number_format($item['precio'], 2)); ?></span>
                                </div>

                                <div class="col-md-2 d-flex justify-content-center cart-qty">
                                    <div class="cart-label-mobile">Cantidad</div>
                                    <div class="qty-box">
                                        <a class="btn btn-outline-secondary" href="<?php echo e(route('carrito.restar', ['producto_id' => $id])); ?>"
                                            data-action="decrease">-</a>
                                        <input type="text" class="form-control text-center" value="<?php echo e($item['cantidad']); ?>"
                                            readonly>
                                        <a href="<?php echo e(route('carrito.sumar', ['producto_id' => $id])); ?>" class="btn btn-outline-secondary">
                                            +
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-3 d-flex align-items-center justify-content-end cart-line-total">
                                    <div class="cart-label-mobile">Subtotal</div>
                                    <div class="text-end me-3">
                                        <span class="cart-subtotal">$<?php echo e(number_format($item['precio'] * $item['cantidad'], 2)); ?></span>
                                    </div>
                                    <a class="btn btn-sm btn-outline-danger" href="<?php echo e(route('carrito.eliminar', $id)); ?>">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_0): ?>
        <div class="cart-empty">
            <i class="bi bi-cart-x"></i>
            <p class="mb-0">Tu carrito esta vacio. Agrega productos para continuar.</p>
        </div>
        <?php endif; ?>

        <?php if(session('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <?php echo e(session('mensaje')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <div class="cart-actions">
            <div class="text-end">
                <a class="btn btn-outline-danger" href="<?php echo e(route('carrito.vaciar')); ?>">
                    <i class="bi bi-x-circle me-1"></i>Vaciar carrito
                </a>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/laravelapp/resources/views/web/pedido.blade.php ENDPATH**/ ?>