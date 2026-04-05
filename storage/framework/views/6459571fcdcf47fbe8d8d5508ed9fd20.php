<?php $__env->startSection('contenido'); ?>
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">
                    <i class="bi bi-graph-up-arrow me-2" style="color:var(--adm-accent)"></i>Informacion General
                </h4>
                <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem">
                    Resumen general del sistema usando la misma fuente de datos del dashboard.
                </p>
            </div>
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Volver al dashboard
            </a>
        </div>

        <?php if(!empty($estadisticaGeneral)): ?>
        <div class="card mb-4" style="border-radius:1rem;border-left:4px solid #1d4ed8">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge rounded-pill" style="background:rgba(29,78,216,.12);color:#1d4ed8">
                                <i class="bi <?php echo e($estadisticaGeneral['icono']); ?>"></i>
                            </span>
                            <h5 class="mb-0 fw-bold" style="color:var(--adm-heading)"><?php echo e($estadisticaGeneral['titulo']); ?></h5>
                        </div>
                        <p class="mb-0 small" style="color:var(--adm-muted)"><?php echo e($estadisticaGeneral['descripcion']); ?></p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e($estadisticaGeneral['detalle_url']); ?>" class="btn btn-sm btn-primary">
                            Ver detalle
                        </a>
                        <a href="<?php echo e($estadisticaGeneral['pdf_url']); ?>" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </a>
                        <a href="<?php echo e($estadisticaGeneral['excel_url']); ?>" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-file-earmark-excel"></i>
                        </a>
                    </div>
                </div>

                <?php if(!empty($estadisticaGeneral['stats'])): ?>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <?php $__currentLoopData = $estadisticaGeneral['stats']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="background:rgba(29,78,216,.07);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                        <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700"><?php echo e($stat['label']); ?></div>
                        <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2"><?php echo e($stat['value']); ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if(!empty($stockCategoria) && !empty($stockDetalle)): ?>
        <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <h5 class="fw-bold mb-1" style="color:var(--adm-heading)">
                        <i class="bi bi-box-seam-fill me-2" style="color:var(--adm-accent)"></i>Estadisticas del stock
                    </h5>
                    <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem">
                        Analisis completo del inventario: unidades disponibles por producto, resumen general y alertas de stock.
                    </p>
                </div>
            </div>

            <div class="card mb-3" style="border-radius:1rem;border-left:4px solid #0ea5e9">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge rounded-pill" style="background:rgba(14,165,233,.14);color:#0284c7">
                                    <i class="bi <?php echo e($stockCategoria['icono']); ?>"></i>
                                </span>
                                <h5 class="mb-0 fw-bold" style="color:var(--adm-heading)"><?php echo e($stockCategoria['titulo']); ?></h5>
                            </div>
                            <p class="mb-0 small" style="color:var(--adm-muted)"><?php echo e($stockCategoria['descripcion']); ?></p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e($stockCategoria['detalle_url']); ?>" class="btn btn-sm btn-info text-white">
                                Ver detalle
                            </a>
                            <a href="<?php echo e($stockCategoria['pdf_url']); ?>" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                            <a href="<?php echo e($stockCategoria['excel_url']); ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-excel"></i>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <?php $__currentLoopData = $stockDetalle['summary']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="background:rgba(14,165,233,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700"><?php echo e($item['label']); ?></div>
                            <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2"><?php echo e($item['value']); ?></div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

        </div>
        <?php endif; ?>

        <?php if(!empty($proveedoresCategoria) && !empty($proveedoresDetalle)): ?>
        <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <h5 class="fw-bold mb-1" style="color:var(--adm-heading)">
                        <i class="bi bi-truck-front-fill me-2" style="color:var(--adm-accent)"></i>Estadisticas de proveedores
                    </h5>
                    <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem">
                        Rendimiento de cada proveedor segun productos suministrados, unidades vendidas e ingresos generados.
                    </p>
                </div>
            </div>

            <div class="card mb-3" style="border-radius:1rem;border-left:4px solid #f97316">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge rounded-pill" style="background:rgba(249,115,22,.14);color:#ea580c">
                                    <i class="bi <?php echo e($proveedoresCategoria['icono']); ?>"></i>
                                </span>
                                <h5 class="mb-0 fw-bold" style="color:var(--adm-heading)"><?php echo e($proveedoresCategoria['titulo']); ?></h5>
                            </div>
                            <p class="mb-0 small" style="color:var(--adm-muted)"><?php echo e($proveedoresCategoria['descripcion']); ?></p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e($proveedoresCategoria['detalle_url']); ?>" class="btn btn-sm btn-warning text-white">
                                Ver detalle
                            </a>
                            <a href="<?php echo e($proveedoresCategoria['pdf_url']); ?>" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                            <a href="<?php echo e($proveedoresCategoria['excel_url']); ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-excel"></i>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <?php $__currentLoopData = $proveedoresDetalle['summary']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="background:rgba(249,115,22,.08);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700"><?php echo e($item['label']); ?></div>
                            <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2"><?php echo e($item['value']); ?></div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if($categoriasVentas->isNotEmpty()): ?>
        <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <h5 class="fw-bold mb-1" style="color:var(--adm-heading)">
                        <i class="bi bi-music-note-list me-2" style="color:var(--adm-accent)"></i>Ventas por categoria musical
                    </h5>
                    <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem">
                        Estadisticas de compras reales desglosadas por cada categoria musical del sistema — igual que los datos de interes del dashboard del cliente pero agregados a nivel global.
                    </p>
                </div>
            </div>

            <div class="d-flex flex-column gap-3 mt-2">
                <?php $__currentLoopData = $categoriasVentas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card" style="border-radius:1rem;border-left:4px solid #10b981">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge rounded-pill" style="background:rgba(16,185,129,.13);color:#059669">
                                        <i class="bi <?php echo e($categoria['icono']); ?>"></i>
                                    </span>
                                    <h5 class="mb-0 fw-bold" style="color:var(--adm-heading)"><?php echo e($categoria['titulo']); ?></h5>
                                </div>
                                <p class="mb-0 small" style="color:var(--adm-muted)"><?php echo e($categoria['descripcion']); ?></p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e($categoria['detalle_url']); ?>" class="btn btn-sm btn-success">Ver detalle</a>
                                <a href="<?php echo e($categoria['pdf_url']); ?>" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                                <a href="<?php echo e($categoria['excel_url']); ?>" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-file-earmark-excel"></i>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <div style="background:rgba(16,185,129,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                                <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">Productos</div>
                                <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2"><?php echo e($categoria['total_productos']); ?></div>
                            </div>
                            <div style="background:rgba(16,185,129,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                                <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">Pedidos</div>
                                <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2"><?php echo e($categoria['total_pedidos']); ?></div>
                            </div>
                            <div style="background:rgba(16,185,129,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                                <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">Unidades vendidas</div>
                                <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2"><?php echo e($categoria['total_unidades']); ?></div>
                            </div>
                            <div style="background:rgba(16,185,129,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                                <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">Ventas</div>
                                <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2">$<?php echo e(number_format($categoria['total_ventas'], 2)); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php else: ?>
        <div class="mt-4 alert alert-light border" style="border-radius:.9rem">
            <i class="bi bi-info-circle me-2"></i>
            Aun no hay categorias musicales registradas. Agrega categorias en el panel para ver aqui sus estadisticas de ventas.
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('mnuEstadisticas')?.classList.add('active');
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('plantilla.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/estadisticas/index.blade.php ENDPATH**/ ?>