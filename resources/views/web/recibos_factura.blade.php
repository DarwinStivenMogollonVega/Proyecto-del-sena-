@extends('web.app')

@section('titulo', 'Historial de facturas - DiscZone')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/recibos-factura-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 pb-5 invoice-page">
    <section class="invoice-hero" @if(!empty($heroImage)) style="--invoice-hero-image: url('{{ $heroImage }}')" @endif>
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1">Historial de facturas</h1>
                <p class="mb-0">Consulta todas tus facturas generadas automaticamente desde Mis pedidos y abre cada documento para descargar PDF.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('perfil.pedidos') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-1"></i> Volver a pedidos
                </a>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="invoice-card invoice-kpi">
                    <div class="label">Facturas totales</div>
                    <div class="value">{{ $resumen['totalRecibos'] }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="invoice-card invoice-kpi">
                    <div class="label">Monto facturado</div>
                    <div class="value">${{ number_format($resumen['montoFacturado'], 2) }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="invoice-card p-3 p-lg-4">
            <form action="{{ route('perfil.recibos') }}" method="get" class="mb-3">
                <div class="input-group">
                    <input name="texto" type="text" class="form-control" value="{{ $texto }}" placeholder="Buscar por factura, pedido o cliente">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <button type="submit" class="btn btn-dark">Buscar</button>
                    @if(!empty($texto))
                        <a href="{{ route('perfil.recibos') }}" class="btn btn-outline-secondary">Limpiar</a>
                    @endif
                </div>
            </form>

            <div class="invoice-table-wrap mt-3">
                <table class="table table-hover table-bordered invoice-table mb-0">
                    <thead>
                        <tr>
                            <th>Factura</th>
                            <th>Pedido</th>
                            <th>Emision</th>
                            <th>Estado pedido</th>
                            <th>Cliente</th>
                            <th class="text-end">Total</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registros as $reg)
                            <tr>
                                <td>{{ $reg->numero_factura }}</td>
                                <td>#{{ $reg->pedido->getKey() }}</td>
                                <td>{{ $reg->fecha_emision->format('d/m/Y H:i') }}</td>
                                <td>{{ ucfirst($reg->estado_pedido) }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $reg->cliente_nombre }}</div>
                                    <small class="text-muted">{{ $reg->cliente_email }}</small>
                                </td>
                                <td class="text-end">${{ number_format($reg->total, 2) }}</td>
                                <td>
                                    <a href="{{ route('perfil.facturas.show', $reg->getKey()) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-file-earmark-text me-1"></i> Ver factura
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No hay facturas generadas para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $registros->appends(['texto' => $texto])->links() }}
            </div>
        </div>
    </section>
</div>
@endsection
