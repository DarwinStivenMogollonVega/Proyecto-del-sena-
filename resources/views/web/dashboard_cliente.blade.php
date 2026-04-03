@extends('web.app')

@section('titulo', 'Mi Dashboard - DiscZone')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/dashboard-cliente.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 pb-5 client-dashboard-page">
    <section class="client-hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1">Mi dashboard</h1>
                <p class="mb-0 hero-subtitle">Hola {{ auth()->user()->name }}, aqui tienes un resumen visual de tus compras, pedidos, intereses y carrito actual.</p>
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
            <a href="{{ route('perfil.pedidos') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-receipt me-1"></i> Ver pedidos
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
                                            <td class="fw-semibold">#{{ $pedido->getKey() }}</td>
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

@push('scripts')
    <script>
        (function () {
            document.addEventListener('DOMContentLoaded', function () {
                try {
                    var root = document.documentElement;
                    var container = document.querySelector('.client-dashboard-page');
                    if (!container) return;

                    var authAccent = getComputedStyle(root).getPropertyValue('--auth-accent').trim();
                    var dzAccent = getComputedStyle(root).getPropertyValue('--dz-accent').trim();
                    var finalAccent = authAccent || dzAccent || '';

                    if (finalAccent) {
                        container.style.setProperty('--dz-accent', finalAccent);
                        // also set darker variant if available
                        var authAccentDark = getComputedStyle(root).getPropertyValue('--auth-accent-dark').trim();
                        if (authAccentDark) container.style.setProperty('--dz-accent-dark', authAccentDark);

                        // compute readable contrast color (light or dark) and expose as CSS var
                        function parseColorToRgb(input) {
                            if (!input) return null;
                            input = input.trim();
                            // hex
                            var hexMatch = input.match(/^#([a-f\d]{3}|[a-f\d]{6})$/i);
                            if (hexMatch) {
                                var hex = hexMatch[1];
                                if (hex.length === 3) {
                                    hex = hex.split('').map(function (c) { return c + c; }).join('');
                                }
                                var intVal = parseInt(hex, 16);
                                return [ (intVal >> 16) & 255, (intVal >> 8) & 255, intVal & 255 ];
                            }
                            // rgb(a)
                            var rgbMatch = input.match(/rgba?\(\s*([\d.]+)\s*,\s*([\d.]+)\s*,\s*([\d.]+)(?:\s*,\s*[\d.]+)?\s*\)/i);
                            if (rgbMatch) {
                                return [parseFloat(rgbMatch[1]), parseFloat(rgbMatch[2]), parseFloat(rgbMatch[3])];
                            }
                            return null;
                        }

                        function luminance(r, g, b) {
                            var a = [r, g, b].map(function (v) {
                                v = v / 255;
                                return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
                            });
                            return 0.2126 * a[0] + 0.7152 * a[1] + 0.0722 * a[2];
                        }

                        function contrastColorFor(rgb) {
                            var L = luminance(rgb[0], rgb[1], rgb[2]);
                            // WCAG-ish threshold: if background is light -> use dark text, else white
                            return L > 0.55 ? '#0f172a' : '#ffffff';
                        }

                        var rgb = parseColorToRgb(finalAccent);
                        if (rgb) {
                            container.style.setProperty('--dz-accent-contrast', contrastColorFor(rgb));
                        }

                        if (authAccentDark) {
                            var rgb2 = parseColorToRgb(authAccentDark);
                            if (rgb2) container.style.setProperty('--dz-accent-dark-contrast', contrastColorFor(rgb2));
                        }
                    }
                } catch (e) {
                    // fail silently
                }
            });
        })();
    </script>
@endpush
