@php
    // Backwards-compatible delete modal for cliente records.
    $actionResolved = $action ?? (isset($reg) ? route('usuarios.destroy', $reg->getKey()) : '#');
    $modalId = $modalId ?? (isset($reg) ? 'modal-eliminar-cliente-'.$reg->getKey() : 'modal-eliminar-cliente');
    $titleText = $title ?? (isset($reg) ? "Eliminar: {$reg->name}" : 'Confirmar eliminación');
@endphp

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ $actionResolved }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="{{ $modalId }}Label">{{ $titleText }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Confirmar eliminación del cliente <strong>{{ $reg->name ?? $reg->nombre }}</strong>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $cancelText ?? 'Cancelar' }}</button>
                    <button type="submit" class="btn btn-danger">{{ $buttonText ?? 'Eliminar' }}</button>
                </div>

                @if($actionResolved === '#')
                    <div class="px-3 pb-3"><small class="text-muted">Ruta de acción no proporcionada.</small></div>
                @endif
            </form>
        </div>
    </div>
</div>
