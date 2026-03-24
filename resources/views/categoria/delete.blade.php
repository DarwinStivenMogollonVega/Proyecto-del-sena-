<div class="modal fade" id="modal-eliminar-{{$reg->id}}" tabindex="-1" aria-labelledby="modalEliminarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white p-4" style="border-radius:1.2rem; box-shadow:0 8px 32px rgba(0,0,0,.18);">
            <form action="{{route('categoria.destroy', $reg->id)}}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 pb-0">
                    <h2 class="modal-title fw-bold" style="color:#b91c1c; font-size:2rem;">Eliminar categoría</h2>
                </div>
                <div class="modal-body" style="color:#222; font-size:1.13rem;">
                    <div class="alert alert-warning mb-4" style="font-size:1em;">
                        <strong>Advertencia:</strong> Esta acción es <u>irreversible</u>. Si elimina esta categoría, no podrá recuperarla.<br>
                        Por favor, confirme que realmente desea eliminar la categoría <strong>{{ $reg->nombre }}</strong>.
                    </div>
                    <p class="mb-0">¿Usted desea eliminar la categoría <strong>{{ $reg->nombre }}</strong>?</p>
                </div>
                <div class="modal-footer justify-content-between border-0 pt-0">
                    <button type="button" class="btn btn-secondary px-4 py-2" style="font-size:1.1rem; border-radius:.6rem;" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger px-4 py-2" style="font-size:1.1rem; border-radius:.6rem;">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>