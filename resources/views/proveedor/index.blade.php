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

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold" style="color:var(--adm-heading)">Proveedores</h6>
                <div class="d-flex gap-2 align-items-center">
                    <form action="{{ route('proveedores.index') }}" method="get" class="d-flex">
                        <div class="input-group">
                            <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" placeholder="Buscar proveedor, contacto, email o telefono">
                            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    @can('proveedor-create')
                        <a href="{{ route('proveedores.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                    @endcan
                </div>
            </div>
            <div class="card-body p-0">

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

                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="font-size:.88rem">
                        <thead>
                            <tr>
                                <th class="px-3">#</th>
                                <th>Proveedor</th>
                                <th>Contacto</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th class="text-center">Productos</th>
                                <th>Estado</th>
                                <th class="actions-col" style="width:150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registros as $reg)
                            <tr>
                                <td class="px-3 fw-semibold">{{ $reg->getKey() }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $reg->nombre }}</div>
                                    <small class="text-muted">{{ $reg->direccion ?: '-' }}</small>
                                </td>
                                <td>{{ $reg->contacto ?: '-' }}</td>
                                <td>{{ $reg->telefono ?: '-' }}</td>
                                <td>{{ $reg->email ?: '-' }}</td>
                                <td class="text-center"><span class="badge panel-badge-primary">{{ $reg->productos_count }}</span></td>
                                <td>
                                    @if($reg->activo)
                                        <span class="badge panel-badge-success">Activo</span>
                                    @else
                                        <span class="badge panel-badge-muted">Inactivo</span>
                                    @endif
                                </td>
                                <td class="actions-col">
                                    @can('proveedor-edit')
                                        <a href="{{ route('proveedores.edit', $reg->getKey()) }}" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-pencil-fill"></i></a>
                                    @endcan
                                    @can('proveedor-delete')
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar-proveedor-{{ $reg->getKey() }}" data-modal-id="modal-eliminar-proveedor-{{ $reg->getKey() }}" title="Eliminar"><i class="bi bi-trash-fill"></i></button>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-3" style="color:var(--adm-muted)">No hay proveedores registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                @foreach($registros as $reg)
                    @can('proveedor-delete')
                    @include('proveedor.delete', ['reg' => $reg])
                @endcan
                @can('proveedor-activate')
                    @include('proveedor.activate', ['reg' => $reg])
                @endcan
                @endforeach
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando {{ $registros->count() }} de {{ $registros->total() }} proveedores</div>
                <div>{{ $registros->appends(['texto' => $texto])->links() }}</div>
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
