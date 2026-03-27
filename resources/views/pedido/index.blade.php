@extends('plantilla.app')
@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Pedidos</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Historial de pedidos realizados</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('admin.pedidos') }}" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" placeholder="Buscar por usuario, id o factura">
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
                                <th style="width: 150px">Acciones</th>
                                <th style="width: 20px">ID</th>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Factura</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedidos as $reg)
                                <tr>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modal-estado-{{ $reg->getKey() }}" title="Cambiar estado"><i class="bi bi-arrow-repeat"></i></button>
                                        </div>
                                    </td>
                                    <td>{{ $reg->getKey() }}</td>
                                    <td>{{ $reg->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $reg->user->name ?? '-' }}</td>
                                    <td>
                                        @if($reg->requiere_factura_electronica)
                                            <span class="badge panel-badge-warning">FE</span>
                                            <div class="small text-muted mt-1">{{ strtoupper($reg->tipo_documento ?? '-') }} {{ $reg->numero_documento ?? '' }}</div>
                                        @else
                                            <span class="text-muted small">No</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($reg->total, 2) }}</td>
                                    <td>
                                        @php
                                            $badgeClass = [
                                                'pendiente' => 'panel-badge-warning',
                                                'enviado' => 'panel-badge-success',
                                                'anulado' => 'panel-badge-muted',
                                                'cancelado' => 'panel-badge-muted',
                                            ][$reg->estado] ?? 'panel-badge-muted';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($reg->estado) }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-{{ $reg->getKey() }}">Ver detalles</button>
                                    </td>
                                </tr>
                                <tr class="collapse" id="detalles-{{ $reg->getKey() }}">
                                    <td colspan="8">
                                        @if($reg->requiere_factura_electronica)
                                            <div class="alert alert-light border mb-3">
                                                <strong>Datos de factura:</strong>
                                                {{ $reg->razon_social ?? '-' }} | {{ strtoupper($reg->tipo_documento ?? '-') }} {{ $reg->numero_documento ?? '' }} | {{ $reg->correo_factura ?? '-' }}
                                            </div>
                                        @endif
                                        <table class="table table-sm table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Imagen</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reg->detalles as $detalle)
                                                <tr>
                                                    <td>{{ $detalle->producto->nombre }}</td>
                                                    <td>
                                                        <img src="{{ asset('uploads/productos/' . $detalle->producto->imagen ) }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $detalle->producto->nombre }}">
                                                    </td>
                                                    <td>{{ $detalle->cantidad }}</td>
                                                    <td>{{ number_format($detalle->precio, 2) }}</td>
                                                    <td>{{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @include('pedido.state')
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox me-2"></i>No hay registros que coincidan con la búsqueda</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando {{ $pedidos->count() }} de {{ $pedidos->total() }} pedidos</div>
                <div>{{ $pedidos->appends(['texto' => $texto])->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('mnuPedidos').classList.add('active');
document.getElementById('mnuComercial')?.classList.add('menu-open');
document.getElementById('mnuComercialLink')?.classList.add('active');
</script>
@endpush