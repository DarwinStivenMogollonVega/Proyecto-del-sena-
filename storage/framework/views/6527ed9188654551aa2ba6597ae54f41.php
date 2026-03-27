<?php $__env->startSection('contenido'); ?>
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Roles</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Administración de roles y permisos</p>
            </div>
            <div class="d-flex gap-2">
                <form action="<?php echo e(route('roles.index')); ?>" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="<?php echo e($texto); ?>" placeholder="Buscar rol por nombre">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rol-create')): ?>
                    <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-sm btn-primary">Nuevo</a>
                <?php endif; ?>
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
                                <th style="width: 20px">ID</th>
                                <th>Nombre</th>
                                <th>Permisos</th>
                                <th class="actions-col" style="width:150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($reg->getKey()); ?></td>
                                    <td><?php echo e($reg->name); ?></td>
                                    <td>
                                        <?php if($reg->permissions->isNotEmpty()): ?>
                                            <?php echo $reg->permissions->pluck('name')->map(function($name) { return "<span class='badge panel-badge-primary me-1'>".e($name)."</span>"; })->implode(' '); ?>

                                        <?php else: ?>
                                            <span class="badge panel-badge-muted">Sin permisos</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="actions-col">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rol-edit')): ?>
                                            <a href="<?php echo e(route('roles.edit', $reg->getKey())); ?>" class="btn btn-sm btn-outline-info" title="Editar"><i class="bi bi-pencil"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rol-delete')): ?>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar-role-<?php echo e($reg->getKey()); ?>" title="Eliminar"><i class="bi bi-trash"></i></button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox me-2"></i>No hay registros que coincidan con la búsqueda
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rol-delete')): ?>
                    <?php echo $__env->make('role.delete', ['reg' => $reg], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando <?php echo e($registros->count()); ?> de <?php echo e($registros->total()); ?> roles</div>
                <div><?php echo e($registros->appends(['texto' => $texto])->links()); ?></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('mnuSeguridad').classList.add('menu-open');
    document.getElementById('itemRole').classList.add('active');
    document.getElementById('mnuSeguridadLink')?.classList.add('active');
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('plantilla.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/role/index.blade.php ENDPATH**/ ?>