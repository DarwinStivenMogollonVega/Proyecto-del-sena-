@php
    // Bridge to usuario.delete for role delete modal
    $modalId = $modalId ?? ('modal-eliminar-role-'.($reg->getKey() ?? ''));
@endphp

@include('usuario.delete', [
    'reg' => $reg,
    'modalId' => $modalId,
    'action' => $action ?? route('roles.destroy', $reg->getKey()),
])
