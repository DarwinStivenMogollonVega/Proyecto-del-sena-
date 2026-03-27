<div class="modal fade" id="modal-estado-<?php echo e($reg->getKey()); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content bg-warning">
            <form action="<?php echo e(route('pedidos.cambiar.estado', $reg->getKey())); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Cambiar estado del pedido # <?php echo e($reg->getKey()); ?></h4>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Seleccione el nuevo estado:</p>
                    <div class="form-group">
                        <select name="estado" class="form-control">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pedido-anulate')): ?>
                            <option value="enviado">Enviado</option>
                            <option value="anulado">Anulado</option>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pedido-cancel')): ?>
                            <option value="cancelado">Cancelado</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Cambiar estado</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/pedido/state.blade.php ENDPATH**/ ?>