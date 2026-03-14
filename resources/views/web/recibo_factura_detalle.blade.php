@extends('web.app')

@section('titulo', 'Factura ' . $factura->numero_factura . ' - DiscZone')

@push('estilos')
<style>
    .receipt-shell {
        max-width: 980px;
        margin: 2rem auto 3rem;
    }

    .receipt-card {
        background: var(--dz-surface);
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.1);
        overflow: hidden;
    }

    .receipt-head {
        padding: 1.5rem;
        color: #fff;
        background: linear-gradient(130deg, #111827 0%, #7c2d12 52%, #0f172a 100%);
    }

    .receipt-block {
        border: 1px solid var(--dz-border);
        border-radius: 0.8rem;
        padding: 1rem;
        background: var(--dz-page-grad-1);
    }

    .receipt-table td,
    .receipt-table th {
        vertical-align: middle;
    }

    .receipt-total {
        font-size: 1.15rem;
    }

    html[data-theme='dark'] .receipt-card {
        background: #111827;
        border-color: #334155;
        box-shadow: 0 12px 24px rgba(2, 6, 23, 0.55);
    }

    html[data-theme='dark'] .receipt-block {
        background: #1f2937;
        border-color: #334155;
    }

    @media print {
        .receipt-no-print {
            display: none !important;
        }

        body {
            background: #fff !important;
        }

        .receipt-shell {
            margin: 0;
            max-width: 100%;
        }

        .receipt-card {
            box-shadow: none;
            border-color: #d1d5db;
        }
    }
</style>
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 receipt-shell">
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3 receipt-no-print">
        <a href="{{ route('perfil.recibos') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i> Volver a facturas
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('perfil.facturas.pdf', $factura->id) }}" class="btn btn-dark">
                <i class="bi bi-file-earmark-pdf me-1"></i> Descargar PDF
            </a>
            <button type="button" class="btn btn-outline-dark" onclick="window.print()">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
        </div>
    </div>

    <div class="receipt-card">
        <div class="receipt-head">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <h1 class="h4 text-white mb-1">Factura electronica</h1>
                    <p class="mb-0 text-white-50">{{ $factura->numero_factura }} · Emision {{ $factura->fecha_emision->format('d/m/Y H:i') }}</p>
                </div>
                <span class="badge text-bg-light">Estado pedido: {{ ucfirst($factura->estado_pedido) }}</span>
            </div>
        </div>

        <div class="p-3 p-lg-4">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="receipt-block h-100">
                        <h2 class="h6 fw-bold mb-2">Cliente</h2>
                        <div><strong>Nombre:</strong> {{ $factura->cliente_nombre }}</div>
                        <div><strong>Email:</strong> {{ $factura->cliente_email }}</div>
                        <div><strong>Direccion:</strong> {{ $factura->cliente_direccion ?: '-' }}</div>
                        <div><strong>Identificacion:</strong> {{ $factura->cliente_identificacion ?: '-' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="receipt-block h-100">
                        <h2 class="h6 fw-bold mb-2">Pedido asociado</h2>
                        <div><strong>ID Pedido:</strong> #{{ $factura->pedido->id }}</div>
                        <div><strong>Fecha pedido:</strong> {{ $factura->pedido->created_at->format('d/m/Y H:i') }}</div>
                        <div><strong>Metodo de pago:</strong> {{ ucfirst($factura->pedido->metodo_pago ?: '-') }}</div>
                        <div><strong>Estado:</strong> {{ ucfirst($factura->estado_pedido) }}</div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped receipt-table mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio unitario</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factura->pedido->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                <td class="text-end">${{ number_format($detalle->precio, 2) }}</td>
                                <td class="text-end">${{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Subtotal</th>
                            <th class="text-end">${{ number_format($factura->subtotal, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Impuestos</th>
                            <th class="text-end">${{ number_format($factura->impuestos, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end receipt-total">Total final</th>
                            <th class="text-end receipt-total">${{ number_format($factura->total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
