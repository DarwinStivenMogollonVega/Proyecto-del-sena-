<?php $__env->startSection('contenido'); ?>
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Pedidos</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Historial de pedidos realizados</p>
            </div>
            <div class="d-flex gap-2">
                <form action="<?php echo e(route('admin.pedidos')); ?>" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="<?php echo e($texto); ?>" placeholder="Buscar por usuario, id o factura">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <?php if(Session::has('mensaje')): ?>
        <div class="alert alert-info alert-dismissible fade show mt-2">
            <?php echo e(Session::get('mensaje')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
        <?php endif; ?>

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width:900px">
                        <thead>
                            <tr>
                                <th style="width: 150px">Acciones</th>
                                <th style="width: 20px">ID</th>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Factura</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modal-estado-<?php echo e($reg->getKey()); ?>" title="Cambiar estado"><i class="bi bi-arrow-repeat"></i></button>
                                        </div>
                                    </td>
                                    <td><?php echo e($reg->getKey()); ?></td>
                                    <td><?php echo e($reg->created_at->format('d/m/Y')); ?></td>
                                    <td><?php echo e($reg->user->name ?? '-'); ?></td>
                                    <td>
                                        <?php if($reg->requiere_factura_electronica): ?>
                                            <span class="badge panel-badge-warning">FE</span>
                                            <div class="small text-muted mt-1"><?php echo e(strtoupper($reg->tipo_documento ?? '-')); ?> <?php echo e($reg->numero_documento ?? ''); ?></div>
                                        <?php else: ?>
                                            <span class="text-muted small">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>$<?php echo e(number_format($reg->total, 2)); ?></td>
                                    <td>
                                        <?php
                                            $badgeClass = [
                                                'pendiente' => 'panel-badge-warning',
                                                'enviado' => 'panel-badge-success',
                                                'anulado' => 'panel-badge-muted',
                                                'cancelado' => 'panel-badge-muted',
                                            ][$reg->estado] ?? 'panel-badge-muted';
                                        ?>
                                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst($reg->estado)); ?></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-<?php echo e($reg->getKey()); ?>">Ver detalles</button>
                                    </td>
                                </tr>
                                <tr class="collapse" id="detalles-<?php echo e($reg->getKey()); ?>">
                                    <td colspan="8">
                                        <?php if($reg->requiere_factura_electronica): ?>
                                            <div class="alert alert-light border mb-3">
                                                <strong>Datos de factura:</strong>
                                                <?php echo e($reg->razon_social ?? '-'); ?> | <?php echo e(strtoupper($reg->tipo_documento ?? '-')); ?> <?php echo e($reg->numero_documento ?? ''); ?> | <?php echo e($reg->correo_factura ?? '-'); ?>

                                            </div>
                                        <?php endif; ?>
                                        <table class="table table-sm table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Imagen</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $reg->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($detalle->producto->nombre); ?></td>
                                                    <td>
                                                        <img src="<?php echo e(asset('uploads/productos/' . $detalle->producto->imagen )); ?>" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="<?php echo e($detalle->producto->nombre); ?>">
                                                    </td>
                                                    <td><?php echo e($detalle->cantidad); ?></td>
                                                    <td><?php echo e(number_format($detalle->precio, 2)); ?></td>
                                                    <td><?php echo e(number_format($detalle->cantidad * $detalle->precio, 2)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <?php echo $__env->make('pedido.state', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox me-2"></i>No hay registros que coincidan con la búsqueda</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando <?php echo e($pedidos->count()); ?> de <?php echo e($pedidos->total()); ?> pedidos</div>
                <div><?php echo e($pedidos->appends(['texto' => $texto])->links()); ?></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('mnuPedidos').classList.add('active');
document.getElementById('mnuComercial')?.classList.add('menu-open');
document.getElementById('mnuComercialLink')?.classList.add('active');
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('plantilla.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/pedido/index.blade.php ENDPATH**/ ?>