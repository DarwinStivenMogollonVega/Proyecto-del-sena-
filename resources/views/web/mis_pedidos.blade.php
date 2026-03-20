@extends('web.app')

@section('titulo', 'Mis pedidos - DiscZone')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/mis-pedidos-section.css') }}">
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
            <a href="{{ route('perfil.pedidos') }}" class="btn btn-outline-light btn-sm quick-action">
                <i class="bi bi-receipt me-1"></i> Ver pedidos
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
