@php
    // Bridge to shared activate partial for backward compatibility
    $modalId = $modalId ?? ('modal-toggle-formato-'.$reg->getKey());

    // Resolve an action route if available
    use Illuminate\Support\Facades\Route;

    if (Route::has('formato.toggle')) {
        $actionRoute = route('formato.toggle', $reg->getKey());
    } elseif (Route::has('catalogo.toggle')) {
        $actionRoute = route('catalogo.toggle', $reg->getKey());
    } else {
        $actionRoute = '#';
    }
@endphp

@include('partials.activate', [
    'reg' => $reg,
    'modalId' => $modalId,
    'action' => $actionRoute,
    'title' => ($reg->activo ?? false) ? 'Desactivar formato' : 'Activar formato',
    'message' => ($reg->activo ?? false) ? "¿Desea desactivar el formato '{$reg->nombre}'?" : "¿Desea activar el formato '{$reg->nombre}'?",
    'buttonText' => ($reg->activo ?? false) ? 'Desactivar' : 'Activar'
])
