<?php $__env->startSection('contenido'); ?>
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Productos</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Listado de productos registrados en el sistema</p>
            </div>
            <div class="d-flex gap-2">
                <form action="<?php echo e(route('productos.index')); ?>" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="<?php echo e($texto); ?>" placeholder="Buscar producto por nombre o codigo">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('producto-create')): ?>
                    <a href="<?php echo e(route('productos.create')); ?>" class="btn btn-sm btn-primary">Nuevo</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-body p-0">

                        <?php if(Session::has('mensaje')): ?>
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            <?php echo e(Session::get('mensaje')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="min-width:900px">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">ID</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Proveedor</th>
                                        <th>Artista</th>
                                        <th>Año</th>
                                        <th>Categoría</th>
                                        <th>Catálogo</th>
                                        <th>Imagen</th>
                                <th class="actions-col" style="width: 150px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($reg->getKey()); ?></td>
                                            <td><?php echo e($reg->codigo); ?></td>
                                            <td><?php echo e($reg->nombre); ?></td>
                                            <td>$<?php echo e(number_format($reg->precio,2)); ?></td>
                                            <td><?php echo e($reg->cantidad); ?></td>
                                            <td><?php echo e($reg->proveedor->nombre ?? 'Sin proveedor'); ?></td>
                                    <td><?php echo e($reg->artista->nombre ?? 'Sin artista'); ?></td>
                                            <td><?php echo e($reg->anio_lanzamiento ?? '-'); ?></td>
                                            <td>
                                                <?php if($reg->categoria): ?>
                                                    <span class="badge panel-badge-primary"><?php echo e($reg->categoria->nombre); ?></span>
                                                <?php else: ?>
                                                    <span class="badge panel-badge-muted">Sin Categoría</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($reg->catalogo): ?>
                                                    <span class="badge panel-badge-success"><?php echo e($reg->catalogo->nombre); ?></span>
                                                <?php else: ?>
                                                    <span class="badge panel-badge-muted">Sin Catálogo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                    <?php if($reg->imagen): ?>
                                                <img src="<?php echo e(asset('uploads/productos/' . $reg->imagen)); ?>" alt="<?php echo e($reg->nombre); ?>" style="max-width: 100px; height: auto; border-radius:8px;">
                                                    <?php else: ?>
                                                        <span>Sin imagen</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="actions-col">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('producto-edit')): ?>
                                                <a href="<?php echo e(route('productos.edit', $reg->getKey())); ?>" class="btn btn-sm btn-outline-info" title="Editar"><i class="bi bi-pencil"></i></a>
                                                <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('producto-delete')): ?>
                                                        <button 
                                                            type="button"
                                                            class="btn btn-sm btn-outline-danger btn-delete-action"
                                                            -bs-toggle="modal"
                                                            data-bs-target="#modal-eliminar-producto-<?php echo e($reg->getKey()); ?>"
                                                            aria-label="Eliminar producto <?php echo e($reg->nombre ?? 'producto'); ?>"
                                                            title="Eliminar producto"
                                                        >
                                                        <i class="bi bi-trash"></i>
                                                        </button>
                                                            <?php endif; ?>
                                            </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="12" class="text-center py-4" style="color:#888;">
                                                <i class="bi bi-inbox me-2"></i>No hay registros que coincidan con la búsqueda
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div>Mostrando <?php echo e($registros->count()); ?> de <?php echo e($registros->total()); ?> productos</div>
                        <div><?php echo e($registros->appends(['texto' => $texto])->links()); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
                    <?php $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('producto-delete')): ?>
                            <?php echo $__env->make('producto.delete', ['reg' => $reg], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('producto-activate')): ?>
                            <?php echo $__env->make('producto.activate', ['reg' => $reg], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/producto/index.blade.php ENDPATH**/ ?>