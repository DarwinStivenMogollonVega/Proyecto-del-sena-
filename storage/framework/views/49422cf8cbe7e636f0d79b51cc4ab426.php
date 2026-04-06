<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pedido-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/header-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/checkout_steps-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php if(app()->environment('testing')): ?>
    <?php $__env->startSection('manual_nav'); ?>
        <?php echo $__env->make('web.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('contenido'); ?>
    <section class="cart-wrap">
        <div class="container px-4 px-lg-5 py-4">
            <div class="text-center">Vista de `pedido` reducida para entorno de testing.</div>
        </div>
    </section>
    <?php $__env->stopSection(); ?>
<?php else: ?>
    <?php $__env->startSection('manual_nav'); ?>
        <?php echo $__env->make('web.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('contenido'); ?>
    <section class="cart-wrap">
        <?php echo $__env->make('web.partials.checkout_steps', ['currentStep' => 0], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="container px-4 px-lg-5">
        <?php
            $total = 0;
            $itemsCount = 0;
            foreach ($carrito as $item) {
                $unit = (float) ($item['precio'] ?? 0);
                $desc = (float) ($item['descuento'] ?? 0);
                $unitFinal = $unit * (1 - ($desc / 100));
                $total += $unitFinal * ($item['cantidad'] ?? 0);
                $itemsCount += $item['cantidad'] ?? 0;
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
            <!-- Columna productos -->
            <div class="col-md-8">
                <div class="cart-shell mb-4">
                    <div class="cart-table-head p-3 pb-2">
                        <div class="row">
                            <div class="col-3"><strong>Producto</strong></div>
                            <div class="col-2 text-center"><strong>Precio</strong></div>
                            <div class="col-3 text-center"><strong>Cantidad</strong></div>
                            <div class="col-2 text-end"><strong>Subtotal</strong></div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                    <div class="p-0" id="cartItems">
                        <?php $__empty_1 = true; $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="row align-items-center cart-row py-3" style="border-bottom: 1px solid #3a2417;">
                            <div class="col-3 d-flex align-items-center">
                                <img src="<?php echo e(asset('uploads/productos/' . $item['imagen'])); ?>" class="cart-thumb" alt="<?php echo e($item['nombre']); ?>">
                                <div class="ms-3">
                                    <h6 class="cart-product-name mb-0" style="color:#fff;"><?php echo e($item['nombre']); ?></h6>
                                </div>
                            </div>
                            <div class="col-2 text-center cart-price">
                                <?php
                                    $unit = (float) ($item['precio'] ?? 0);
                                    $desc = (float) ($item['descuento'] ?? 0);
                                    $unitFinal = $unit * (1 - ($desc / 100));
                                ?>
                                <?php if($desc > 0): ?>
                                    <div>
                                        <span class="cart-price-value" style="color:#ff9900; font-weight:600; font-size:1.1rem;">$<?php echo e(number_format($unitFinal, 2)); ?></span>
                                        <div class="text-decoration-line-through text-muted">$<?php echo e(number_format($unit, 2)); ?></div>
                                        <div><span class="badge bg-warning text-dark">- <?php echo e(number_format($desc, 2)); ?>% descuento</span></div>
                                    </div>
                                <?php else: ?>
                                    <span class="cart-price-value" style="color:#ff9900; font-weight:600; font-size:1.1rem;">$<?php echo e(number_format($unit, 2)); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="col-3 d-flex justify-content-center cart-qty">
                                <div class="qty-box d-flex align-items-center" style="background:#1a0e07; border-radius: 24px; border:1px solid #3a2417;">
                                    <a class="btn btn-outline-secondary px-2 py-1" href="<?php echo e(route('carrito.restar', ['producto_id' => $id])); ?>" data-action="decrease" style="border:none; color:#fff;">-</a>
                                    <span class="mx-2" style="min-width:32px; text-align:center; color:#fff; font-weight:600;"><?php echo e($item['cantidad']); ?></span>
                                    <a href="<?php echo e(route('carrito.sumar', ['producto_id' => $id])); ?>" class="btn btn-outline-secondary px-2 py-1" style="border:none; color:#fff;">+</a>
                                </div>
                            </div>
                            <div class="col-2 text-end">
                                <span class="cart-subtotal" style="color:#ff9900; font-weight:600; font-size:1.1rem;">$<?php echo e(number_format($unitFinal * $item['cantidad'], 2)); ?></span>
                            </div>
                            <div class="col-2 text-center">
                                <a class="btn btn-sm btn-outline-danger" href="<?php echo e(route('carrito.eliminar', $id)); ?>">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-5">
                            <span style="font-size: 3rem; color: #ff9900; line-height: 1;">
                                <i class="bi bi-cart-x"></i>
                            </span>
                            <div class="mt-2" style="color: #bfa77a; font-size: 1.15rem; font-weight: 500;">Tu carrito está vacío. Agrega productos para continuar.</div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="cart-actions p-3 text-end">
                        <a class="btn btn-outline-danger" href="<?php echo e(route('carrito.vaciar')); ?>">
                            <i class="bi bi-x-circle me-1"></i>Vaciar carrito
                        </a>
                    </div>
                </div>
            </div>
            <!-- Columna resumen pedido -->
            <div class="col-md-4">
                <div class="cart-shell mb-4">
                    <div class="p-4">
                        <h5 class="fw-bold mb-3" style="color:#bfa77a;">RESUMEN DEL PEDIDO</h5>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="color:#bfa77a;">Total a pagar</span>
                            <span style="color:#ff9900; font-size:1.5rem; font-weight:700;">$<?php echo e(number_format($total, 2)); ?></span>
                        </div>
                        <div class="mb-4" style="color:#bfa77a; font-size:0.95rem;">El total incluye los productos seleccionados actualmente en tu carrito.</div>
                        <a href="<?php echo e(route('pedido.datos')); ?>" class="btn btn-warning w-100 mb-2" style="background:#d87c23; border:none; color:#fff; font-weight:600; border-radius:12px;">
                            <i class="bi bi-credit-card me-1"></i>Realizar pedido
                        </a>
                        <a href="<?php echo e(route('web.index')); ?>" class="btn btn-outline-light w-100" style="background:#d87c23; border:none; color:#fff; font-weight:600; border-radius:12px;">
                            &larr; Continuar comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>



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
<?php endif; ?>
<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/pedido.blade.php ENDPATH**/ ?>