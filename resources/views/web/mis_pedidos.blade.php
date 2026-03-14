@extends('web.app')

@section('titulo', 'Mis pedidos - DiscZone')

@push('estilos')
<style>
    .orders-page {
        background:
            radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.12), transparent 30%),
            radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.09), transparent 28%),
            linear-gradient(180deg, rgba(255, 255, 255, 0.72), rgba(255, 255, 255, 0));
        border-radius: 1rem;
        padding-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .orders-hero {
        margin-top: 1.5rem;
        border-radius: 1rem;
        color: #fff;
        padding: 2rem;
        background:
            radial-gradient(circle at 14% 20%, rgba(245, 158, 11, 0.35), transparent 42%),
            radial-gradient(circle at 82% 15%, rgba(59, 130, 246, 0.2), transparent 35%),
            linear-gradient(130deg, #111827 0%, #7c2d12 52%, #0f172a 100%);
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.24);
        position: relative;
        overflow: hidden;
    }

    .orders-hero::after {
        content: '';
        position: absolute;
        width: 240px;
        height: 240px;
        right: -80px;
        top: -90px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
    }

    .orders-hero p {
        max-width: 620px;
    }

    .orders-card {
        background: var(--dz-surface);
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
    }

    .orders-kpi {
        padding: 1rem;
        min-height: 118px;
    }

    .orders-kpi .label {
        color: var(--dz-muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .orders-kpi .value {
        color: var(--dz-heading);
        font-size: 1.45rem;
        font-weight: 700;
        line-height: 1.15;
    }

    .orders-table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .orders-table thead th {
        text-transform: uppercase;
        font-size: 0.74rem;
        letter-spacing: 0.04em;
        color: var(--dz-muted);
        font-weight: 700;
        white-space: nowrap;
        background: var(--dz-page-grad-1);
    }

    .orders-table td {
        white-space: nowrap;
        vertical-align: middle;
    }

    .status-pill {
        border-radius: 999px;
        padding: 0.28rem 0.62rem;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .detail-box {
        background: var(--dz-page-grad-1);
        border: 1px solid var(--dz-border);
        border-radius: 0.85rem;
        padding: 0.9rem;
        color: var(--dz-text);
    }

    .quick-action {
        border-radius: 0.8rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .orders-table {
            min-width: 680px;
        }

        .orders-hero::after {
            width: 160px;
            height: 160px;
            right: -55px;
            top: -65px;
        }

        .orders-kpi {
            min-height: auto;
        }
    }

    @media (max-width: 575.98px) {
        .orders-hero {
            padding: 1.25rem;
        }

        .orders-table {
            min-width: 560px;
        }
    }

    html[data-theme='dark'] .orders-page {
        background:
            radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.15), transparent 30%),
            radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.14), transparent 28%),
            linear-gradient(180deg, rgba(31, 41, 55, 0.65), rgba(17, 24, 39, 0));
    }

    html[data-theme='dark'] .orders-card {
        background: #111827;
        border-color: #334155;
        box-shadow: 0 12px 24px rgba(2, 6, 23, 0.55);
    }

    html[data-theme='dark'] .orders-kpi .label,
    html[data-theme='dark'] .orders-table thead th,
    html[data-theme='dark'] .text-muted {
        color: #cbd5e1 !important;
    }

    html[data-theme='dark'] .orders-kpi .value,
    html[data-theme='dark'] .detail-box,
    html[data-theme='dark'] .orders-table tbody td {
        color: #f8fafc;
    }

    html[data-theme='dark'] .orders-table thead th {
        background: #1f2937;
        border-color: #334155;
    }

    html[data-theme='dark'] .orders-table tbody tr,
    html[data-theme='dark'] .orders-table tbody td,
    html[data-theme='dark'] .orders-table {
        border-color: #334155;
    }

    html[data-theme='dark'] .orders-table.table-bordered > :not(caption) > * > * {
        border-color: #334155;
    }

    html[data-theme='dark'] .detail-box {
        background: #1f2937;
        border-color: #334155;
    }

    html[data-theme='dark'] .orders-card .input-group-text {
        background: #1f2937 !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
</style>
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 pb-5 orders-page">
    <section class="orders-hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1">Mis pedidos</h1>
                <p class="mb-0 text-white-50">Consulta tu historial, revisa el estado y explora el detalle completo de cada compra.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('web.index') }}" class="btn btn-light quick-action">
                    <i class="bi bi-shop me-1"></i> Ir a la tienda
                </a>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-3">
            <a href="{{ route('carrito.mostrar') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-cart-fill me-1"></i> Ver carrito
            </a>
            <a href="{{ route('cliente.dashboard') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-bar-chart-line me-1"></i> Mi dashboard
            </a>
            <a href="{{ route('perfil.recibos') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-file-earmark-text me-1"></i> Historial facturas
            </a>
            <a href="{{ route('perfil.edit') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-person-gear me-1"></i> Editar perfil
            </a>
        </div>
    </section>

    <section class="mt-4">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="orders-card orders-kpi">
                    <div class="label">Pedidos totales</div>
                    <div class="value">{{ $resumen['totalPedidos'] }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="orders-card orders-kpi">
                    <div class="label">Gasto total</div>
                    <div class="value">${{ number_format($resumen['gastoTotal'], 2) }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="orders-card orders-kpi">
                    <div class="label">Pendientes</div>
                    <div class="value">{{ $resumen['pendientes'] }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="orders-card orders-kpi">
                    <div class="label">Enviados</div>
                    <div class="value">{{ $resumen['enviados'] }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="orders-card orders-kpi">
                    <div class="label">Cancelados</div>
                    <div class="value">{{ $resumen['cancelados'] }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="orders-card orders-kpi">
                    <div class="label">Facturas generadas</div>
                    <div class="value">{{ $resumen['conFactura'] }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="orders-card p-3 p-lg-4">
            <form action="{{ route('perfil.pedidos') }}" method="get" class="mb-3">
                <div class="input-group">
                    <input name="texto" type="text" class="form-control" value="{{ $texto }}" placeholder="Buscar por estado o numero de pedido">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <button type="submit" class="btn btn-dark">Buscar</button>
                    @if(!empty($texto))
                        <a href="{{ route('perfil.pedidos') }}" class="btn btn-outline-secondary">Limpiar</a>
                    @endif
                </div>
            </form>

            @if(Session::has('mensaje'))
                <div class="alert alert-info alert-dismissible fade show mt-2">
                    {{ Session::get('mensaje') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            @endif

            <div class="orders-table-wrap mt-3">
                <table class="table table-hover table-bordered orders-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 120px">Opciones</th>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Metodo pago</th>
                            <th>Comprobante</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Factura</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($registros) <= 0)
                            <tr>
                                <td colspan="9">No hay registros que coincidan con la busqueda</td>
                            </tr>
                        @else
                            @foreach($registros as $reg)
                                <tr>
                                    <td>
                                        @if(auth()->user()->can('pedido-cancel'))
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-estado-{{ $reg->id }}">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        @else
                                            <span class="text-muted small">Sin acciones</span>
                                        @endif
                                    </td>
                                    <td>#{{ $reg->id }}</td>
                                    <td>{{ $reg->created_at->format('d/m/Y') }}</td>
                                    <td>{{ ucfirst($reg->metodo_pago ?? 'N/A') }}</td>
                                    <td>
                                        @if($reg->comprobante_pago)
                                            <a href="{{ asset('storage/' . $reg->comprobante_pago) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                Ver captura
                                            </a>
                                        @else
                                            <span class="text-muted small">Sin archivo</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($reg->total, 2) }}</td>
                                    <td>
                                        @php
                                            $colores = [
                                                'pendiente' => 'bg-warning text-dark',
                                                'enviado' => 'bg-success',
                                                'anulado' => 'bg-danger',
                                                'cancelado' => 'bg-secondary',
                                            ];
                                        @endphp
                                        <span class="badge status-pill {{ $colores[$reg->estado] ?? 'bg-dark' }}">{{ ucfirst($reg->estado) }}</span>
                                    </td>
                                    <td>
                                        @if($reg->factura)
                                            <a href="{{ route('perfil.facturas.show', $reg->factura->id) }}" class="btn btn-sm btn-outline-primary">
                                                Ver factura
                                            </a>
                                        @else
                                            <a href="{{ route('perfil.recibos.show', $reg->id) }}" class="btn btn-sm btn-primary">
                                                Generar factura
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-{{ $reg->id }}">
                                            Ver detalles
                                        </button>
                                    </td>
                                </tr>
                                <tr class="collapse" id="detalles-{{ $reg->id }}">
                                    <td colspan="9">
                                        <div class="detail-box mb-3">
                                            <strong>Datos de contacto:</strong>
                                            {{ $reg->nombre ?? '-' }} | {{ $reg->email ?? '-' }} | {{ $reg->telefono ?? '-' }}
                                            <br>
                                            <strong>Direccion:</strong> {{ $reg->direccion ?? '-' }}
                                            @if($reg->requiere_factura_electronica)
                                                <br>
                                                <strong>Factura electronica:</strong>
                                                {{ strtoupper($reg->tipo_documento ?? '-') }} {{ $reg->numero_documento ?? '-' }} | {{ $reg->razon_social ?? '-' }} | {{ $reg->correo_factura ?? '-' }}
                                            @endif
                                        </div>
                                        <table class="table table-sm table-striped mb-0">
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
                                                            <img src="{{ asset('uploads/productos/' . $detalle->producto->imagen) }}" class="img-fluid rounded" style="width: 70px; height: 70px; object-fit: cover;" alt="{{ $detalle->producto->nombre }}">
                                                        </td>
                                                        <td>{{ $detalle->cantidad }}</td>
                                                        <td>${{ number_format($detalle->precio, 2) }}</td>
                                                        <td>${{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @if(auth()->user()->can('pedido-cancel'))
                                    @include('pedido.state')
                                @endif
                            @endforeach
                        @endif
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
