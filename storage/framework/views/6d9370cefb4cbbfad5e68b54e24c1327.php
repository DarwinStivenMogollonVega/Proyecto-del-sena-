<?php $__env->startSection('titulo', 'Mis pedidos - DiscZone'); ?>

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/mis-pedidos-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container px-4 px-lg-5 pb-5 orders-page">

    
    <section class="orders-hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1">Mis pedidos</h1>
                <p class="mb-0">
                    Consulta tu historial, revisa el estado y explora el detalle completo de cada compra.
                </p>
            </div>

            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="<?php echo e(route('web.index')); ?>" class="btn btn-light quick-action">
                    <i class="bi bi-shop me-1"></i> Ir a la tienda
                </a>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3">
            <a href="<?php echo e(route('carrito.mostrar')); ?>" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-cart-fill me-1"></i> Ver carrito
            </a>
            <a href="<?php echo e(route('cliente.dashboard')); ?>" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-bar-chart-line me-1"></i> Mi dashboard
            </a>
            <a href="<?php echo e(route('perfil.recibos')); ?>" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-file-earmark-text me-1"></i> Historial facturas
            </a>
            <a href="<?php echo e(route('perfil.pedidos')); ?>" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-receipt me-1"></i> Ver pedidos
            </a>
        </div>
    </section>

    
    <section class="mt-4">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="orders-card orders-kpi">
                    <div class="label">Pedidos totales</div>
                    <div class="value"><?php echo e($resumen['totalPedidos']); ?></div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="orders-card orders-kpi">
                    <div class="label">Gasto total</div>
                    <div class="value">$<?php echo e(number_format($resumen['gastoTotal'], 2)); ?></div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <div class="orders-card orders-kpi">
                    <div class="label">Pendientes</div>
                    <div class="value"><?php echo e($resumen['pendientes']); ?></div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <div class="orders-card orders-kpi">
                    <div class="label">Enviados</div>
                    <div class="value"><?php echo e($resumen['enviados']); ?></div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <div class="orders-card orders-kpi">
                    <div class="label">Cancelados</div>
                    <div class="value"><?php echo e($resumen['cancelados']); ?></div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <div class="orders-card orders-kpi">
                    <div class="label">Facturas generadas</div>
                    <div class="value"><?php echo e($resumen['conFactura']); ?></div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="mt-4">
        <div class="cart-shell mb-4 p-0">

            <div class="cart-table-head p-4 pb-2">
                <h3 class="fs-4 fw-bold mb-0">Tus pedidos</h3>
                <p class="mb-0">Listado de tus compras realizadas en la tienda.</p>
            </div>

            <div class="p-4 pt-0">
                <div class="orders-table-wrap mt-3">

                    <table class="table table-hover table-bordered orders-table mb-0">

                        <thead>
                            <tr>
                                <th style="width: 120px">Opciones</th>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Metodo pago</th>
                                <th>Comprobante</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Factura</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if($registros->isEmpty()): ?>

                                
                                <tr class="orders-empty-row">
                                    <td colspan="9" class="orders-empty-cell">
                                        <div class="orders-empty-box">
                                            <span class="orders-empty-icon">
                                                <i class="bi bi-cart-x"></i>
                                            </span>
                                            <span class="orders-empty-text">
                                                Tu carrito está vacío. Agrega productos para continuar.
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                            <?php else: ?>

                                <?php $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>
                                        <td>
                                            <?php if(auth()->user()->can('pedido-cancel')): ?>
                                                <button class="btn btn-outline-warning btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-estado-<?php echo e($reg->getKey()); ?>">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted small">Sin acciones</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>#<?php echo e($reg->getKey()); ?></td>
                                        <td><?php echo e($reg->created_at->format('d/m/Y')); ?></td>
                                        <td><?php echo e(ucfirst($reg->metodo_pago ?? 'N/A')); ?></td>

                                        <td>
                                            <?php if($reg->comprobante_pago): ?>
                                                <a href="<?php echo e(asset('storage/' . $reg->comprobante_pago)); ?>"
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-info">
                                                    Ver captura
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">Sin archivo</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>$<?php echo e(number_format($reg->total, 2)); ?></td>

                                        <td>
                                            <?php
                                                $colores = [
                                                    'pendiente' => 'bg-warning text-dark',
                                                    'enviado' => 'bg-success',
                                                    'anulado' => 'bg-danger',
                                                    'cancelado' => 'bg-secondary',
                                                ];
                                            ?>

                                            <span class="badge status-pill <?php echo e($colores[$reg->estado] ?? 'bg-dark'); ?>">
                                                <?php echo e(ucfirst($reg->estado)); ?>

                                            </span>
                                        </td>

                                        <td>
                                            <?php if($reg->factura): ?>
                                                <a href="<?php echo e(route('perfil.facturas.show', $reg->factura->getKey())); ?>"
                                                   class="btn btn-sm btn-outline-primary">
                                                    Ver factura
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('perfil.recibos.show', $reg->getKey())); ?>"
                                                   class="btn btn-sm btn-primary">
                                                    Generar factura
                                                </a>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#detallesCollapse-<?php echo e($reg->getKey()); ?>">
                                                Ver detalles
                                            </button>
                                        </td>
                                    </tr>

                                    
                                    <tr>
                                        <td colspan="9">
                                            <div class="collapse" id="detallesCollapse-<?php echo e($reg->getKey()); ?>">

                                                <div class="detail-box mb-3">
                                                    <strong>Datos:</strong>
                                                    <?php echo e($reg->nombre); ?> | <?php echo e($reg->email); ?> | <?php echo e($reg->telefono); ?>


                                                    <br>
                                                    <strong>Dirección:</strong>
                                                    <?php echo e($reg->direccion); ?>

                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-sm table-striped mb-0 orders-detail-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Producto</th>
                                                                <th>Imagen</th>
                                                                <th>Cantidad</th>
                                                                <th>Precio</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php $__currentLoopData = $reg->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($detalle->producto->nombre); ?></td>
                                                                    <td>
                                                                        <img src="<?php echo e(asset('uploads/productos/' . $detalle->producto->imagen)); ?>"
                                                                             class="orders-img">
                                                                    </td>
                                                                    <td><?php echo e($detalle->cantidad); ?></td>
                                                                    <td>$<?php echo e(number_format($detalle->precio, 2)); ?></td>
                                                                    <td>$<?php echo e(number_format($detalle->cantidad * $detalle->precio, 2)); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>

                                    <?php if(auth()->user()->can('pedido-cancel')): ?>
                                        <?php echo $__env->make('pedido.state', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

                
                <div class="mt-3">
                    <?php echo e($registros->appends(['texto' => $texto])->links()); ?>

                </div>

            </div>
        </div>
    </section>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/mis_pedidos.blade.php ENDPATH**/ ?>