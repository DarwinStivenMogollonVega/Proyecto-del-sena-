<?php $__env->startSection('titulo', 'Lista de Deseados - DiscZone'); ?>

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/wishlist-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/index-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container px-4 px-lg-5 mt-5 wishlist-container">
    <section class="wishlist-hero p-4 p-lg-5 mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold mb-2 wishlist-title">Tus discos deseados</h1>
                <p class="mb-0 hero-subtitle">Guarda tus favoritos para no perderlos de vista y comprarlos después.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">
                <a href="<?php echo e(route('web.index')); ?>" class="btn btn-light px-4 wishlist-back-btn">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la tienda
                </a>
            </div>
        </div>
    </section>

    <div class="wishlist-section rounded shadow-sm p-4">
        <h2 class="text-center mb-4 wishlist-section-title">Lista de Deseados</h2>
        <?php if(session('wishlist') && count(session('wishlist')) > 0): ?>
            <div class="row wishlist-list">
                <?php $__currentLoopData = session('wishlist'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 wishlist-item-col">
                        <article class="all-product-card">
                            <div class="all-product-cover">
                                <?php if(!empty($item['imagen'])): ?>
                                    <img src="<?php echo e(asset('uploads/productos/' . $item['imagen'])); ?>" alt="<?php echo e($item['nombre']); ?>">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('img/no-image.jpg')); ?>" alt="Sin imagen">
                                <?php endif; ?>
                                <span class="all-product-stock badge bg-success"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                            </div>
                            <div class="all-product-body">
                                <p class="all-product-name" title="<?php echo e($item['nombre']); ?>"><?php echo e($item['nombre']); ?></p>
                                <p class="all-product-artist"><?php echo e($item['artista'] ?? ''); ?></p>
                                <div class="all-product-meta">
                                    
                                </div>
                                <div class="all-product-inline-stats">
                                    <span><i class="bi bi-star-fill text-warning me-1"></i>0.0</span>
                                    <span><i class="bi bi-chat-left-text me-1"></i>0</span>
                                    <span><i class="bi bi-box-seam me-1"></i><?php echo e($item['cantidad'] ?? 0); ?></span>
                                </div>
                                <form action="<?php echo e(route('web.wishlist.remove', $item['id'])); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="all-product-wishlist-btn" title="Quitar de deseados">
                                        <i class="bi bi-heart-fill text-danger"></i>
                                    </button>
                                </form>
                                <a href="<?php echo e(route('web.show', $item['id'])); ?>" class="all-product-cta" title="Ver producto">
                                    <i class="bi bi-eye"></i> ver
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted wishlist-empty">No hay productos en la lista de deseados.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/wishlist.blade.php ENDPATH**/ ?>