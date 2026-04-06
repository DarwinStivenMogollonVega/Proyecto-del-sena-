<?php $__env->startSection('hide_nav'); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo', 'Factura ' . $factura->numero_factura . ' - DiscZone'); ?>

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/recibo_factura_detalle.css')); ?>">
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="container px-4 px-lg-5 receipt-shell">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3 receipt-no-print">
        <a href="<?php echo e(route('perfil.recibos')); ?>" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i> Volver a facturas
        </a>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('perfil.facturas.pdf', $factura->getKey())); ?>" class="btn btn-dark">
                <i class="bi bi-file-earmark-pdf me-1"></i> Descargar PDF
            </a>
            <button type="button" class="btn btn-outline-dark" onclick="window.print()">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
        </div>
    </div>

    <div class="receipt-card">
        <div class="receipt-head">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <h1 class="h4 text-white mb-1">Factura electronica</h1>
                    <p class="mb-0 text-white-50"><?php echo e($factura->numero_factura); ?> · Emision <?php echo e($factura->fecha_emision->format('d/m/Y H:i')); ?></p>
                </div>
                <span class="badge text-bg-light">Estado pedido: <?php echo e(ucfirst($factura->estado_pedido)); ?></span>
            </div>
        </div>

        <div class="p-3 p-lg-4">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="receipt-block h-100">
                        <h2 class="h6 fw-bold mb-2">Cliente</h2>
                        <div><strong>Nombre:</strong> <?php echo e($factura->cliente_nombre); ?></div>
                        <div><strong>Email:</strong> <?php echo e($factura->cliente_email); ?></div>
                        <div><strong>Direccion:</strong> <?php echo e($factura->cliente_direccion ?: '-'); ?></div>
                        <div><strong>Identificacion:</strong> <?php echo e($factura->cliente_identificacion ?: '-'); ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="receipt-block h-100">
                        <h2 class="h6 fw-bold mb-2">Pedido asociado</h2>
                        <div><strong>ID Pedido:</strong> #<?php echo e($factura->pedido->getKey()); ?></div>
                        <div><strong>Fecha pedido:</strong> <?php echo e($factura->pedido->created_at->format('d/m/Y H:i')); ?></div>
                        <div><strong>Metodo de pago:</strong> <?php echo e(ucfirst($factura->pedido->metodo_pago ?: '-')); ?></div>
                        <div><strong>Estado:</strong> <?php echo e(ucfirst($factura->estado_pedido)); ?></div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped receipt-table mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio unitario</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $factura->pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($detalle->producto->nombre ?? 'Producto eliminado'); ?></td>
                                <td class="text-center"><?php echo e($detalle->cantidad); ?></td>
                                <td class="text-end">$<?php echo e(number_format($detalle->precio, 2)); ?></td>
                                <td class="text-end">$<?php echo e(number_format($detalle->cantidad * $detalle->precio, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Subtotal</th>
                            <th class="text-end">$<?php echo e(number_format($factura->subtotal, 2)); ?></th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Impuestos</th>
                            <th class="text-end">$<?php echo e(number_format($factura->impuestos, 2)); ?></th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end receipt-total">Total final</th>
                            <th class="text-end receipt-total">$<?php echo e(number_format($factura->total, 2)); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/recibo_factura_detalle.blade.php ENDPATH**/ ?>