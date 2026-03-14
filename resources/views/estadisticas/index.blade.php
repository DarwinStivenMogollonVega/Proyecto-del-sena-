@extends('plantilla.app')

@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">
                    <i class="bi bi-graph-up-arrow me-2" style="color:var(--adm-accent)"></i>Informacion General
                </h4>
                <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem">
                    Resumen general del sistema usando la misma fuente de datos del dashboard.
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Volver al dashboard
            </a>
        </div>

        @if(!empty($estadisticaGeneral))
        <div class="card mb-4" style="border-radius:1rem;border-left:4px solid #1d4ed8">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge rounded-pill" style="background:rgba(29,78,216,.12);color:#1d4ed8">
                                <i class="bi {{ $estadisticaGeneral['icono'] }}"></i>
                            </span>
                            <h5 class="mb-0 fw-bold" style="color:var(--adm-heading)">{{ $estadisticaGeneral['titulo'] }}</h5>
                        </div>
                        <p class="mb-0 small" style="color:var(--adm-muted)">{{ $estadisticaGeneral['descripcion'] }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ $estadisticaGeneral['detalle_url'] }}" class="btn btn-sm btn-primary">
                            Ver detalle
                        </a>
                        <a href="{{ $estadisticaGeneral['pdf_url'] }}" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </a>
                        <a href="{{ $estadisticaGeneral['excel_url'] }}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-file-earmark-excel"></i>
                        </a>
                    </div>
                </div>

                @if(!empty($estadisticaGeneral['stats']))
                <div class="d-flex flex-wrap gap-2 mt-3">
                    @foreach($estadisticaGeneral['stats'] as $stat)
                    <div style="background:rgba(29,78,216,.07);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                        <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">{{ $stat['label'] }}</div>
                        <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2">{{ $stat['value'] }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

        @if(!empty($stockCategoria) && !empty($stockDetalle))
        <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <h5 class="fw-bold mb-1" style="color:var(--adm-heading)">
                        <i class="bi bi-box-seam-fill me-2" style="color:var(--adm-accent)"></i>Estadisticas del stock
                    </h5>
                    <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem">
                        Analisis completo del inventario: unidades disponibles por producto, resumen general y alertas de stock.
                    </p>
                </div>
            </div>

            <div class="card mb-3" style="border-radius:1rem;border-left:4px solid #0ea5e9">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge rounded-pill" style="background:rgba(14,165,233,.14);color:#0284c7">
                                    <i class="bi {{ $stockCategoria['icono'] }}"></i>
                                </span>
                                <h5 class="mb-0 fw-bold" style="color:var(--adm-heading)">{{ $stockCategoria['titulo'] }}</h5>
                            </div>
                            <p class="mb-0 small" style="color:var(--adm-muted)">{{ $stockCategoria['descripcion'] }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ $stockCategoria['detalle_url'] }}" class="btn btn-sm btn-info text-white">
                                Ver detalle
                            </a>
                            <a href="{{ $stockCategoria['pdf_url'] }}" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                            <a href="{{ $stockCategoria['excel_url'] }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-excel"></i>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @foreach($stockDetalle['summary'] as $item)
                        <div style="background:rgba(14,165,233,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">{{ $item['label'] }}</div>
                            <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2">{{ $item['value'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        @endif

        @if(!empty($proveedoresCategoria) && !empty($proveedoresDetalle))
        <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <h5 class="fw-bold mb-1" style="color:var(--adm-heading)">
                        <i class="bi bi-truck-front-fill me-2" style="color:var(--adm-accent)"></i>Estadisticas de proveedores
                    </h5>
                    <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem">
                        Rendimiento de cada proveedor segun productos suministrados, unidades vendidas e ingresos generados.
                    </p>
                </div>
            </div>

            <div class="card mb-3" style="border-radius:1rem;border-left:4px solid #f97316">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge rounded-pill" style="background:rgba(249,115,22,.14);color:#ea580c">
                                    <i class="bi {{ $proveedoresCategoria['icono'] }}"></i>
                                </span>
                                <h5 class="mb-0 fw-bold" style="color:var(--adm-heading)">{{ $proveedoresCategoria['titulo'] }}</h5>
                            </div>
                            <p class="mb-0 small" style="color:var(--adm-muted)">{{ $proveedoresCategoria['descripcion'] }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ $proveedoresCategoria['detalle_url'] }}" class="btn btn-sm btn-warning text-white">
                                Ver detalle
                            </a>
                            <a href="{{ $proveedoresCategoria['pdf_url'] }}" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                            <a href="{{ $proveedoresCategoria['excel_url'] }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-excel"></i>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @foreach($proveedoresDetalle['summary'] as $item)
                        <div style="background:rgba(249,115,22,.08);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">{{ $item['label'] }}</div>
                            <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2">{{ $item['value'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Sección 3: una tarjeta por cada categoría musical registrada en la BD --}}
        @if($categoriasVentas->isNotEmpty())
        <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <h5 class="fw-bold mb-1" style="color:var(--adm-heading)">
                        <i class="bi bi-music-note-list me-2" style="color:var(--adm-accent)"></i>Ventas por categoria musical
                    </h5>
                    <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem">
                        Estadisticas de compras reales desglosadas por cada categoria musical del sistema — igual que los datos de interes del dashboard del cliente pero agregados a nivel global.
                    </p>
                </div>
            </div>

            <div class="d-flex flex-column gap-3 mt-2">
                @foreach($categoriasVentas as $categoria)
                <div class="card" style="border-radius:1rem;border-left:4px solid #10b981">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge rounded-pill" style="background:rgba(16,185,129,.13);color:#059669">
                                        <i class="bi {{ $categoria['icono'] }}"></i>
                                    </span>
                                    <h5 class="mb-0 fw-bold" style="color:var(--adm-heading)">{{ $categoria['titulo'] }}</h5>
                                </div>
                                <p class="mb-0 small" style="color:var(--adm-muted)">{{ $categoria['descripcion'] }}</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ $categoria['detalle_url'] }}" class="btn btn-sm btn-success">Ver detalle</a>
                                <a href="{{ $categoria['pdf_url'] }}" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                                <a href="{{ $categoria['excel_url'] }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-file-earmark-excel"></i>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <div style="background:rgba(16,185,129,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                                <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">Productos</div>
                                <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2">{{ $categoria['total_productos'] }}</div>
                            </div>
                            <div style="background:rgba(16,185,129,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                                <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">Pedidos</div>
                                <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2">{{ $categoria['total_pedidos'] }}</div>
                            </div>
                            <div style="background:rgba(16,185,129,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                                <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">Unidades vendidas</div>
                                <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2">{{ $categoria['total_unidades'] }}</div>
                            </div>
                            <div style="background:rgba(16,185,129,.09);border-radius:.65rem;padding:.45rem .75rem;min-width:96px">
                                <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.05em;color:var(--adm-muted);font-weight:700">Ventas</div>
                                <div class="fw-bold" style="font-size:1.05rem;color:var(--adm-heading);line-height:1.2">${{ number_format($categoria['total_ventas'], 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="mt-4 alert alert-light border" style="border-radius:.9rem">
            <i class="bi bi-info-circle me-2"></i>
            Aun no hay categorias musicales registradas. Agrega categorias en el panel para ver aqui sus estadisticas de ventas.
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('mnuEstadisticas')?.classList.add('active');
</script>
@endpush
