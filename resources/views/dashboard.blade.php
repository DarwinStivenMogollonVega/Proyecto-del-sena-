@extends('plantilla.app')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/dashboard-section.css') }}">
@endpush

@section('contenido')
<div class="app-content py-3">
<div class="container-fluid">

    {{-- Session flash --}}
    @if(Session::has('mensaje'))
        <div class="alert alert-info alert-dismissible fade show mb-3">
            {{ Session::get('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ── Page Header ─────────────────────────────────────────── --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">
                <i class="bi bi-speedometer2 me-2" style="color:var(--adm-accent)"></i>Panel de Control
            </h4>
            <p class="mb-0" style="color:var(--adm-muted);font-size:.88rem">
                Resumen general de actividad &middot; {{ now()->format('d \d\e F \d\e Y') }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('estadisticas.index') }}" class="btn btn-sm btn-outline-primary px-3">
                <i class="bi bi-bar-chart-line-fill me-1"></i>Estadísticas
            </a>
            <a href="{{ route('admin.pedidos') }}" class="btn btn-sm btn-primary px-3">
                <i class="bi bi-list-check me-1"></i>Ver Pedidos
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- ROW 1 – Main Stats                                         --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-3">

        {{-- Usuarios --}}
        <div class="col-6 col-xl-3">
            <div class="stat-card p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-blue-soft">
                        <i class="bi bi-people-fill text-blue"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['totalUsuarios'] }}</div>
                        <div class="stat-label">Usuarios</div>
                        <small class="text-green fw-semibold">{{ $stats['usuariosActivos'] }} activos</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pedidos --}}
        <div class="col-6 col-xl-3">
            <div class="stat-card p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-orange-soft">
                        <i class="bi bi-bag-check-fill text-orange"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['totalPedidos'] }}</div>
                        <div class="stat-label">Pedidos Totales</div>
                        <small class="text-amber fw-semibold">{{ $stats['pedidosPendientes'] }} pendientes</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ingresos --}}
        <div class="col-6 col-xl-3">
            <div class="stat-card p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-green-soft">
                        <i class="bi bi-cash-stack text-green"></i>
                    </div>
                    <div>
                        <div class="stat-value">${{ number_format($stats['ingresoTotal'], 0, '.', ',') }}</div>
                        <div class="stat-label">Ingresos Totales</div>
                        <small class="text-green fw-semibold">{{ $stats['pedidosEntregados'] }} entregados</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Productos --}}
        <div class="col-6 col-xl-3">
            <div class="stat-card p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-purple-soft">
                        <i class="bi bi-vinyl-fill text-purple"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['totalProductos'] }}</div>
                        <div class="stat-label">Productos</div>
                        @if($stats['stockBajo'] > 0)
                            <small class="text-red fw-semibold"><i class="bi bi-exclamation-triangle-fill"></i> {{ $stats['stockBajo'] }} pocas unidades</small>
                        @else
                            <small class="text-green fw-semibold"><i class="bi bi-check-circle-fill"></i> Stock OK</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- ROW 2 – Order Status Quick-Cards                           --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        @php
            $statusCards = [
                ['label'=>'Pendientes',  'val'=>$stats['pedidosPendientes'],  'icon'=>'bi-clock-fill',          'bg'=>'bg-amber-soft',  'txt'=>'text-amber'],
                ['label'=>'Enviados',    'val'=>$stats['pedidosEnviados'],    'icon'=>'bi-truck',                'bg'=>'bg-blue-soft',   'txt'=>'text-blue'],
                ['label'=>'Entregados',  'val'=>$stats['pedidosEntregados'],  'icon'=>'bi-check2-circle',        'bg'=>'bg-green-soft',  'txt'=>'text-green'],
                ['label'=>'Cancelados',  'val'=>$stats['pedidosCancelados'],  'icon'=>'bi-x-circle-fill',        'bg'=>'bg-red-soft',    'txt'=>'text-red'],
            ];
        @endphp
        @foreach($statusCards as $sc)
        <div class="col-6 col-lg-3">
            <div class="stat-card p-3 d-flex align-items-center gap-3">
                <div class="stat-icon {{ $sc['bg'] }}">
                    <i class="bi {{ $sc['icon'] }} {{ $sc['txt'] }}"></i>
                </div>
                <div>
                    <div class="stat-value" style="font-size:1.3rem">{{ $sc['val'] }}</div>
                    <div class="stat-label">{{ $sc['label'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- ROW 2.5 – Proveedores (resumen rapido)                     --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card" style="border-radius:1rem">
                <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">
                        <i class="bi bi-truck-front-fill me-2" style="color:#f97316"></i>Rendimiento de Proveedores
                    </h6>
                    <a href="{{ route('estadisticas.show', ['categoria' => 'proveedores']) }}" class="btn btn-sm btn-outline-primary">
                        Ver analisis completo <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-2 mb-3">
                        <div class="col-6 col-xl-2">
                            <div class="stat-card p-3 h-100">
                                <div class="stat-label">Proveedores</div>
                                <div class="stat-value" style="font-size:1.35rem">{{ $proveedoresResumen['total_proveedores'] ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-xl-2">
                            <div class="stat-card p-3 h-100">
                                <div class="stat-label">Productos asociados</div>
                                <div class="stat-value" style="font-size:1.35rem">{{ $proveedoresResumen['total_productos'] ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-xl-2">
                            <div class="stat-card p-3 h-100">
                                <div class="stat-label">Unidades vendidas</div>
                                <div class="stat-value" style="font-size:1.35rem">{{ $proveedoresResumen['total_vendidos'] ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-xl-3">
                            <div class="stat-card p-3 h-100">
                                <div class="stat-label">Top por ventas</div>
                                <div class="fw-bold" style="font-size:1rem;color:var(--adm-heading)">{{ $proveedoresResumen['top_ventas_nombre'] ?? 'Sin datos' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-3">
                            <div class="stat-card p-3 h-100">
                                <div class="stat-label">Top por productos</div>
                                <div class="fw-bold" style="font-size:1rem;color:var(--adm-heading)">{{ $proveedoresResumen['top_productos_nombre'] ?? 'Sin datos' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:.85rem">
                            <thead>
                                <tr>
                                    <th>Proveedor</th>
                                    <th class="text-center">Productos</th>
                                    <th class="text-center">Vendidos</th>
                                    <th class="text-end">Ingresos</th>
                                    <th style="width:28%">Indicador</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $maxProv = max(1, (int) $proveedoresTop->max('total_vendidos')); @endphp
                                @forelse($proveedoresTop as $prov)
                                <tr>
                                    <td class="fw-semibold">{{ $prov['proveedor'] }}</td>
                                    <td class="text-center">{{ $prov['total_productos'] }}</td>
                                    <td class="text-center">{{ $prov['total_vendidos'] }}</td>
                                    <td class="text-end fw-semibold">${{ number_format((float) $prov['ingresos'], 2) }}</td>
                                    <td>
                                        <div class="prod-bar">
                                            <div class="prod-bar-fill" style="width:{{ round(($prov['total_vendidos'] / $maxProv) * 100) }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3" style="color:var(--adm-muted)">
                                        Sin proveedores con ventas registradas
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

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- ROW 3 – Chart + Recent Orders                              --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- Donut Chart --}}
        <div class="col-md-4 col-lg-4">
            <div class="card h-100" style="border-radius:1rem">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">
                        <i class="bi bi-pie-chart-fill me-2" style="color:var(--adm-accent)"></i>Pedidos por Estado
                    </h6>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    @if($stats['totalPedidos'] > 0)
                        <div style="position:relative;width:100%;max-width:240px">
                            <canvas id="chartEstados" height="240"></canvas>
                        </div>
                    @else
                        <div class="text-center py-4" style="color:var(--adm-muted)">
                            <i class="bi bi-inbox" style="font-size:2.5rem;opacity:.4"></i>
                            <p class="mt-2 mb-0 small">Sin pedidos aún</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="col-md-8 col-lg-8">
            <div class="card h-100" style="border-radius:1rem">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">
                        <i class="bi bi-clock-history me-2" style="color:var(--adm-accent)"></i>Últimos Pedidos
                    </h6>
                    <a href="{{ route('admin.pedidos') }}" class="btn btn-sm btn-outline-primary px-3" style="font-size:.78rem">
                        Ver todos <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:.85rem">
                            <thead>
                                <tr>
                                    <th class="px-3">#</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosPedidos as $pedido)
                                <tr>
                                    <td class="px-3 fw-semibold">{{ $pedido->getKey() }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $pedido->user->name ?? $pedido->nombre }}</div>
                                        <small style="color:var(--adm-muted)">{{ $pedido->user->email ?? $pedido->email }}</small>
                                    </td>
                                    <td class="fw-bold">${{ number_format($pedido->total, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $pedido->estado }} rounded-pill px-2 py-1" style="font-size:.75rem">
                                            {{ ucfirst($pedido->estado) }}
                                        </span>
                                    </td>
                                    <td style="color:var(--adm-muted)">{{ $pedido->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4" style="color:var(--adm-muted)">
                                        <i class="bi bi-inbox me-2"></i>Sin pedidos registrados
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

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- ROW 4 – Top Products + Top Customers                       --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- Top Products --}}
        <div class="col-md-6">
            <div class="card h-100" style="border-radius:1rem">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">
                        <i class="bi bi-trophy-fill me-2 text-amber"></i>Productos Más Vendidos
                    </h6>
                </div>
                <div class="card-body">
                    @php $maxVendido = $topProductos->max('total_vendido') ?: 1; @endphp
                    @forelse($topProductos as $i => $prod)
                    <div class="d-flex align-items-center gap-3 {{ !$loop->last ? 'mb-3' : '' }}">
                        <span class="fw-bold" style="width:20px;color:var(--adm-muted);font-size:.85rem">{{ $i+1 }}</span>
                        <div class="flex-grow-1" style="min-width:0">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold text-truncate me-2" style="font-size:.88rem">{{ $prod->nombre }}</span>
                                <span class="fw-bold text-nowrap" style="font-size:.82rem;color:var(--adm-accent)">{{ $prod->total_vendido }} uds</span>
                            </div>
                            <div class="prod-bar">
                                <div class="prod-bar-fill" style="width:{{ round($prod->total_vendido / $maxVendido * 100) }}%"></div>
                            </div>
                            <small style="color:var(--adm-muted)">${{ number_format($prod->ingreso, 2) }} generados</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-3" style="color:var(--adm-muted)">
                        <i class="bi bi-bar-chart me-2"></i>Sin ventas registradas
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Top Customers --}}
        <div class="col-md-6">
            <div class="card h-100" style="border-radius:1rem">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">
                        <i class="bi bi-star-fill me-2 text-amber"></i>Clientes Más Activos
                    </h6>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-primary px-3" style="font-size:.78rem">
                        Gestionar <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:.85rem">
                            <thead>
                                <tr>
                                    <th class="px-3">Cliente</th>
                                    <th class="text-center">Pedidos</th>
                                    <th class="text-end px-3">Gastado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topClientes as $cliente)
                                <tr>
                                    <td class="px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            @php
                                                $colors = ['bg-blue-soft text-blue','bg-green-soft text-green','bg-purple-soft text-purple','bg-orange-soft text-orange','bg-red-soft text-red'];
                                                $cl = $colors[$loop->index % count($colors)];
                                            @endphp
                                            <div class="avatar-circle {{ $cl }}">{{ strtoupper(substr($cliente->name,0,1)) }}</div>
                                            <div>
                                                <div class="fw-semibold">{{ $cliente->name }}</div>
                                                <small style="color:var(--adm-muted)">{{ $cliente->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-blue-soft text-blue rounded-pill">{{ $cliente->total_pedidos }}</span>
                                    </td>
                                    <td class="text-end px-3 fw-bold text-green">${{ number_format($cliente->total_gastado, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3" style="color:var(--adm-muted)">
                                        Sin compras registradas
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
    
    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- ROW 4.5 – Gestor de Clientes (vista embebida en dashboard)   --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card" style="border-radius:1rem">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">
                        <i class="bi bi-people-fill me-2" style="color:var(--adm-accent)"></i>Gestor de Clientes
                    </h6>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-sm btn-outline-primary">Ver todos &nbsp;<i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:.88rem">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th class="text-center">Compras</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrosClientes as $reg)
                                <tr>
                                    <td class="fw-semibold">{{ $reg->getKey() }}</td>
                                    <td>{{ $reg->name }}</td>
                                    <td>{{ $reg->email }}</td>
                                    <td class="text-center">{{ $reg->pedidos_count }}</td>
                                    <td>
                                        <span class="badge {{ $reg->activo ? 'bg-success' : 'bg-secondary' }}">{{ $reg->activo ? 'Activo' : 'Inactivo' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.clientes.show', $reg->getKey()) }}" class="btn btn-sm btn-primary">Ver</a>
                                        <a href="{{ route('usuarios.edit', $reg->getKey()) }}" class="btn btn-sm btn-outline-info">Editar</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3" style="color:var(--adm-muted)">No hay clientes para mostrar</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- ROW 5 – Recent Reviews + Recent Users                      --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- Recent Reviews --}}
        <div class="col-lg-8">
            <div class="card h-100" style="border-radius:1rem">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">
                        <i class="bi bi-chat-quote-fill me-2" style="color:var(--adm-accent)"></i>Últimas Reseñas
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:.84rem">
                            <thead>
                                <tr>
                                    <th class="px-3">Producto</th>
                                    <th>Usuario</th>
                                    <th>Calificación</th>
                                    <th>Comentario</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimasResenas as $resena)
                                <tr>
                                    <td class="px-3 fw-semibold">{{ $resena->producto->nombre ?? '—' }}</td>
                                    <td>{{ $resena->user->name ?? '—' }}</td>
                                    <td>
                                        <span class="text-nowrap">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $resena->puntuacion ? '-fill stars-filled' : ' stars-empty' }}" style="font-size:.8rem"></i>
                                            @endfor
                                        </span>
                                    </td>
                                    <td style="max-width:200px">
                                        <span class="d-inline-block text-truncate" style="max-width:180px" title="{{ $resena->comentario }}">
                                            {{ $resena->comentario ?: '—' }}
                                        </span>
                                    </td>
                                    <td style="color:var(--adm-muted)">{{ $resena->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4" style="color:var(--adm-muted)">
                                        <i class="bi bi-chat-dots me-2"></i>Sin reseñas registradas
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="col-lg-4">
            <div class="card h-100" style="border-radius:1rem">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">
                        <i class="bi bi-person-plus-fill me-2 text-blue"></i>Usuarios Recientes
                    </h6>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-primary px-2" style="font-size:.75rem">
                        Ver todos
                    </a>
                </div>
                <div class="card-body">
                    @forelse($usuariosRecientes as $usr)
                    <div class="d-flex align-items-center gap-2 {{ !$loop->last ? 'mb-3' : '' }}">
                        @php
                            $uc = ['bg-blue-soft text-blue','bg-green-soft text-green','bg-purple-soft text-purple','bg-orange-soft text-orange','bg-red-soft text-red','bg-amber-soft text-amber'];
                            $ucl = $uc[$loop->index % count($uc)];
                        @endphp
                        <div class="avatar-circle {{ $ucl }}">{{ strtoupper(substr($usr->name,0,2)) }}</div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-semibold text-truncate" style="font-size:.88rem">{{ $usr->name }}</div>
                            <small class="d-block text-truncate" style="color:var(--adm-muted)">{{ $usr->email }}</small>
                        </div>
                        @if($usr->activo)
                            <span class="badge bg-green-soft text-green rounded-pill" style="font-size:.7rem">Activo</span>
                        @else
                            <span class="badge bg-red-soft text-red rounded-pill" style="font-size:.7rem">Inactivo</span>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-3" style="color:var(--adm-muted)">Sin usuarios</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- ROW 6 – Secciones del Panel                               --}}
    {{-- ══════════════════════════════════════════════════════════ --}}
    {{-- ── [M-02] Seguridad y Control de Acceso ───────────────────── --}}
    @canany(['user-list', 'rol-list'])
    <div class="card mb-4" style="border-radius:1rem">
        <div class="card-header py-3 d-flex align-items-center gap-2">
            <i class="bi bi-shield-lock-fill" style="color:#ef4444;font-size:1.1rem"></i>
            <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Seguridad y Control de Acceso</h6>
            <span class="badge ms-1 rounded-pill" style="background:rgba(239,68,68,.12);color:#ef4444;font-size:.72rem">M-02</span>
        </div>
        <div class="card-body pt-2">
            <div class="row g-2">
                @can('user-list')
                <div class="col-12 col-md-4">
                    <a href="{{ route('usuarios.index') }}" class="module-card h-100">
                        <span class="module-icon bg-red-soft text-red"><i class="bi bi-person-fill-gear"></i></span>
                        <span class="module-label">Usuarios</span>
                    </a>
                </div>
                @endcan
                @can('rol-list')
                <div class="col-12 col-md-4">
                    <a href="{{ route('roles.index') }}" class="module-card h-100">
                        <span class="module-icon bg-red-soft text-red"><i class="bi bi-key-fill"></i></span>
                        <span class="module-label">Roles y Permisos</span>
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>
    @endcanany

    {{-- ── [M-03] Gestión del Formato Musical ────────────────────── --}}
    @canany(['producto-list', 'artista-list', 'categoria-list', 'formato-list'])
    <div class="card mb-4" style="border-radius:1rem">
        <div class="card-header py-3 d-flex align-items-center gap-2">
            <i class="bi bi-music-note-list" style="color:#8b5cf6;font-size:1.1rem"></i>
            <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Gestión del Formato Musical</h6>
            <span class="badge ms-1 rounded-pill" style="background:rgba(139,92,246,.12);color:#8b5cf6;font-size:.72rem">M-03</span>
        </div>
        <div class="card-body pt-2">
            <div class="row g-2">
                @can('producto-list')
                <div class="col-12 col-md-3">
                    <a href="{{ route('productos.index') }}" class="module-card h-100">
                        <span class="module-icon bg-purple-soft text-purple"><i class="bi bi-vinyl-fill"></i></span>
                        <span class="module-label">Productos</span>
                    </a>
                </div>
                @endcan
                @can('artista-list')
                <div class="col-12 col-md-3">
                    <a href="{{ route('artistas.index') }}" class="module-card h-100">
                        <span class="module-icon bg-purple-soft text-purple"><i class="bi bi-mic-fill"></i></span>
                        <span class="module-label">Artistas</span>
                    </a>
                </div>
                @endcan
                @can('categoria-list')
                <div class="col-12 col-md-3">
                    <a href="{{ route('categoria.index') }}" class="module-card h-100">
                        <span class="module-icon bg-purple-soft text-purple"><i class="bi bi-tags-fill"></i></span>
                        <span class="module-label">Categorías</span>
                    </a>
                </div>
                @endcan
                @can('formato-list')
                <div class="col-12 col-md-3">
                    <a href="{{ route('formato.index') }}" class="module-card h-100">
                        <span class="module-icon bg-purple-soft text-purple"><i class="bi bi-journal-bookmark-fill"></i></span>
                        <span class="module-label">Formatos</span>
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>
    @endcanany

    {{-- ── [M-04] Gestión Comercial ────────────────────────────────── --}}
    <div class="card mb-4" style="border-radius:1rem">
        <div class="card-header py-3 d-flex align-items-center gap-2">
            <i class="bi bi-cart-check-fill" style="color:#f97316;font-size:1.1rem"></i>
            <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Gestión Comercial</h6>
            <span class="badge ms-1 rounded-pill" style="background:rgba(249,115,22,.12);color:#f97316;font-size:.72rem">M-04</span>
        </div>
        <div class="card-body pt-2">
            <div class="row g-2">
                @if(auth()->user()->hasRole('admin'))
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.pedidos') }}" class="module-card h-100">
                        <span class="module-icon bg-orange-soft text-orange"><i class="bi bi-bag-check-fill"></i></span>
                        <span class="module-label">Pedidos</span>
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.facturas.index') }}" class="module-card h-100">
                        <span class="module-icon bg-orange-soft text-orange"><i class="bi bi-receipt-cutoff"></i></span>
                        <span class="module-label">Facturas</span>
                    </a>
                </div>
                @can('proveedor-list')
                <div class="col-12 col-md-4">
                    <a href="{{ route('proveedores.index') }}" class="module-card h-100">
                        <span class="module-icon bg-orange-soft text-orange"><i class="bi bi-truck-front-fill"></i></span>
                        <span class="module-label">Proveedores</span>
                    </a>
                </div>
                @endcan
                @else
                <div class="col-12 col-md-6">
                    <a href="{{ route('perfil.pedidos') }}" class="module-card h-100">
                        <span class="module-icon bg-orange-soft text-orange"><i class="bi bi-bag-fill"></i></span>
                        <span class="module-label">Mis Pedidos</span>
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    <a href="{{ route('perfil.recibos') }}" class="module-card h-100">
                        <span class="module-icon bg-orange-soft text-orange"><i class="bi bi-file-earmark-text-fill"></i></span>
                        <span class="module-label">Recibos FE</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── [M-05] Clientes  +  [M-06] Inventario ──────────────────── --}}
    <div class="row g-3 mb-4">
        @can('user-list')
        <div class="col-12 col-md-6">
            <div class="card h-100" style="border-radius:1rem">
                <div class="card-header py-3 d-flex align-items-center gap-2">
                    <i class="bi bi-people-fill" style="color:#1d4ed8;font-size:1.1rem"></i>
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Administración de Clientes</h6>
                    <span class="badge ms-1 rounded-pill" style="background:rgba(29,78,216,.12);color:#1d4ed8;font-size:.72rem">M-05</span>
                </div>
                <div class="card-body pt-2">
                    <a href="{{ route('admin.clientes.index') }}" class="module-card">
                        <span class="module-icon bg-blue-soft text-blue"><i class="bi bi-people-fill"></i></span>
                        <span class="module-label">Gestión de Clientes</span>
                    </a>
                </div>
            </div>
        </div>
        @endcan

        @can('inventario-list')
        <div class="col-12 col-md-6">
            <div class="card h-100" style="border-radius:1rem">
                <div class="card-header py-3 d-flex align-items-center gap-2">
                    <i class="bi bi-box-seam-fill" style="color:#10b981;font-size:1.1rem"></i>
                    <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Gestión de Inventario</h6>
                    <span class="badge ms-1 rounded-pill" style="background:rgba(16,185,129,.12);color:#10b981;font-size:.72rem">M-06</span>
                </div>
                <div class="card-body pt-2">
                    <a href="{{ route('inventario.index') }}" class="module-card">
                        <span class="module-icon bg-green-soft text-green"><i class="bi bi-box-seam-fill"></i></span>
                        <span class="module-label">Control de Stock</span>
                    </a>
                </div>
            </div>
        </div>
        @endcan
    </div>

</div>{{-- container-fluid --}}
</div>{{-- app-content --}}
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js" crossorigin="anonymous"></script>
<script>
document.getElementById('mnuDashboard').classList.add('active');

// ── Donut chart – Pedidos por estado ────────────────────────────
const ctxEstados = document.getElementById('chartEstados');
if (ctxEstados) {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const legendColor = getComputedStyle(document.documentElement).getPropertyValue('--adm-text').trim() || (isDark ? '#e5e7eb' : '#172033');

    const estadosLabels = @json($pedidosPorEstado->pluck('estado')->map(fn($e) => ucfirst($e)));
    const estadosTotals = @json($pedidosPorEstado->pluck('total'));

    const palette = {
        pendiente  : '#f59e0b',
        enviado    : '#3b82f6',
        entregado  : '#10b981',
        cancelado  : '#ef4444',
        anulado    : '#f43f5e',
    };

    const rawLabels = @json($pedidosPorEstado->pluck('estado'));
    const bgColors = rawLabels.map(l => palette[l] || '#94a3b8');

    new Chart(ctxEstados, {
        type: 'doughnut',
        data: {
            labels: estadosLabels,
            datasets: [{
                data: estadosTotals,
                backgroundColor: bgColors,
                borderWidth: 2,
                borderColor: isDark ? '#111827' : '#ffffff',
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: legendColor,
                        font: { size: 12 },
                        padding: 14,
                        usePointStyle: true,
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed} pedido${ctx.parsed !== 1 ? 's' : ''}`
                    }
                }
            }
        }
    });
}
</script>
@endpush
