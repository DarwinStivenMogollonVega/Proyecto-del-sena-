<div class="modal fade" id="modal-eliminar-{{ $reg->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('proveedores.destroy', $reg->id) }}" method="post" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Eliminar proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Confirmar eliminacion del proveedor <strong>{{ $reg->nombre }}</strong>.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </div>
        </form>
    </div>
</div>
