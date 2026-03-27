@php
    // Bridge to shared activate partial for backward compatibility
    $modalId = $modalId ?? ('modal-toggle-'.$reg->getKey());
@endphp

@include('partials.activate', [
    'reg' => $reg,
    'modalId' => $modalId,
    'action' => route('usuarios.toggle', $reg->getKey()),
])
