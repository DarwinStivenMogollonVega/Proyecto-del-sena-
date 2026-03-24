<div class="modal fade" id="modal-eliminar-{{$reg->id}}" tabindex="-1" aria-labelledby="modalEliminarLabel{{$reg->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white" style="border-radius:1rem;">
            <form action="{{route('productos.destroy', $reg->id)}}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0">
                    <h4 class="modal-title" style="color:#b91c1c;">Eliminar registro</h4>
                </div>
                <div class="modal-body" style="color:#222;">
                    <div class="alert alert-warning" style="font-size:0.97em;">
                        <strong>Advertencia:</strong> Esta acción es <u>irreversible</u>. Si elimina este producto, no podrá recuperarlo. Por favor, confirme que realmente desea eliminar el registro <strong>{{ $reg->nombre ?? $reg->name }}</strong>.
                    </div>
                    ¿Usted desea eliminar el registro <strong>{{ $reg->nombre ?? $reg->name }}</strong>?
                </div>
                <div class="modal-footer justify-content-between border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
