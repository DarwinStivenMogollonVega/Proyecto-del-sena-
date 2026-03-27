<?php $__env->startSection('titulo', 'Lista de Deseados - DiscZone'); ?>

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/wishlist-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container px-4 px-lg-5 mt-5">
    <section class="wishlist-hero p-4 p-lg-5 mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold mb-2">Tus discos deseados</h1>
                <p class="mb-0 hero-subtitle">Guarda tus favoritos para no perderlos de vista y comprarlos después.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                <a href="<?php echo e(route('web.index')); ?>" class="btn btn-light px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la tienda
                </a>
            </div>
        </div>
    </section>

    <div class="wishlist-section bg-white rounded shadow-sm p-4">
        <h2 class="text-center mb-4">Lista de Deseados</h2>
        <?php if(session('wishlist') && count(session('wishlist')) > 0): ?>
            <div class="row">
                <?php $__currentLoopData = session('wishlist'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card wishlist-card h-100 shadow-sm">
                            <img src="<?php echo e(asset('uploads/productos/' . ($item['imagen'] ?? 'no-image.jpg'))); ?>" class="card-img-top" alt="<?php echo e($item['nombre']); ?>">
                            <div class="card-body text-center">
                                <h5 class="fw-bolder"><?php echo e($item['nombre']); ?></h5>
                                <span class="d-block mb-2"><?php echo e($item['artista'] ?? ''); ?></span>
                                <span class="badge bg-dark mb-2">$<?php echo e(number_format($item['precio'], 2)); ?></span>
                                <a href="<?php echo e(route('web.show', $item['id'])); ?>" class="btn btn-sm btn-outline-primary">Ver producto</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No hay productos en la lista de deseados.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/laravelapp/resources/views/web/wishlist.blade.php ENDPATH**/ ?>