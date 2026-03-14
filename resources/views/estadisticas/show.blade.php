@extends('plantilla.app')

@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge rounded-pill" style="background:rgba(29,78,216,.12);color:#1d4ed8">
                        <i class="bi {{ $categoriaActual['icono'] ?? 'bi-graph-up-arrow' }} me-1"></i>
                        Seccion actual
                    </span>
                    <span class="small fw-semibold" style="color:var(--adm-muted)">{{ $categoriaActual['titulo'] ?? ucfirst($categoria) }}</span>
                </div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">{{ $titulo }}</h4>
                <p class="mb-0" style="color:var(--adm-muted);font-size:.9rem">{{ $descripcion }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('estadisticas.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-grid me-1"></i>Categorias
                </a>
                <a href="{{ route('estadisticas.export.pdf', ['categoria' => $categoria]) }}" class="btn btn-sm btn-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                </a>
                <a href="{{ route('estadisticas.export.excel', ['categoria' => $categoria]) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i>Excel
                </a>
            </div>
        </div>

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-body py-3">
                <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                    <div>
                        <div class="small fw-semibold text-uppercase" style="color:var(--adm-muted);letter-spacing:.06em">Navegacion de secciones</div>
                        <div class="small" style="color:var(--adm-muted)">Cambia entre ventas, productos, clientes y usuarios sin volver al listado principal.</div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($categorias as $item)
                        <a href="{{ $item['detalle_url'] }}"
                           class="btn btn-sm {{ $item['slug'] === $categoria ? 'btn-primary' : 'btn-outline-secondary' }}">
                            <i class="bi {{ $item['icono'] }} me-1"></i>{{ $item['titulo'] }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            @foreach($summary as $item)
            <div class="col-6 col-lg-3">
                <div class="card h-100" style="border-radius:.9rem">
                    <div class="card-body">
                        <small style="color:var(--adm-muted)">{{ $item['label'] }}</small>
                        <div class="h4 fw-bold mb-0" style="color:var(--adm-heading)">{{ $item['value'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if(!empty($indicadores) && count($indicadores) > 0)
        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Indicadores visuales de rendimiento</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($indicadores as $ind)
                    <div class="col-12 col-lg-6">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                <span class="fw-semibold" style="color:var(--adm-heading)">{{ $ind['label'] }}</span>
                                <span class="badge rounded-pill" style="background:rgba(29,78,216,.12);color:#1d4ed8">{{ $ind['ventas'] }} uds</span>
                            </div>
                            <div class="progress mb-2" style="height:7px;border-radius:999px">
                                <div class="progress-bar" role="progressbar" style="width:{{ $ind['percent'] }}%"></div>
                            </div>
                            <small style="color:var(--adm-muted)">Ingresos: ${{ number_format((float) ($ind['ingresos'] ?? 0), 2) }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="card" style="border-radius:1rem">
            <div class="card-header py-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Detalle de {{ $categoriaActual['titulo'] ?? ucfirst($categoria) }}</h6>
                    <span class="small fw-semibold" style="color:var(--adm-muted)">{{ count($rows) }} registros</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                @foreach($headings as $heading)
                                <th>{{ $heading }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $row)
                            <tr>
                                @foreach($row as $value)
                                <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($headings) }}" class="text-center py-4">
                                    No hay datos disponibles para la seccion {{ $categoriaActual['titulo'] ?? ucfirst($categoria) }}.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('mnuEstadisticas')?.classList.add('active');
</script>
@endpush
