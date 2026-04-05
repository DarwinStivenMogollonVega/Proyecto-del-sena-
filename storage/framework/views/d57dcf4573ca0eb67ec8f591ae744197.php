<?php $__env->startSection('contenido'); ?>
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge rounded-pill" style="background:rgba(29,78,216,.12);color:#1d4ed8">
                        <i class="bi <?php echo e($categoriaActual['icono'] ?? 'bi-graph-up-arrow'); ?> me-1"></i>
                        Seccion actual
                    </span>
                    <span class="small fw-semibold" style="color:var(--adm-muted)"><?php echo e($categoriaActual['titulo'] ?? ucfirst($categoria)); ?></span>
                </div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)"><?php echo e($titulo); ?></h4>
                <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem"><?php echo e($descripcion); ?></p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('estadisticas.index')); ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-grid me-1"></i>Categorias
                </a>
                <a href="<?php echo e(route('estadisticas.export.pdf', ['categoria' => $categoria])); ?>" class="btn btn-sm btn-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                </a>
                <a href="<?php echo e(route('estadisticas.export.excel', ['categoria' => $categoria])); ?>" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i>Excel
                </a>
            </div>
        </div>

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-body py-3">
                <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                    <div>
                        <div class="small fw-semibold text-uppercase" style="color:var(--adm-muted);letter-spacing:.06em">Navegacion de secciones</div>
                        <div class="small" style="color:var(--adm-muted)">Cambia entre ventas, productos, clientes y usuarios sin volver al listado principal.</div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($item['detalle_url']); ?>"
                           class="btn btn-sm <?php echo e($item['slug'] === $categoria ? 'btn-primary' : 'btn-outline-secondary'); ?>">
                            <i class="bi <?php echo e($item['icono']); ?> me-1"></i><?php echo e($item['titulo']); ?>

                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <?php $__currentLoopData = $summary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-lg-3">
                <div class="card h-100" style="border-radius:.9rem">
                    <div class="card-body">
                        <small style="color:var(--adm-muted)"><?php echo e($item['label']); ?></small>
                        <div class="h4 fw-bold mb-0" style="color:var(--adm-heading)"><?php echo e($item['value']); ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(!empty($indicadores) && count($indicadores) > 0): ?>
        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Indicadores visuales de rendimiento</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php $__currentLoopData = $indicadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-lg-6">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                <span class="fw-semibold" style="color:var(--adm-heading)"><?php echo e($ind['label']); ?></span>
                                <span class="badge rounded-pill" style="background:rgba(29,78,216,.12);color:#1d4ed8"><?php echo e($ind['ventas']); ?> uds</span>
                            </div>
                            <div class="progress mb-2" style="height:7px;border-radius:999px">
                                <div class="progress-bar" role="progressbar" style="width:<?php echo e($ind['percent']); ?>%"></div>
                            </div>
                            <small style="color:var(--adm-muted)">Ingresos: $<?php echo e(number_format((float) ($ind['ingresos'] ?? 0), 2)); ?></small>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="card" style="border-radius:1rem">
            <div class="card-header py-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Detalle de <?php echo e($categoriaActual['titulo'] ?? ucfirst($categoria)); ?></h6>
                    <span class="small fw-semibold" style="color:var(--adm-muted)"><?php echo e(count($rows)); ?> registros</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <?php $__currentLoopData = $headings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $heading): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($heading); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e($value); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e(count($headings)); ?>" class="text-center py-4">
                                    No hay datos disponibles para la seccion <?php echo e($categoriaActual['titulo'] ?? ucfirst($categoria)); ?>.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('mnuEstadisticas')?.classList.add('active');
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/estadisticas/show.blade.php ENDPATH**/ ?>