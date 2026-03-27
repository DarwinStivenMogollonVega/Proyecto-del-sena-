<?php
    $actionResolved = $action ?? (isset($reg) ? route('categoria.destroy', $reg->getKey()) : '#');
    $modalId = $modalId ?? (isset($reg) ? 'modal-eliminar-categoria-'.$reg->getKey() : 'modal-eliminar-categoria');
    $titleText = $title ?? (isset($reg) ? "Eliminar: {$reg->nombre}" : 'Confirmar eliminación');
    $messageText = $message ?? (isset($reg) ? "Esta acción es irreversible. Confirma eliminar la categoría: {$reg->nombre}." : 'Esta acción es irreversible. ¿Deseas continuar?');
?>

<div class="modal fade" id="<?php echo e($modalId); ?>" tabindex="-1" aria-labelledby="<?php echo e($modalId); ?>Label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:640px;">
        <div class="modal-content bg-white p-4" style="border-radius:1.2rem; box-shadow:0 8px 32px rgba(0,0,0,.18);">
            <form action="<?php echo e($actionResolved); ?>" method="post" aria-describedby="<?php echo e($modalId); ?>Label">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-header border-0 pb-0">
                    <h4 class="modal-title fw-bold" id="<?php echo e($modalId); ?>Label" style="color:#b91c1c; font-size:1.5rem;"><?php echo e($title ?? 'Eliminar categoría'); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" style="color:#222; font-size:1.02rem;">
                    <div class="mb-3" style="background:#f7fbfd; border:1px solid #e6eef4; border-radius:.8rem; padding:1rem; box-shadow:0 2px 6px rgba(14,30,37,0.03);">
                        <strong>Advertencia:</strong> Esta acción es <u>irreversible</u>. Por favor, confirme que realmente desea eliminar la categoría <strong><?php echo e($reg->nombre ?? $reg->name); ?></strong>.
                    </div>
                    <p class="mb-0 text-center">¿Usted desea eliminar la categoría <strong><?php echo e($reg->nombre ?? $reg->name); ?></strong>?</p>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0">
                    <div class="d-flex justify-content-center gap-2 w-100">
                        <button type="button" class="btn btn-secondary px-4 py-2" style="font-size:1rem; border-radius:.5rem; min-width:120px;" data-bs-dismiss="modal" aria-label="Cancelar eliminación"><?php echo e($cancelText ?? 'Cerrar'); ?></button>
                        <button type="submit" class="btn btn-danger px-4 py-2" style="font-size:1rem; border-radius:.5rem; min-width:120px;" aria-label="Confirmar eliminación"><?php echo e($buttonText ?? 'Eliminar'); ?></button>
                    </div>
                </div>

                <?php if($actionResolved === '#'): ?>
                    <div class="px-3 pb-3"><small class="text-muted">Ruta de acción no proporcionada.</small></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('8988a8c3-965b-4266-a1d2-3e7143fb9c3d')): $__env->markAsRenderedOnce('8988a8c3-965b-4266-a1d2-3e7143fb9c3d'); ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
        (function(){
            var id = <?php echo e(json_encode($modalId)); ?>;
            document.addEventListener('DOMContentLoaded', function(){
                var modalEl = document.getElementById(id);
                if(!modalEl) return;
                modalEl.addEventListener('shown.bs.modal', function (e) {
                    var btn = modalEl.querySelector('.modal-footer button.btn-secondary');
                    if(btn) btn.focus();
                });
            });
        })();
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/categoria/delete.blade.php ENDPATH**/ ?>