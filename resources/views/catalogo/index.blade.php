@extends('plantilla.app')
@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Formatos</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Listado de formatos disponibles</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('formato.index') }}" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" placeholder="Buscar formato por nombre">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                @canany(['formato-create'])
                    <a href="{{ route('formato.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                @endcanany
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
                                            @canany(['formato-edit'])
                                            <a href="{{ route('formato.edit', $reg->getKey()) }}" class="btn btn-sm btn-outline-info" title="Editar"><i class="bi bi-pencil"></i></a>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal-vincular-{{ $reg->getKey() }}" title="Vincular productos"><i class="bi bi-link-45deg"></i></button>
                                            @endcanany
                                            @canany(['formato-delete'])
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar-formato-{{ $reg->getKey() }}" title="Eliminar"><i class="bi bi-trash"></i></button>
                                            @endcanany
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
                {{-- modals moved below the page to keep rows clean --}}
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>Mostrando {{ $registros->count() }} de {{ $registros->total() }} formatos</div>
                <div>{{ $registros->appends(['texto' => $texto])->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@foreach($registros as $reg)
    @canany(['formato-delete'])
        @include('formato.delete', ['reg' => $reg])
    @endcanany
    @canany(['formato-activate'])
        @include('formato.activate', ['reg' => $reg])
    @endcanany
@endforeach

@foreach($registros as $reg)
    @canany(['formato-edit','catalogo-edit'])
    <!-- Modal vincular productos -->
    <div class="modal fade" id="modal-vincular-{{ $reg->getKey() }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vincular productos al formato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form action="{{ route('formato.vincular_productos', $reg->getKey()) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="small text-muted">Selecciona los productos que pertenecerán a este formato.</p>
                        <div class="mb-2">
                            <select name="product_ids[]" id="product_ids_{{ $reg->getKey() }}" class="form-control" multiple size="10">
                                @foreach($productos as $p)
                                    <option value="{{ $p->getKey() }}" {{ $p->catalogo_id == ($reg->catalogo_id ?? $reg->formato_id) ? 'selected' : '' }}>{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
@endforeach
@push('scripts')
<script>
    // Permite togglear opciones en <select multiple> sin necesidad de Ctrl
    document.addEventListener('mousedown', function(e){
        const el = e.target;
        if (el.tagName === 'OPTION' && el.parentElement && el.parentElement.multiple) {
            e.preventDefault();
            el.selected = !el.selected;
            el.parentElement.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });
</script>
@endpush
