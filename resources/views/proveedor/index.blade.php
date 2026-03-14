@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row g-3 mb-3">
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <small style="color:var(--adm-muted)">Total proveedores</small>
                        <div class="h4 fw-bold mb-0">{{ $resumen['total'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <small style="color:var(--adm-muted)">Activos</small>
                        <div class="h4 fw-bold mb-0">{{ $resumen['activos'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <small style="color:var(--adm-muted)">Con productos</small>
                        <div class="h4 fw-bold mb-0">{{ $resumen['conProductos'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Proveedores</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('proveedores.index') }}" method="get">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control" value="{{ $texto }}" placeholder="Buscar proveedor, contacto, email o telefono">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Buscar</button>
                            @can('proveedor-create')
                            <a href="{{ route('proveedores.create') }}" class="btn btn-primary">Nuevo</a>
                            @endcan
                        </div>
                    </div>
                </form>

                @if(session('mensaje'))
                <div class="alert alert-info alert-dismissible fade show mt-2">
                    {{ session('mensaje') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
                @endif

                <div class="table-responsive mt-3">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th style="width:150px">Opciones</th>
                                <th>ID</th>
                                <th>Proveedor</th>
                                <th>Contacto</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Productos</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registros as $reg)
                            <tr>
                                <td>
                                    @can('proveedor-edit')
                                    <a href="{{ route('proveedores.edit', $reg->id) }}" class="btn btn-info btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                    @endcan
                                    @can('proveedor-delete')
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-eliminar-{{ $reg->id }}"><i class="bi bi-trash-fill"></i></button>
                                    @endcan
                                </td>
                                <td>{{ $reg->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $reg->nombre }}</div>
                                    <small class="text-muted">{{ $reg->direccion ?: '-' }}</small>
                                </td>
                                <td>{{ $reg->contacto ?: '-' }}</td>
                                <td>{{ $reg->telefono ?: '-' }}</td>
                                <td>{{ $reg->email ?: '-' }}</td>
                                <td>{{ $reg->productos_count }}</td>
                                <td>
                                    @if($reg->activo)
                                        <span class="badge text-bg-success">Activo</span>
                                    @else
                                        <span class="badge text-bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                            </tr>
                            @include('proveedor.delete')
                            @empty
                            <tr>
                                <td colspan="8">No hay proveedores registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                {{ $registros->appends(['texto' => $texto]) }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('mnuComercial')?.classList.add('menu-open');
    document.getElementById('mnuComercialLink')?.classList.add('active');
    document.getElementById('mnuProveedores')?.classList.add('active');
</script>
@endpush
