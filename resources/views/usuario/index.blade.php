@extends('plantilla.app')
@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Usuarios</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Gestión de usuarios del sistema</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('usuarios.index') }}" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" placeholder="Buscar usuario por nombre o email">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                @can('user-create')
                    <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                @endcan
            </div>
        </div>

        @if(Session::has('mensaje'))
        <div class="alert alert-info alert-dismissible fade show mt-2">
            {{ Session::get('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
        @endif

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width:800px">
                        <thead>
                            <tr>
                                <th style="width: 20px">ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Activo</th>
                                <th class="actions-col" style="width:150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registros as $reg)
                                <tr>
                                    <td>{{ $reg->getKey() }}</td>
                                    <td>{{ $reg->name }}</td>
                                    <td>{{ $reg->email }}</td>
                                    <td>
                                        @if($reg->roles->isNotEmpty())
                                            @foreach($reg->roles as $role)
                                                <span class="badge panel-badge-primary">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge panel-badge-muted">Sin rol</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $reg->activo ? 'panel-badge-success' : 'panel-badge-muted' }}">{{ $reg->activo ? 'Activo' : 'Inactivo' }}</span>
                                    </td>
                                    <td class="actions-col">
                                        <div class="d-flex gap-2 justify-content-end">
                                            @can('user-edit')
                                            <a href="{{ route('usuarios.edit', $reg->getKey()) }}" class="btn btn-sm btn-outline-info" title="Editar"><i class="bi bi-pencil"></i></a>
                                            @endcan
                                            @can('user-delete')
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar-usuario-{{ $reg->getKey() }}" title="Eliminar"> <i class="bi bi-trash"></i></button>
                                            @endcan
                                            @can('user-activate')
                                            <button class="btn btn-sm {{ $reg->activo ? 'btn-outline-warning' : 'btn-outline-success' }}" data-bs-toggle="modal" data-bs-target="#modal-toggle-{{ $reg->getKey() }}" title="Toggle"><i class="bi {{ $reg->activo ? 'bi-ban' : 'bi-check-circle' }}"></i></button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                {{-- modals moved below the table for cleaner DOM --}}
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox me-2"></i>No hay registros que coincidan con la búsqueda
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            {{-- modals moved below the page to keep rows clean --}}
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando {{ $registros->count() }} de {{ $registros->total() }} usuarios</div>
                <div>{{ $registros->appends(['texto' => $texto])->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@foreach($registros as $reg)
    @can('user-delete')
        @include('usuario.delete', ['reg' => $reg])
    @endcan
    @can('user-activate')
        @include('usuario.activate', ['reg' => $reg])
    @endcan
@endforeach
@push('scripts')
<script>
    document.getElementById('mnuSeguridad').classList.add('menu-open');
    document.getElementById('itemUsuario').classList.add('active');
    document.getElementById('mnuSeguridad')?.classList.add('menu-open');
    document.getElementById('mnuSeguridadLink')?.classList.add('active');
</script>
@endpush