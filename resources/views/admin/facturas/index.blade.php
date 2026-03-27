@extends('plantilla.app')

@section('contenido')

<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Todas las Facturas</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Listado de facturas generadas</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('admin.facturas.index') }}" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" placeholder="Buscar por cliente, email o id">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        @if(Session::has('mensaje'))
        <div class="alert alert-info alert-dismissible fade show mt-2">
            {{ Session::get('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
        @endif

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width:900px">
                        <thead>
                            <tr>
                                <th class="px-3">#</th>
                                <th>Cliente</th>
                                <th>Documento</th>
                                <th>Razón social</th>
                                <th>Correo FE</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th style="width: 140px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registros as $reg)
                                <tr>
                                    <td>{{ $reg->getKey() }}</td>
                                    <td>{{ $reg->user->name ?? $reg->nombre }}</td>
                                    <td>{{ $reg->email }}</td>
                                    <td>{{ strtoupper($reg->tipo_documento ?? '-') }} {{ $reg->numero_documento ?? '' }}</td>
                                    <td>{{ $reg->razon_social ?? '-' }}</td>
                                    <td class="fw-bold">${{ number_format($reg->total, 2) }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($reg->estado) {
                                                'pagada' => 'panel-badge-success',
                                                'pendiente' => 'panel-badge-warning',
                                                'anulada' => 'panel-badge-muted',
                                                default => 'panel-badge-muted',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($reg->estado) }}</span>
                                    </td>
                                    <td>{{ $reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.facturas.edit', $reg->getKey()) }}" class="btn btn-sm btn-outline-primary">Ver detalles</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox me-2"></i>Sin facturas registradas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando {{ $registros->count() }} de {{ $registros->total() }} facturas</div>
                <div>{{ $registros->appends(['texto' => $texto])->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('mnuFacturas')?.classList.add('active');
document.getElementById('mnuComercial')?.classList.add('menu-open');
document.getElementById('mnuComercialLink')?.classList.add('active');
</script>
@endpush