

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/formulario_pedido_section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('contenido'); ?>
<section class="formulario-pedido-wrap py-5" style="margin-top: 0rem;">
    <?php echo $__env->make('web.partials.checkout_steps', ['currentStep' => 2], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="container px-4 px-lg-5 my-3 my-lg-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-1">Finalizar compra</h2>
                    <p class="mb-0 text-white-50">Completa tus datos para confirmar el pedido y recibir la entrega.</p>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <a href="<?php echo e(route('pedido.datos')); ?>" class="btn btn-outline-light btn-lg px-4 shadow-sm fw-semibold rounded-pill">
                        <i class="bi bi-arrow-left me-2"></i> Volver a datos
                    </a>
                </div>
                <div class="checkout-card p-4 p-lg-5 mt-3">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <strong>Revisa los datos del formulario:</strong>
                            <ul class="mb-0 mt-2">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo e(route('pedido.entrega')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <h5 class="fw-bold mb-4">Dirección de entrega</h5>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="departamento" class="checkout-label">*Departamento</label>
                                <select name="departamento" id="departamento" class="form-select" required data-selected="<?php echo e(old('departamento')); ?>"></select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="ciudad" class="checkout-label">*Municipio o ciudad capital</label>
                                <select name="ciudad" id="ciudad" class="form-select" required data-selected="<?php echo e(old('ciudad')); ?>"></select>
                            </div>
                            <?php $__env->startPush('scripts'); ?>
                            <script src="<?php echo e(asset('js/colombia-selects.js')); ?>"></script>
                            <?php $__env->stopPush(); ?>
                            <div class="col-12 col-md-6">
                                <label for="tipo_direccion" class="checkout-label">*Tipo de dirección</label>
                                <select name="tipo_direccion" id="tipo_direccion" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="calle" <?php echo e(old('tipo_direccion') == 'calle' ? 'selected' : ''); ?>>Calle</option>
                                    <option value="carrera" <?php echo e(old('tipo_direccion') == 'carrera' ? 'selected' : ''); ?>>Carrera</option>
                                    <option value="avenida" <?php echo e(old('tipo_direccion') == 'avenida' ? 'selected' : ''); ?>>Avenida</option>
                                    <option value="transversal" <?php echo e(old('tipo_direccion') == 'transversal' ? 'selected' : ''); ?>>Transversal</option>
                                    <option value="otro" <?php echo e(old('tipo_direccion') == 'otro' ? 'selected' : ''); ?>>Otro</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="calle" class="checkout-label">*Calle</label>
                                <input type="text" name="calle" id="calle" class="form-control" value="<?php echo e(old('calle')); ?>" required>
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="numero" class="checkout-label">*Número</label>
                                <input type="text" name="numero" id="numero" class="form-control" value="<?php echo e(old('numero')); ?>" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="barrio" class="checkout-label">*Barrio</label>
                                <input type="text" name="barrio" id="barrio" class="form-control" value="<?php echo e(old('barrio')); ?>" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="piso_apto" class="checkout-label">Piso/Apartamento/Torre/Edificio</label>
                                <input type="text" name="piso_apto" id="piso_apto" class="form-control" value="<?php echo e(old('piso_apto')); ?>">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="nombre_recibe" class="checkout-label">*Nombre de la persona que recibe</label>
                                <input type="text" name="nombre_recibe" id="nombre_recibe" class="form-control" value="<?php echo e(old('nombre_recibe')); ?>" required>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                            <input type="hidden" name="direccion" id="direccion">
                            <button type="submit" class="btn btn-dark px-4 flex-fill" style="background:#d87c23; border:none; color:#fff; font-weight:600; border-radius:12px;">
                                Continuar a pago <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                    <?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function setDireccion() {
        const tipo = document.getElementById('tipo_direccion')?.value || '';
        const calle = document.getElementById('calle')?.value || '';
        const numero = document.getElementById('numero')?.value || '';
        const barrio = document.getElementById('barrio')?.value || '';
        const piso = document.getElementById('piso_apto')?.value || '';
        const ciudad = document.getElementById('ciudad')?.value || '';
        const departamento = document.getElementById('departamento')?.value || '';
        let direccion = `${tipo} ${calle} #${numero} - Barrio ${barrio}`;
        if (piso) direccion += ` - ${piso}`;
        direccion += ` - ${ciudad}, ${departamento}`;
        document.getElementById('direccion').value = direccion;
    }

    // Llenar al enviar
    const form = document.querySelector('form');
    if(form) {
        form.addEventListener('submit', setDireccion);
    }

    // Opcional: actualizar en tiempo real si quieres ver el resumen dinámico
    const inputs = ['tipo_direccion','calle','numero','barrio','piso_apto','ciudad','departamento'];
    inputs.forEach(id => {
        const el = document.getElementById(id);
        if(el) el.addEventListener('change', setDireccion);
    });
});
</script>
<?php $__env->stopPush(); ?>
                </div>
                <div class="bg-light rounded p-3 mb-4 mt-4">
                    <span class="text-muted">Dirección:</span> <strong><?php echo e(old('tipo_direccion') ? (old('tipo_direccion') . ' ' . old('calle') . ' #' . old('numero') . ' - Barrio ' . old('barrio')) : ''); ?></strong><br>
                    <span class="text-muted">Ciudad:</span> <strong><?php echo e(old('ciudad')); ?></strong><br>
                    <span class="text-muted">Departamento:</span> <strong><?php echo e(old('departamento')); ?></strong><br>
                    <span class="text-muted">Recibe:</span> <strong><?php echo e(old('nombre_recibe')); ?></strong>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/entrega_pedido.blade.php ENDPATH**/ ?>