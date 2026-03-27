<?php $__env->startSection('contenido'); ?>
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Pedidos</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div>
                            <form action="<?php echo e(route('admin.pedidos')); ?>" method="get">
                                <div class="input-group">
                                    <input name="texto" type="text" class="form-control" value="<?php echo e($texto); ?>"
                                        placeholder="Ingrese texto a buscar">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i>
                                            Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php if(Session::has('mensaje')): ?>
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            <?php echo e(Session::get('mensaje')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        <?php endif; ?>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 150px">Opciones</th>
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
                                    <?php if(count($registros)<=0): ?> <tr>
                                        <td colspan="8">No hay registros que coincidan con la búsqueda</td>
                                        </tr>
                                        <?php else: ?>
                                        <?php $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="align-middle">
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modal-estado-<?php echo e($reg->id); ?>"><i
                                                        class="bi bi bi-arrow-repeat"></i>
                                                </button>
                                            </td>
                                            <td><?php echo e($reg->id); ?></td>
                                            <td><?php echo e($reg->created_at->format('d/m/Y')); ?></td>
                                            <td><?php echo e($reg->user->name); ?></td>
                                            <td>
                                                <?php if($reg->requiere_factura_electronica): ?>
                                                    <span class="badge bg-info text-dark">FE</span>
                                                    <div class="small text-muted mt-1"><?php echo e(strtoupper($reg->tipo_documento ?? '-')); ?> <?php echo e($reg->numero_documento ?? ''); ?></div>
                                                <?php else: ?>
                                                    <span class="text-muted small">No</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>$<?php echo e(number_format($reg->total, 2)); ?></td>
                                            <td>
                                                <?php
                                                    $colores = [
                                                        'pendiente' => 'bg-warning',
                                                        'enviado' => 'bg-success',
                                                        'anulado' => 'bg-danger',
                                                        'cancelado' => 'bg-secondary',
                                                    ];
                                                ?>
                                                <span class="badge <?php echo e($colores[$reg->estado] ?? 'bg-dark'); ?>">
                                                    <?php echo e(ucfirst($reg->estado)); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#detalles-<?php echo e($reg->id); ?>">
                                                    Ver detalles
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="detalles-<?php echo e($reg->id); ?>">
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
                                                                <img src="<?php echo e(asset('uploads/productos/' . $detalle->producto->imagen )); ?>"
                                                                    class="img-fluid rounded"
                                                                    style="width: 80px; height: 80px; object-fit: cover;"
                                                                    alt="<?php echo e($detalle->producto->nombre); ?>">
                                                            </td>
                                                            <td><?php echo e($detalle->cantidad); ?></td>
                                                            <td><?php echo e(number_format($detalle->precio, 2)); ?></td>
                                                            <td><?php echo e(number_format($detalle->cantidad * $detalle->precio, 2)); ?>

                                                            </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php echo $__env->make('pedido.state', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <?php echo e($registros->appends(["texto"=>$texto])); ?>

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('mnuPedidos').classList.add('active');
document.getElementById('mnuComercial')?.classList.add('menu-open');
document.getElementById('mnuComercialLink')?.classList.add('active');
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('plantilla.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/laravelapp/resources/views/pedido/index.blade.php ENDPATH**/ ?>