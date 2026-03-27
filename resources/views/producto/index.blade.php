@extends('plantilla.app')
@section('contenido')
<div class="app-content py-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">Productos</h4>
                <p class="mb-0 small" style="color:var(--adm-muted)">Listado de productos registrados en el sistema</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('productos.index') }}" method="get" class="d-flex">
                    <div class="input-group">
                        <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" placeholder="Buscar producto por nombre o codigo">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                @can('producto-create')
                    <a href="{{ route('productos.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                @endcan
            </div>
        </div>

        <div class="card mb-4" style="border-radius:1rem">
            <div class="card-body p-0">

                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            {{Session::get('mensaje')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        @endif

                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="min-width:900px">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">ID</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Proveedor</th>
                                        <th>Artista</th>
                                        <th>Año</th>
                                        <th>Categoría</th>
                                        <th>Catálogo</th>
                                        <th>Imagen</th>
                                <th class="actions-col" style="width: 150px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registros as $reg)
                                        <tr>
                                            <td>{{$reg->getKey()}}</td>
                                            <td>{{$reg->codigo}}</td>
                                            <td>{{$reg->nombre}}</td>
                                            <td>${{ number_format($reg->precio,2) }}</td>
                                            <td>{{$reg->cantidad}}</td>
                                            <td>{{ $reg->proveedor->nombre ?? 'Sin proveedor' }}</td>
                                    <td>{{ $reg->artista->nombre ?? 'Sin artista' }}</td>
                                            <td>{{ $reg->anio_lanzamiento ?? '-' }}</td>
                                            <td>
                                                @if($reg->categoria)
                                                    <span class="badge panel-badge-primary">{{ $reg->categoria->nombre }}</span>
                                                @else
                                                    <span class="badge panel-badge-muted">Sin Categoría</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($reg->catalogo)
                                                    <span class="badge panel-badge-success">{{ $reg->catalogo->nombre }}</span>
                                                @else
                                                    <span class="badge panel-badge-muted">Sin Catálogo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                    @if($reg->imagen)
                                                <img src="{{ asset('uploads/productos/' . $reg->imagen) }}" alt="{{ $reg->nombre }}" style="max-width: 100px; height: auto; border-radius:8px;">
                                                    @else
                                                        <span>Sin imagen</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="actions-col">
                                            <div class="d-flex gap-2 justify-content-end">
                                                @can('producto-edit')
                                                <a href="{{ route('productos.edit', $reg->getKey()) }}" class="btn btn-sm btn-outline-info" title="Editar"><i class="bi bi-pencil"></i></a>
                                                @endcan
                                                        @can('producto-delete')
                                                        <button 
                                                            type="button"
                                                            class="btn btn-sm btn-outline-danger btn-delete-action"
                                                            -bs-toggle="modal"
                                                            data-bs-target="#modal-eliminar-producto-{{ $reg->getKey() }}"
                                                            aria-label="Eliminar producto {{ $reg->nombre ?? 'producto' }}"
                                                            title="Eliminar producto"
                                                        >
                                                        <i class="bi bi-trash"></i>
                                                        </button>
                                                            @endcan
                                            </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center py-4" style="color:#888;">
                                                <i class="bi bi-inbox me-2"></i>No hay registros que coincidan con la búsqueda
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div>Mostrando {{ $registros->count() }} de {{ $registros->total() }} productos</div>
                        <div>{{ $registros->appends(['texto' => $texto])->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    {{-- Modales fuera del flujo de la tabla: mantenemos limpios los rows del table --}}
                    @foreach($registros as $reg)
                        @can('producto-delete')
                            @include('producto.delete', ['reg' => $reg])
                        @endcan
                        @can('producto-activate')
                            @include('producto.activate', ['reg' => $reg])
                        @endcan
                    @endforeach

        @endsection
