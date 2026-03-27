@extends('plantilla.app')
@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Gestión de Clientes</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Listado y administración de clientes del sistema</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">Volver al panel</a>
            </div>
        </div>

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <form action="{{ route('admin.clientes.index') }}" method="get" class="w-100 me-3">
                        <div class="input-group">
                            <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" placeholder="Buscar cliente por nombre o email">
                            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    <div class="ms-3">
                        <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                    </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="font-size:.88rem">
                        <thead>
                            <tr>
                                <th class="px-3">#</th>
                                <th>Nombre</th>
                                <th class="text-center">Compras</th>
                                <th>Estado</th>
                                <th class="actions-col" style="width:150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registros as $reg)
                            <tr>
                                <td class="px-3 fw-semibold">{{ $reg->getKey() }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $reg->name }}</div>
                                    <small class="text-muted">{{ $reg->email }}</small>
                                </td>
                                <td class="text-center"><span class="badge panel-badge-primary">{{ $reg->pedidos_count }}</span></td>
                                <td>
                                    <span class="badge {{ $reg->activo ? 'panel-badge-success' : 'panel-badge-muted' }}">{{ $reg->activo ? 'Activo' : 'Inactivo' }}</span>
                                </td>
                                <td class="actions-col">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.clientes.show', $reg->getKey()) }}" class="btn btn-sm btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('usuarios.edit', $reg->getKey()) }}" class="btn btn-sm btn-outline-info" title="Editar"><i class="bi bi-pencil"></i></a>
                                        @can('user-delete')
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar-cliente-{{ $reg->getKey() }}" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @include('cliente_gestion.delete', ['reg' => $reg])
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3" style="color:var(--adm-muted)">No hay clientes registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    Mostrando {{ $registros->count() }} de {{ $registros->total() }} clientes
                </div>
                <div>
                    {{ $registros->appends(['texto' => $texto])->links() }}
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
