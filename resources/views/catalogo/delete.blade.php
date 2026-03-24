<div class="modal fade" id="modal-eliminar-{{$reg->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content bg-white" style="border-radius:1rem;">
            <form action="{{ route('catalogo.destroy', $reg->id) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0">
                    <h4 class="modal-title" style="color:#b91c1c;">Eliminar registro</h4>
                </div>
                <div class="modal-body" style="color:#222;">
                    ¿Desea eliminar el registro <strong>{{ $reg->nombre }}</strong>?
                </div>
                <div class="modal-footer justify-content-between border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
