<?php
    // Generic activate/deactivate modal partial.
    // Expects: $reg (model), optional overrides: $action, $modalId, $title, $message, $buttonText, $cancelText
    $actionResolved = $action ?? (isset($reg) ? route('usuarios.toggle', $reg->getKey()) : '#');
    $modalId = $modalId ?? (isset($reg) ? 'modal-toggle-'.$reg->getKey() : 'modal-toggle');
    $isActive = isset($reg) ? (bool) ($reg->activo ?? $reg->active ?? false) : false;
    $titleText = $title ?? ($isActive ? 'Desactivar registro' : 'Activar registro');
    $messageText = $message ?? ($isActive ? "¿Usted desea desactivar el registro {$reg->name}?" : "¿Usted desea activar el registro {$reg->name}?");
    $buttonText = $buttonText ?? ($isActive ? 'Desactivar' : 'Activar');
    $cancelText = $cancelText ?? 'Cerrar';
    $contentClass = $contentClass ?? ($isActive ? 'bg-warning' : 'bg-success');
?>

<div class="modal fade" id="<?php echo e($modalId); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo e($modalId); ?>Label" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:600px;">
        <div class="modal-content bg-white p-4" style="border-radius:1.2rem; box-shadow:0 12px 36px rgba(0,0,0,.12);">
            <form action="<?php echo e($actionResolved); ?>" method="post" aria-describedby="<?php echo e($modalId); ?>Label">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="modal-header border-0 pb-0">
                    <h4 class="modal-title fw-bold" id="<?php echo e($modalId); ?>Label" style="color:<?php echo e($isActive ? 'var(--adm-danger)' : '#0f8a3e'); ?>; font-size:1.4rem;"><?php echo e($titleText); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" style="color:#222; font-size:1rem;">
                    <div class="mb-3" style="background:#f7fbfd; border:1px solid #e6eef4; border-radius:.8rem; padding:1rem; box-shadow:0 2px 6px rgba(14,30,37,0.03);">
                        <?php echo e($message ?? $messageText); ?>

                    </div>
                    <p class="mb-0 text-center">&nbsp;</p>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0">
                    <div class="d-flex justify-content-center gap-3 w-100">
                        <button type="button" class="btn btn-secondary px-4 py-2" style="font-size:1rem; border-radius:.6rem; min-width:120px;" data-bs-dismiss="modal"><?php echo e($cancelText); ?></button>
                        <button type="submit" class="btn <?php echo e($isActive ? 'btn-danger' : 'btn-success'); ?> px-4 py-2" style="font-size:1rem; border-radius:.6rem; min-width:120px;"><?php echo e($buttonText); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/partials/activate.blade.php ENDPATH**/ ?>