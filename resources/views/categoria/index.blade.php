@extends('plantilla.app')

@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Categorías</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Listado de categorías del catálogo</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('categoria.index') }}" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" placeholder="Buscar categoría por nombre">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                @can('categoria-create')
                    <a href="{{ route('categoria.create') }}" class="btn btn-sm btn-primary">Nueva</a>
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
                    <table class="table table-hover mb-0 align-middle" style="min-width:700px">
                        <thead>
                            <tr>
                                <th style="width: 20px">ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th style="width: 150px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registros as $reg)
                                <tr>
                                    <td>{{ $reg->getKey() }}</td>
                                    <td>{{ $reg->nombre }}</td>
                                    <td>{{ Str::limit($reg->descripcion, 80) }}</td>
                                    <td>
                                        @if($reg->activo)
                                            <span class="badge panel-badge-success">Activo</span>
                                        @else
                                            <span class="badge panel-badge-muted">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-end">
                                            @can('categoria-edit')
                                            <a href="{{ route('categoria.edit', $reg->getKey()) }}" class="btn btn-sm btn-outline-info" title="Editar"><i class="bi bi-pencil"></i></a>
                                            @endcan
                                            @can('categoria-delete')
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar-categoria-{{ $reg->getKey() }}" title="Eliminar"><i class="bi bi-trash"></i></button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox me-2"></i>No hay registros que coincidan con la búsqueda
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>   
                @foreach($registros as $reg)
                    @can('categoria-delete')
                    @include('categoria.delete', ['reg' => $reg])
                @endcan
                @can('categoria-activate')
                    @include('categoria.activate', ['reg' => $reg])
                @endcan
                @endforeach
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando {{ $registros->count() }} de {{ $registros->total() }} categorías</div>
                <div>{{ $registros->appends(['texto' => $texto])->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('mnuCatalogo')?.classList.add('menu-open');
    document.getElementById('mnuCatalogoLink')?.classList.add('active');
    document.getElementById('itemCategoria').classList.add('active');
</script>
@endpush