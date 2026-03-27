<?php
    // Bridge to usuario.delete for role delete modal
    $modalId = $modalId ?? ('modal-eliminar-role-'.($reg->getKey() ?? ''));
?>

<?php echo $__env->make('usuario.delete', [
    'reg' => $reg,
    'modalId' => $modalId,
    'action' => $action ?? route('roles.destroy', $reg->getKey()),
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/role/delete.blade.php ENDPATH**/ ?>