@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Control de inventario</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('inventario.index') }}" method="get" class="mb-3">
                            <div class="input-group">
                                <input name="texto" type="text" class="form-control" value="{{ $texto }}" placeholder="Buscar producto por nombre o codigo">
                                <button class="btn btn-secondary" type="submit"><i class="bi bi-search"></i> Buscar</button>
                            </div>
                        </form>

                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            {{ Session::get('mensaje') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        @endif

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Artista</th>
                                        <th>Stock</th>
                                        <th>Movimiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productos as $producto)
                                        <tr>
                                            <td>
                                                <strong>{{ $producto->nombre }}</strong>
                                                <div class="small text-muted">{{ $producto->codigo }}</div>
                                            </td>
                                            <td>{{ $producto->artista->nombre ?? 'Sin artista' }}</td>
                                            <td>
                                                <span class="badge {{ $producto->cantidad <= 5 ? 'bg-danger' : 'bg-success' }}">{{ $producto->cantidad }}</span>
                                            </td>
                                            <td>
                                                <form action="{{ route('inventario.movimiento', $producto->id) }}" method="post" class="row g-2">
                                                    @csrf
                                                    <div class="col-md-3">
                                                        <select name="tipo" class="form-select form-select-sm" required>
                                                            <option value="entrada">Entrada</option>
                                                            <option value="salida">Salida</option>
                                                            <option value="ajuste">Ajuste</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="number" min="1" name="cantidad" class="form-control form-control-sm" required>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="motivo" class="form-control form-control-sm" placeholder="Motivo (opcional)">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-primary btn-sm w-100" type="submit">Guardar</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No hay productos para inventario.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $productos->appends(['texto' => $texto])->links() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Alertas de pocas unidades</h3>
                    </div>
                    <div class="card-body">
                        @forelse($alertas as $alerta)
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>{{ $alerta->nombre }}</span>
                                <span class="badge bg-danger">{{ $alerta->cantidad }}</span>
                            </div>
                        @empty
                            <p class="mb-0 text-muted">No hay alertas activas.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ultimos movimientos</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Tipo</th>
                                        <th>Cant.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($movimientos as $mov)
                                        <tr>
                                            <td>{{ \Illuminate\Support\Str::limit($mov->producto->nombre ?? '-', 22) }}</td>
                                            <td>{{ ucfirst($mov->tipo) }}</td>
                                            <td>{{ $mov->cantidad }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3">Sin movimientos</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('itemInventario')?.classList.add('active');
</script>
@endpush
