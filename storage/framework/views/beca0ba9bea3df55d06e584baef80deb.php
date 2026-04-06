<?php $__env->startSection('hide_nav'); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo', 'Historial de facturas - DiscZone'); ?>

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/recibos-factura-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="container px-4 px-lg-5 pb-5 invoice-page">
    <section class="invoice-hero" <?php if(!empty($heroImage)): ?> style="--invoice-hero-image: url('<?php echo e($heroImage); ?>')" <?php endif; ?>>
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1">Historial de facturas</h1>
                <p class="mb-0">Consulta todas tus facturas generadas automaticamente desde Mis pedidos y abre cada documento para descargar PDF.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="<?php echo e(route('perfil.pedidos')); ?>" class="btn btn-light">
                    <i class="bi bi-arrow-left me-1"></i> Volver a pedidos
                </a>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="invoice-card invoice-kpi">
                    <div class="label">Facturas totales</div>
                    <div class="value"><?php echo e($resumen['totalRecibos']); ?></div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="invoice-card invoice-kpi">
                    <div class="label">Monto facturado</div>
                    <div class="value">$<?php echo e(number_format($resumen['montoFacturado'], 2)); ?></div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="invoice-card p-3 p-lg-4">
            <form action="<?php echo e(route('perfil.recibos')); ?>" method="get" class="mb-3">
                <div class="input-group">
                    <input name="texto" type="text" class="form-control" value="<?php echo e($texto); ?>" placeholder="Buscar por factura, pedido o cliente">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <button type="submit" class="btn btn-dark">Buscar</button>
                    <?php if(!empty($texto)): ?>
                        <a href="<?php echo e(route('perfil.recibos')); ?>" class="btn btn-outline-secondary">Limpiar</a>
                    <?php endif; ?>
                </div>
            </form>

            <div class="invoice-table-wrap mt-3">
                <table class="table table-hover table-bordered invoice-table mb-0">
                    <thead>
                        <tr>
                            <th>Factura</th>
                            <th>Pedido</th>
                            <th>Emision</th>
                            <th>Estado pedido</th>
                            <th>Cliente</th>
                            <th class="text-end">Total</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($reg->numero_factura); ?></td>
                                <td>#<?php echo e($reg->pedido->getKey()); ?></td>
                                <td><?php echo e($reg->fecha_emision->format('d/m/Y H:i')); ?></td>
                                <td><?php echo e(ucfirst($reg->estado_pedido)); ?></td>
                                <td>
                                    <div class="fw-semibold"><?php echo e($reg->cliente_nombre); ?></div>
                                    <small class="text-muted"><?php echo e($reg->cliente_email); ?></small>
                                </td>
                                <td class="text-end">$<?php echo e(number_format($reg->total, 2)); ?></td>
                                <td>
                                    <a href="<?php echo e(route('perfil.facturas.show', $reg->getKey())); ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-file-earmark-text me-1"></i> Ver factura
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No hay facturas generadas para mostrar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <?php echo e($registros->appends(['texto' => $texto])->links()); ?>

            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/recibos_factura.blade.php ENDPATH**/ ?>