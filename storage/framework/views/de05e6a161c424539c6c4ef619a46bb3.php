<?php $__env->startSection('contenido'); ?>
<div class="app-content">
    <div class="container-fluid">
        <div class="row g-3 mb-3">
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <small style="color:var(--adm-muted)">Total proveedores</small>
                        <div class="h4 fw-bold mb-0"><?php echo e($resumen['total']); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <small style="color:var(--adm-muted)">Activos</small>
                        <div class="h4 fw-bold mb-0"><?php echo e($resumen['activos']); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <small style="color:var(--adm-muted)">Con productos</small>
                        <div class="h4 fw-bold mb-0"><?php echo e($resumen['conProductos']); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Proveedores</h6>
                <div class="d-flex gap-2 align-items-center">
                    <form action="<?php echo e(route('proveedores.index')); ?>" method="get" class="d-flex">
                        <div class="input-group">
                            <input name="texto" type="text" class="form-control form-control-sm" value="<?php echo e($texto); ?>" placeholder="Buscar proveedor, contacto, email o telefono">
                            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('proveedor-create')): ?>
                        <a href="<?php echo e(route('proveedores.create')); ?>" class="btn btn-sm btn-primary">Nuevo</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body p-0">

                <?php if(session('mensaje')): ?>
                <div class="alert alert-info alert-dismissible fade show mt-2">
                    <?php echo e(session('mensaje')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="font-size:.88rem">
                        <thead>
                            <tr>
                                <th class="px-3">#</th>
                                <th>Proveedor</th>
                                <th>Contacto</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th class="text-center">Productos</th>
                                <th>Estado</th>
                                <th class="actions-col" style="width:150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-3 fw-semibold"><?php echo e($reg->getKey()); ?></td>
                                <td>
                                    <div class="fw-semibold"><?php echo e($reg->nombre); ?></div>
                                    <small class="text-muted"><?php echo e($reg->direccion ?: '-'); ?></small>
                                </td>
                                <td><?php echo e($reg->contacto ?: '-'); ?></td>
                                <td><?php echo e($reg->telefono ?: '-'); ?></td>
                                <td><?php echo e($reg->email ?: '-'); ?></td>
                                <td class="text-center"><span class="badge panel-badge-primary"><?php echo e($reg->productos_count); ?></span></td>
                                <td>
                                    <?php if($reg->activo): ?>
                                        <span class="badge panel-badge-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge panel-badge-muted">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions-col">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('proveedor-edit')): ?>
                                        <a href="<?php echo e(route('proveedores.edit', $reg->getKey())); ?>" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-pencil-fill"></i></a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('proveedor-delete')): ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar-proveedor-<?php echo e($reg->getKey()); ?>" data-modal-id="modal-eliminar-proveedor-<?php echo e($reg->getKey()); ?>" title="Eliminar"><i class="bi bi-trash-fill"></i></button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-3" style="color:var(--adm-muted)">No hay proveedores registrados.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                <?php $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('proveedor-delete')): ?>
                    <?php echo $__env->make('proveedor.delete', ['reg' => $reg], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('proveedor-activate')): ?>
                    <?php echo $__env->make('proveedor.activate', ['reg' => $reg], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando <?php echo e($registros->count()); ?> de <?php echo e($registros->total()); ?> proveedores</div>
                <div><?php echo e($registros->appends(['texto' => $texto])->links()); ?></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('mnuComercial')?.classList.add('menu-open');
    document.getElementById('mnuComercialLink')?.classList.add('active');
    document.getElementById('mnuProveedores')?.classList.add('active');
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/proveedor/index.blade.php ENDPATH**/ ?>