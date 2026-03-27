

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/formulario_pedido_section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>


<?php $__env->startSection('contenido'); ?>
<section class="formulario-pedido-wrap py-5" style="margin-top: 0rem;">
    <?php echo $__env->make('web.partials.checkout_steps', ['currentStep' => 3], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="container px-4 px-lg-5 my-3 my-lg-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-1">Finalizar compra</h2>
                    <p class="mb-0 text-white-50">Selecciona la opción de pago que prefieras para finalizar tu compra.</p>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <a href="<?php echo e(route('pedido.entrega')); ?>" class="btn btn-outline-light btn-lg px-4 shadow-sm fw-semibold rounded-pill">
                        <i class="bi bi-arrow-left me-2"></i> Volver a entrega
                    </a>
                </div>
                <div class="checkout-card p-4 p-lg-5 mt-3">
                    <form action="<?php echo e(route('pedido.pago.guardar')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <strong>Corrige los siguientes errores:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="list-group">
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input class="form-check-input me-2" type="radio" name="metodo_pago" value="tarjeta" required>
                                        <i class="bi bi-credit-card fs-4 text-primary"></i>
                                        <span>Tarjeta crédito o débito</span>
                                    </label>
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input class="form-check-input me-2" type="radio" name="metodo_pago" value="pse">
                                        <img src="<?php echo e(asset('assets/img/bancolombia.png')); ?>" alt="Bancolombia" style="width:28px;">
                                        <span class="bancolombia-text">Bancolombia</span>
                                    </label>
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input class="form-check-input me-2" type="radio" name="metodo_pago" value="nequi">
                                        <img src="<?php echo e(asset('assets/img/nequi.png')); ?>" alt="Nequi" style="width:28px;">
                                        <span class="nequi-text">Nequi</span>
                                    </label>
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input class="form-check-input me-2" type="radio" name="metodo_pago" value="efectivo">
                                        <i class="bi bi-cash-coin fs-4 text-success"></i>
                                        <span>Efectivo</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Campos condicionales para cada método de pago -->
                        <div id="pago-tarjeta" class="mt-3" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label">Número de tarjeta</label>
                                <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="tarjeta_numero" maxlength="19" oninput="this.value = this.value.replace(/\D/g,'')">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Nombre en la tarjeta</label>
                                <input type="text" class="form-control" name="tarjeta_nombre">
                            </div>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="form-label">Expira</label>
                                    <input type="text" class="form-control" name="tarjeta_expira" placeholder="MM/AA" maxlength="5">
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">CVV</label>
                                    <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="tarjeta_cvv" maxlength="4" oninput="this.value = this.value.replace(/\D/g,'')">
                                </div>
                            </div>
                        </div>
                        <div id="pago-pse" class="mt-3" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label">Banco</label>
                                <input type="text" class="form-control" name="pse_banco">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Cédula del titular</label>
                                <input type="text" class="form-control" name="pse_cedula">
                            </div>
                        </div>
                        <div id="pago-nequi" class="mt-3" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label">Número de celular Nequi</label>
                                <input type="text" class="form-control" name="nequi_celular">
                            </div>
                        </div>
                        <div id="pago-efectivo" class="mt-3" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label">Punto de pago</label>
                                <select class="form-select" name="efectivo_punto">
                                    <option value="">Selecciona...</option>
                                    <option value="baloto">Baloto</option>
                                    <option value="efecty">Efecty</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                            <button type="submit" class="btn btn-dark px-4 flex-fill" style="background:#d87c23; border:none; color:#fff; font-weight:600; border-radius:12px;">
                                Finalizar compra <i class="bi bi-check-circle ms-2"></i>
                            </button>
                        </div>
                        <hr class="my-3">
                        <div class="mt-3">
                            <label class="form-label">Comprobante de pago (opcional)</label>
                            <input type="file" name="comprobante_pago" class="form-control">
                            <small class="text-muted">JPG, PNG, WEBP — máximo 4 MB</small>
                        </div>

                        <div class="mt-3">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="requiere_factura_electronica" value="1" <?php echo e(old('requiere_factura_electronica', $pago['requiere_factura_electronica'] ?? false) ? 'checked' : ''); ?>>
                                <span class="form-check-label">Solicitar factura electrónica</span>
                            </label>
                        </div>
                        <div id="factura-fields" style="display: none;" class="mt-2">
                            <div class="mb-2">
                                <label class="form-label">Tipo de documento</label>
                                <select name="tipo_documento" class="form-select">
                                    <option value="">Selecciona...</option>
                                    <option value="nit">NIT</option>
                                    <option value="cedula">Cédula</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Número de documento</label>
                                <input type="text" name="numero_documento" class="form-control" value="<?php echo e(old('numero_documento')); ?>">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Razón social</label>
                                <input type="text" name="razon_social" class="form-control" value="<?php echo e(old('razon_social')); ?>">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Correo para factura</label>
                                <input type="email" name="correo_factura" class="form-control" value="<?php echo e(old('correo_factura')); ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="metodo_pago"]');
    const bloques = {
        tarjeta: document.getElementById('pago-tarjeta'),
        pse: document.getElementById('pago-pse'),
        nequi: document.getElementById('pago-nequi'),
        efectivo: document.getElementById('pago-efectivo')
    };
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            Object.values(bloques).forEach(div => div.style.display = 'none');
            if (bloques[this.value]) {
                bloques[this.value].style.display = 'block';
            }
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.querySelector('input[name="requiere_factura_electronica"]');
    const facturaFields = document.getElementById('factura-fields');
    if (!checkbox) return;
    function toggle() {
        facturaFields.style.display = checkbox.checked ? 'block' : 'none';
    }
    toggle();
    checkbox.addEventListener('change', toggle);
});
</script>
<?php $__env->startPush('estilos'); ?>
<style>
    .bancolombia-text {
        color: #0033a0;
        font-weight: 600;
        transition: color 0.2s;
    }
    .nequi-text {
        color: #d2005a;
        font-weight: 600;
        transition: color 0.2s;
    }
    @media (prefers-color-scheme: dark) {
        .bancolombia-text { color: #4d8fff; }
        .nequi-text { color: #ff5fa2; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/web/pago_pedido.blade.php ENDPATH**/ ?>