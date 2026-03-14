@extends('web.app')

@section('titulo', 'Mi Dashboard - DiscZone')

@push('estilos')
<style>
    .client-dashboard-page {
        background:
            radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.12), transparent 30%),
            radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.09), transparent 28%),
            linear-gradient(180deg, rgba(255, 255, 255, 0.72), rgba(255, 255, 255, 0));
        border-radius: 1rem;
        padding-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .client-hero {
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

    .client-hero::after {
        content: '';
        position: absolute;
        width: 240px;
        height: 240px;
        right: -80px;
        top: -90px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
    }

    .client-hero .hero-subtitle {
        max-width: 560px;
    }

    .client-card {
        background: var(--dz-surface);
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
        height: auto;
    }

    .quick-action {
        border-radius: 0.8rem;
        font-weight: 600;
    }

    .client-section-tone-1 {
        background: linear-gradient(145deg, var(--dz-surface) 0%, #f4f8ff 100%);
        border-color: var(--dz-border);
    }

    .client-section-tone-2 {
        background: linear-gradient(145deg, var(--dz-surface) 0%, #f7f9fc 100%);
        border-color: var(--dz-border);
    }

    .client-section-tone-3 {
        background: linear-gradient(145deg, var(--dz-surface) 0%, #f3f6fb 100%);
        border-color: var(--dz-border);
    }

    .client-section-tone-4 {
        background: linear-gradient(145deg, var(--dz-surface) 0%, #f8fafd 100%);
        border-color: var(--dz-border);
    }

    .client-kpi {
        padding: 1rem;
        min-height: 128px;
    }

    .client-kpi-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.35rem;
    }

    .client-kpi-icon {
        width: 2.2rem;
        height: 2.2rem;
        border-radius: 0.65rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 23, 42, 0.08);
        color: #0f172a;
        font-size: 1rem;
    }

    .client-kpi .label {
        color: var(--dz-muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .client-kpi .value {
        color: var(--dz-heading);
        font-size: 1.55rem;
        font-weight: 700;
        line-height: 1.15;
    }

    .client-kpi .hint {
        color: var(--dz-muted);
        font-size: 0.8rem;
        margin-top: 0.35rem;
    }

    .client-table thead th {
        text-transform: uppercase;
        font-size: 0.74rem;
        letter-spacing: 0.04em;
        color: var(--dz-muted);
        font-weight: 700;
        white-space: nowrap;
    }

    .client-table td {
        white-space: nowrap;
    }

    .client-table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .client-summary-card {
        min-height: 220px;
    }

    .client-mini-card {
        min-height: 180px;
    }

    .client-frequent-list {
        max-height: 220px;
        overflow-y: auto;
        padding-right: 0.25rem;
    }

    .client-frequent-list::-webkit-scrollbar {
        width: 6px;
    }

    .client-frequent-list::-webkit-scrollbar-thumb {
        background: #b7c4d8;
        border-radius: 999px;
    }

    @media (max-width: 768px) {
        .client-table {
            min-width: 620px;
        }

        .client-hero::after {
            width: 160px;
            height: 160px;
            right: -55px;
            top: -65px;
        }

        .client-kpi,
        .client-summary-card,
        .client-mini-card {
            min-height: auto;
        }
    }

    @media (max-width: 575.98px) {
        .client-hero {
            padding: 1.25rem;
        }

        .client-table {
            min-width: 560px;
        }
    }

    .status-pill {
        border-radius: 999px;
        padding: 0.28rem 0.62rem;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .status-row {
        margin-bottom: 0.9rem;
    }

    .status-bar {
        height: 0.5rem;
        border-radius: 999px;
        background: #e5ebf5;
        overflow: hidden;
        margin-top: 0.35rem;
    }

    .status-bar > span {
        display: block;
        height: 100%;
        border-radius: 999px;
    }

    .status-pending {
        background: linear-gradient(90deg, #f59e0b, #f97316);
    }

    .status-shipped {
        background: linear-gradient(90deg, #10b981, #059669);
    }

    .status-cancelled {
        background: linear-gradient(90deg, #ef4444, #dc2626);
    }

    .category-chip {
        border: 1px solid #d7e0ee;
        border-radius: 0.85rem;
        background: linear-gradient(145deg, #ffffff, #f8fbff);
        padding: 0.7rem;
    }

    html[data-theme='dark'] .client-dashboard-page {
        background:
            radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.15), transparent 30%),
            radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.14), transparent 28%),
            linear-gradient(180deg, rgba(31, 41, 55, 0.65), rgba(17, 24, 39, 0));
    }

    html[data-theme='dark'] .client-kpi .label,
    html[data-theme='dark'] .client-kpi .hint,
    html[data-theme='dark'] .client-table thead th {
        color: #cbd5e1;
    }

    html[data-theme='dark'] .client-kpi .value,
    html[data-theme='dark'] .category-chip span {
        color: #f8fafc;
    }

    html[data-theme='dark'] .client-card {
        background: #111827;
        border-color: #334155;
        box-shadow: 0 12px 24px rgba(2, 6, 23, 0.55);
    }

    html[data-theme='dark'] .client-section-tone-1,
    html[data-theme='dark'] .client-section-tone-2,
    html[data-theme='dark'] .client-section-tone-3,
    html[data-theme='dark'] .client-section-tone-4 {
        background: linear-gradient(145deg, #111827 0%, #1f2937 100%);
        border-color: #334155;
    }

    html[data-theme='dark'] .client-kpi-icon {
        background: rgba(148, 163, 184, 0.16);
        color: #e2e8f0;
    }

    html[data-theme='dark'] .status-bar {
        background: #334155;
    }

    html[data-theme='dark'] .category-chip {
        background: linear-gradient(145deg, #1f2937, #111827);
        border-color: #334155;
    }
</style>
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 pb-5 client-dashboard-page">
    <section class="client-hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1">Mi dashboard</h1>
                <p class="mb-0 text-white-50 hero-subtitle">Hola {{ auth()->user()->name }}, aqui tienes un resumen visual de tus compras, pedidos, intereses y carrito actual.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('web.index') }}" class="btn btn-light">
                    <i class="bi bi-shop me-1"></i> Volver a la tienda
                </a>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-3">
            <a href="{{ route('carrito.mostrar') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-cart-fill me-1"></i> Ir al carrito
            </a>
            <a href="{{ route('perfil.pedidos') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-receipt me-1"></i> Ver mis pedidos
            </a>
            <a href="{{ route('perfil.recibos') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-file-earmark-text me-1"></i> Recibos factura
            </a>
            <a href="{{ route('perfil.edit') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-person-gear me-1"></i> Editar perfil
            </a>
        </div>
    </section>

    <section class="mt-4">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="client-card client-kpi client-section-tone-1">
                    <div class="client-kpi-top">
                        <div class="label">Pedidos totales</div>
                        <span class="client-kpi-icon"><i class="bi bi-bag-check"></i></span>
                    </div>
                    <div class="value">{{ $resumen['totalPedidos'] }}</div>
                    <div class="hint">Historial acumulado</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="client-card client-kpi client-section-tone-2">
                    <div class="client-kpi-top">
                        <div class="label">Gasto total</div>
                        <span class="client-kpi-icon"><i class="bi bi-wallet2"></i></span>
                    </div>
                    <div class="value">${{ number_format($resumen['gastoTotal'], 2) }}</div>
                    <div class="hint">En todas tus compras</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="client-card client-kpi client-section-tone-3">
                    <div class="client-kpi-top">
                        <div class="label">Unidades compradas</div>
                        <span class="client-kpi-icon"><i class="bi bi-vinyl"></i></span>
                    </div>
                    <div class="value">{{ $resumen['totalUnidadesCompradas'] }}</div>
                    <div class="hint">Entre todos tus pedidos</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="client-card client-kpi client-section-tone-4">
                    <div class="client-kpi-top">
                        <div class="label">Carrito actual</div>
                        <span class="client-kpi-icon"><i class="bi bi-cart3"></i></span>
                    </div>
                    <div class="value">{{ $resumen['itemsCarrito'] }} item(s)</div>
                    <div class="hint">Total: ${{ number_format($resumen['totalCarrito'], 2) }}</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="client-card client-kpi client-section-tone-2">
                    <div class="client-kpi-top">
                        <div class="label">Recibos factura</div>
                        <span class="client-kpi-icon"><i class="bi bi-file-earmark-text"></i></span>
                    </div>
                    <div class="value">{{ $resumen['recibosFactura'] }}</div>
                    <div class="hint">Compras con FE solicitada</div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="row g-3">
            <div class="col-lg-7">
                <div class="client-card client-section-tone-1 p-3 p-lg-4">
                    <h4 class="h6 fw-bold mb-3">Ultimos pedidos</h4>
                    @if($ultimosPedidos->isEmpty())
                        <p class="text-muted mb-0">Aun no tienes pedidos registrados.</p>
                    @else
                        <div class="table-responsive client-table-wrap">
                            <table class="table table-hover client-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimosPedidos as $pedido)
                                        <tr>
                                            <td class="fw-semibold">#{{ $pedido->id }}</td>
                                            <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @php
                                                    $estado = strtolower($pedido->estado);
                                                    $badgeClass = match ($estado) {
                                                        'enviado' => 'text-bg-success',
                                                        'cancelado', 'anulado' => 'text-bg-danger',
                                                        default => 'text-bg-warning'
                                                    };
                                                @endphp
                                                <span class="badge status-pill {{ $badgeClass }}">{{ ucfirst($pedido->estado) }}</span>
                                            </td>
                                            <td class="text-end fw-semibold">${{ number_format($pedido->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-5">
                <div class="client-card client-mini-card client-section-tone-2 p-3 p-lg-4 mb-3">
                    <h4 class="h6 fw-bold mb-3">Estado de pedidos</h4>
                    @php
                        $totalEstados = max(1, $resumen['pedidosPendientes'] + $resumen['pedidosEnviados'] + $resumen['pedidosCancelados']);
                    @endphp
                    <div class="status-row">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Pendientes</span>
                            <strong>{{ $resumen['pedidosPendientes'] }}</strong>
                        </div>
                        <div class="status-bar">
                            <span class="status-pending" style="width: {{ ($resumen['pedidosPendientes'] / $totalEstados) * 100 }}%"></span>
                        </div>
                    </div>
                    <div class="status-row">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Enviados</span>
                            <strong>{{ $resumen['pedidosEnviados'] }}</strong>
                        </div>
                        <div class="status-bar">
                            <span class="status-shipped" style="width: {{ ($resumen['pedidosEnviados'] / $totalEstados) * 100 }}%"></span>
                        </div>
                    </div>
                    <div class="status-row mb-0">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Cancelados/Anulados</span>
                            <strong>{{ $resumen['pedidosCancelados'] }}</strong>
                        </div>
                        <div class="status-bar">
                            <span class="status-cancelled" style="width: {{ ($resumen['pedidosCancelados'] / $totalEstados) * 100 }}%"></span>
                        </div>
                    </div>
                </div>

                <div class="client-card client-mini-card client-section-tone-3 p-3 p-lg-4">
                    <h4 class="h6 fw-bold mb-3">Productos que mas compras</h4>
                    @if($productosFrecuentes->isEmpty())
                        <p class="text-muted mb-0">Todavia no hay datos de compra para mostrar.</p>
                    @else
                        <div class="client-frequent-list">
                            @foreach($productosFrecuentes as $producto)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $producto->nombre }}</span>
                                    <span class="badge text-bg-dark">{{ $producto->total_cantidad }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="mt-3">
        <div class="client-card client-section-tone-4 p-3 p-lg-4">
            <h4 class="h6 fw-bold mb-3">Tus categorias de interes</h4>
            @if($categoriasInteres->isEmpty())
                <p class="text-muted mb-0">Aun no hay categorias suficientes para recomendarte intereses.</p>
            @else
                <div class="row g-2">
                    @foreach($categoriasInteres as $categoria)
                        <div class="col-sm-6 col-lg-3">
                            <div class="category-chip d-flex justify-content-between align-items-center">
                                <span>{{ $categoria->categoria }}</span>
                                <span class="badge text-bg-secondary">{{ $categoria->total_cantidad }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
