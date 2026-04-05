<?php $__env->startSection('contenido'); ?>
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Gestión de Clientes</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Listado y administración de clientes del sistema</p>
            </div>
            <div>
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-sm btn-outline-secondary">Volver al panel</a>
            </div>
        </div>

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <form action="<?php echo e(route('admin.clientes.index')); ?>" method="get" class="w-100 me-3">
                        <div class="input-group">
                            <input name="texto" type="text" class="form-control form-control-sm" value="<?php echo e($texto); ?>" placeholder="Buscar cliente por nombre o email">
                            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    <div class="ms-3">
                        <a href="<?php echo e(route('usuarios.create')); ?>" class="btn btn-sm btn-primary">Nuevo</a>
                    </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="font-size:.88rem">
                        <thead>
                            <tr>
                                <th class="px-3">#</th>
                                <th>Nombre</th>
                                <th class="text-center">Compras</th>
                                <th>Estado</th>
                                <th class="actions-col" style="width:150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-3 fw-semibold"><?php echo e($reg->getKey()); ?></td>
                                <td>
                                    <div class="fw-semibold"><?php echo e($reg->name); ?></div>
                                    <small class="text-muted"><?php echo e($reg->email); ?></small>
                                </td>
                                <td class="text-center"><span class="badge panel-badge-primary"><?php echo e($reg->pedidos_count); ?></span></td>
                                <td>
                                    <span class="badge <?php echo e($reg->activo ? 'panel-badge-success' : 'panel-badge-muted'); ?>"><?php echo e($reg->activo ? 'Activo' : 'Inactivo'); ?></span>
                                </td>
                                <td class="actions-col">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="<?php echo e(route('admin.clientes.show', $reg->getKey())); ?>" class="btn btn-sm btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                                        <a href="<?php echo e(route('usuarios.edit', $reg->getKey())); ?>" class="btn btn-sm btn-outline-info" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-delete')): ?>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar-cliente-<?php echo e($reg->getKey()); ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3" style="color:var(--adm-muted)">No hay clientes registrados.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <?php $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-delete')): ?>
                    <?php $__env->startPush('modals'); ?>
                        <?php echo $__env->make('cliente_gestion.delete', ['reg' => $reg], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php $__env->stopPush(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    Mostrando <?php echo e($registros->count()); ?> de <?php echo e($registros->total()); ?> clientes
                </div>
                <div>
                    <?php echo e($registros->appends(['texto' => $texto])->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('mnuClientes')?.classList.add('active');
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/cliente_gestion/index.blade.php ENDPATH**/ ?>