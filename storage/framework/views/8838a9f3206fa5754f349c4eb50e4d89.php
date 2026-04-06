
<div class="checkout-steps-bg w-100">
    <div class="checkout-steps d-flex justify-content-center align-items-center" style="margin-bottom:0;">
    <?php
        $steps = [
            ['label' => 'Carrito', 'icon' => 'bi-cart3'],
            ['label' => 'Datos', 'icon' => 'bi-person'],
            ['label' => 'Entrega', 'icon' => 'bi-truck'],
            ['label' => 'Pago', 'icon' => 'bi-currency-dollar']
        ];
    ?>
    <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="stepper-item text-center flex-fill">
            <div class="stepper-circle mb-1 <?php echo e(isset($currentStep) && $currentStep == $i ? 'active' : (isset($currentStep) && $currentStep > $i ? 'completed' : '')); ?>">
                <i class="bi <?php echo e($step['icon']); ?>"></i>
            </div>
            <div class="stepper-label <?php echo e(isset($currentStep) && $currentStep == $i ? 'active' : (isset($currentStep) && $currentStep > $i ? 'completed' : '')); ?>">
                <?php echo e($step['label']); ?>

            </div>
        </div>
        <?php if($i < count($steps) - 1): ?>
            <div class="stepper-line flex-grow-1 align-self-center <?php echo e(isset($currentStep) && $currentStep > $i ? 'completed' : ''); ?>"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</div>

<?php $__env->startPush('estilos'); ?>
<style>
.checkout-steps-bg {
    /* Fondo adaptivo: usa color similar al background de la tarjeta principal */
    background: linear-gradient(90deg, #fff7ed 0%, #f3e3d1 100%);
    padding: 2.2rem 0 1.7rem 0;
    border-radius: 1.5rem;
    margin-bottom: 2.5rem;
    transition: background 0.2s;
}
html[data-theme='dark'] .checkout-steps-bg {
    background: linear-gradient(90deg, #232c3b 0%, #3d1e0a 100%);
}
.checkout-steps { gap: 0.5rem; }
.stepper-item { min-width: 80px; }
.stepper-circle {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #e5e7eb;
    color: #7c9a3c;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    margin: 0 auto;
    border: 2px solid #e5e7eb;
    transition: background 0.2s, border 0.2s;
}
.stepper-circle.active {
    background: #7c9a3c;
    color: #fff;
    border-color: #7c9a3c;
}
.stepper-circle.completed {
    background: #b6d7a8;
    color: #7c9a3c;
    border-color: #b6d7a8;
}
.stepper-label {
    font-size: 0.98rem;
    color: #888;
    font-weight: 500;
}
.stepper-label.active {
    color: #7c9a3c;
    font-weight: 700;
}
.stepper-label.completed {
    color: #7c9a3c;
}
.stepper-line {
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    min-width: 32px;
    margin: 0 2px;
    transition: background 0.2s;
}
.stepper-line.completed {
    background: #7c9a3c;
}
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/partials/checkout_steps.blade.php ENDPATH**/ ?>