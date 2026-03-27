<?php
    // Bridge to shared activate partial for backward compatibility
    $modalId = $modalId ?? ('modal-toggle-'.$reg->getKey());
?>

<?php echo $__env->make('partials.activate', [
    'reg' => $reg,
    'modalId' => $modalId,
    'action' => route('usuarios.toggle', $reg->getKey()),
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/usuario/activate.blade.php ENDPATH**/ ?>