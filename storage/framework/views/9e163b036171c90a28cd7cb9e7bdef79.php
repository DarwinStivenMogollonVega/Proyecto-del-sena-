<?php $__env->startSection('contenido'); ?>

<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Todas las Facturas</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Listado de facturas generadas</p>
            </div>
            <div class="d-flex gap-2">
                <form action="<?php echo e(route('admin.facturas.index')); ?>" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="<?php echo e($texto); ?>" placeholder="Buscar por cliente, email o id">
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
                                <th class="px-3">#</th>
                                <th>Cliente</th>
                                <th>Documento</th>
                                <th>Razón social</th>
                                <th>Correo FE</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th style="width: 140px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($reg->getKey()); ?></td>
                                    <td><?php echo e($reg->user->name ?? $reg->nombre); ?></td>
                                    <td><?php echo e($reg->email); ?></td>
                                    <td><?php echo e(strtoupper($reg->tipo_documento ?? '-')); ?> <?php echo e($reg->numero_documento ?? ''); ?></td>
                                    <td><?php echo e($reg->razon_social ?? '-'); ?></td>
                                    <td class="fw-bold">$<?php echo e(number_format($reg->total, 2)); ?></td>
                                    <td>
                                        <?php
                                            $badgeClass = match($reg->estado) {
                                                'pagada' => 'panel-badge-success',
                                                'pendiente' => 'panel-badge-warning',
                                                'anulada' => 'panel-badge-muted',
                                                default => 'panel-badge-muted',
                                            };
                                        ?>
                                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst($reg->estado)); ?></span>
                                    </td>
                                    <td><?php echo e($reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '-'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.facturas.edit', $reg->getKey())); ?>" class="btn btn-sm btn-outline-primary">Ver detalles</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox me-2"></i>Sin facturas registradas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando <?php echo e($registros->count()); ?> de <?php echo e($registros->total()); ?> facturas</div>
                <div><?php echo e($registros->appends(['texto' => $texto])->links()); ?></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('mnuFacturas')?.classList.add('active');
document.getElementById('mnuComercial')?.classList.add('menu-open');
document.getElementById('mnuComercialLink')?.classList.add('active');
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('plantilla.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/admin/facturas/index.blade.php ENDPATH**/ ?>