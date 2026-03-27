@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Cliente</h3></div>
                    <div class="card-body">
                        <p><strong>Nombre:</strong> {{ $cliente->name }}</p>
                        <p><strong>Email:</strong> {{ $cliente->email }}</p>
                        <p><strong>Estado:</strong> {{ $cliente->activo ? 'Activo' : 'Inactivo' }}</p>
                        <p><strong>Total compras:</strong> {{ $stats['totalPedidos'] }}</p>
                        <p><strong>Gasto total:</strong> ${{ number_format($stats['gastoTotal'], 2) }}</p>
                        <p><strong>Direcciones usadas:</strong> {{ $stats['direccionesRegistradas'] }}</p>
                        <p><strong>Ultima compra:</strong> {{ $stats['ultimaCompra'] ? \Illuminate\Support\Carbon::parse($stats['ultimaCompra'])->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Historial de compras</h3>
                        <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Pedido</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                        <th>Direccion de envio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pedidos as $pedido)
                                        <tr>
                                            <td>#{{ $pedido->getKey() }}</td>
                                            <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                                            <td>{{ ucfirst($pedido->estado) }}</td>
                                            <td>${{ number_format($pedido->total, 2) }}</td>
                                            <td>{{ $pedido->direccion ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5">Este cliente no tiene compras registradas.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $pedidos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('mnuClientes')?.classList.add('active');
</script>
@endpush
