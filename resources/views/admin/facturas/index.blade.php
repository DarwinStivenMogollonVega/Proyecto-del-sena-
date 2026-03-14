@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Gestion de facturas</h3>
                        <a href="{{ route('admin.facturas.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-1"></i>Nueva factura
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.facturas.index') }}" method="get" class="mb-3">
                            <div class="input-group">
                                <input name="texto" type="text" class="form-control" value="{{ $texto }}" placeholder="Buscar por ID, cliente, documento o correo FE">
                                <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i> Buscar</button>
                                @if(!empty($texto))
                                    <a href="{{ route('admin.facturas.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                                @endif
                            </div>
                        </form>

                        @if(Session::has('mensaje'))
                            <div class="alert alert-success alert-dismissible fade show mt-2">
                                {{ Session::get('mensaje') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                            </div>
                        @endif

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Documento</th>
                                        <th>Razon social</th>
                                        <th>Correo FE</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th style="width: 150px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registros as $reg)
                                        <tr>
                                            <td>#{{ $reg->id }}</td>
                                            <td>
                                                <strong>{{ $reg->user->name ?? $reg->nombre }}</strong>
                                                <div class="small text-muted">{{ $reg->email }}</div>
                                            </td>
                                            <td>{{ strtoupper($reg->tipo_documento ?? '-') }} {{ $reg->numero_documento ?? '' }}</td>
                                            <td>{{ $reg->razon_social ?? '-' }}</td>
                                            <td>{{ $reg->correo_factura ?? '-' }}</td>
                                            <td>${{ number_format($reg->total, 2) }}</td>
                                            <td><span class="badge text-bg-secondary">{{ ucfirst($reg->estado) }}</span></td>
                                            <td>
                                                <a href="{{ route('admin.facturas.edit', $reg->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('admin.facturas.destroy', $reg->id) }}" method="post" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta factura?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No hay facturas registradas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $registros->appends(['texto' => $texto])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('mnuFacturas')?.classList.add('active');
document.getElementById('mnuComercial')?.classList.add('menu-open');
document.getElementById('mnuComercialLink')?.classList.add('active');
</script>
@endpush
