@extends('web.app')

@section('titulo', 'Historial de facturas - DiscZone')

@push('estilos')
<style>
    .invoice-page {
        background:
            radial-gradient(circle at 10% 8%, rgba(245, 158, 11, 0.12), transparent 32%),
            radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.08), transparent 30%),
            linear-gradient(180deg, rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0));
        border-radius: 1rem;
        padding-bottom: 2rem;
    }

    .invoice-hero {
        margin-top: 1.5rem;
        border-radius: 1rem;
        color: #fff;
        padding: 1.8rem;
        background:
            radial-gradient(circle at 12% 20%, rgba(245, 158, 11, 0.35), transparent 42%),
            radial-gradient(circle at 82% 15%, rgba(59, 130, 246, 0.22), transparent 35%),
            linear-gradient(130deg, #111827 0%, #7c2d12 52%, #0f172a 100%);
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.24);
    }

    .invoice-card {
        background: var(--dz-surface);
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
    }

    .invoice-kpi {
        padding: 1rem;
        min-height: 110px;
    }

    .invoice-kpi .label {
        color: var(--dz-muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .invoice-kpi .value {
        color: var(--dz-heading);
        font-size: 1.45rem;
        font-weight: 700;
        line-height: 1.15;
    }

    .invoice-table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .invoice-table thead th {
        text-transform: uppercase;
        font-size: 0.74rem;
        letter-spacing: 0.04em;
        color: var(--dz-muted);
        font-weight: 700;
        white-space: nowrap;
        background: var(--dz-page-grad-1);
    }

    .invoice-table td {
        white-space: nowrap;
        vertical-align: middle;
    }

    html[data-theme='dark'] .invoice-page {
        background:
            radial-gradient(circle at 10% 8%, rgba(245, 158, 11, 0.15), transparent 32%),
            radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.13), transparent 30%),
            linear-gradient(180deg, rgba(31, 41, 55, 0.65), rgba(17, 24, 39, 0));
    }

    html[data-theme='dark'] .invoice-card {
        background: #111827;
        border-color: #334155;
        box-shadow: 0 12px 24px rgba(2, 6, 23, 0.55);
    }

    html[data-theme='dark'] .invoice-kpi .label,
    html[data-theme='dark'] .invoice-table thead th,
    html[data-theme='dark'] .text-muted {
        color: #cbd5e1 !important;
    }

    html[data-theme='dark'] .invoice-kpi .value,
    html[data-theme='dark'] .invoice-table tbody td {
        color: #f8fafc;
    }

    @media (max-width: 768px) {
        .invoice-table {
            min-width: 860px;
        }
    }
</style>
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 pb-5 invoice-page">
    <section class="invoice-hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1">Historial de facturas</h1>
                <p class="mb-0 text-white-50">Consulta todas tus facturas generadas automaticamente desde Mis pedidos y abre cada documento para descargar PDF.</p>
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
                                <td>#{{ $reg->pedido->id }}</td>
                                <td>{{ $reg->fecha_emision->format('d/m/Y H:i') }}</td>
                                <td>{{ ucfirst($reg->estado_pedido) }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $reg->cliente_nombre }}</div>
                                    <small class="text-muted">{{ $reg->cliente_email }}</small>
                                </td>
                                <td class="text-end">${{ number_format($reg->total, 2) }}</td>
                                <td>
                                    <a href="{{ route('perfil.facturas.show', $reg->id) }}" class="btn btn-sm btn-primary">
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
