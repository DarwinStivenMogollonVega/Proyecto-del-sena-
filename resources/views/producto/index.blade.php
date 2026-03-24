@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-0" style="border-radius:1rem; background:#fff;">
                    <div class="card-header" style="background:transparent; border-bottom:1px solid #e5e7eb;">
                        <h3 class="card-title" style="color:#222;">Productos</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('productos.index') }}" method="get" class="d-flex align-items-center flex-wrap gap-2 mb-3">
                            <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" style="max-width:260px; background:#f3f4f6;color:#222;border:1px solid #d1d5db;border-radius:.5rem;padding:.7rem 1rem;box-shadow:none;" placeholder="Ingrese texto a buscar">
                            <button type="submit" class="btn btn-sm btn-secondary" style="border-radius:.4rem;padding:.5rem 1.1rem;"><i class="bi bi-search"></i></button>
                            @can('producto-create')
                            <a href="{{ route('productos.create') }}" class="btn btn-sm btn-primary" style="border-radius:.4rem;padding:.5rem 1.1rem;">Nuevo</a>
                            @endcan
                        </form>

                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            {{Session::get('mensaje')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        @endif

                        <div class="table-responsive mt-3">
                            <table class="table table-hover align-middle mb-0" style="min-width:900px; color:#222;">
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
                                        <th style="width: 150px">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registros as $reg)
                                        <tr>
                                            <td>{{$reg->id}}</td>
                                            <td>{{$reg->codigo}}</td>
                                            <td>{{$reg->nombre}}</td>
                                            <td>${{ number_format($reg->precio,2) }}</td>
                                            <td>{{$reg->cantidad}}</td>
                                            <td>{{ $reg->proveedor->nombre ?? 'Sin proveedor' }}</td>
                                            <td>{{ $reg->artista->nombre ?? 'Sin artista' }}</td>
                                            <td>{{ $reg->anio_lanzamiento ?? '-' }}</td>
                                            <td>
                                                @if($reg->categoria)
                                                    <span class="badge bg-primary">{{ $reg->categoria->nombre }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Sin Categoría</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($reg->catalogo)
                                                    <span class="badge bg-success">{{ $reg->catalogo->nombre }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Sin Catálogo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                    @if($reg->imagen)
                                                        <img src="{{ asset('uploads/productos/' . $reg->imagen) }}" alt="{{ $reg->nombre }}" style="max-width: 120px; height: auto; border-radius:8px;">
                                                    @else
                                                        <span>Sin imagen</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-row flex-md-row gap-2 justify-content-center w-100">
                                                    <a href="{{ route('productos.show', $reg->id) }}" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" title="Ver detalles">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @can('producto-edit')
                                                    <a href="{{ route('productos.edit', $reg->id) }}" class="btn btn-outline-info btn-sm d-flex align-items-center justify-content-center" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @endcan
                                                    @can('producto-delete')
                                                    <button class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center btn-eliminar-producto" 
                                                        data-id="{{$reg->id}}" 
                                                        data-nombre="{{$reg->nombre}}" 
                                                        title="Eliminar" 
                                                        type="button"
                                                        data-url="{{route('productos.destroy', $reg->id)}}"
                                                        >
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                            {{-- Modal único de eliminación --}}
                                            @if($loop->first)
                                            <div class="modal" id="modal-eliminar-producto" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content bg-white" style="border-radius:1rem;">
                                                        <form id="formEliminarProducto" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-header border-0">
                                                                <h4 class="modal-title" style="color:#b91c1c;">Eliminar registro</h4>
                                                            </div>
                                                            <div class="modal-body" style="color:#222;">
                                                                <div class="alert alert-warning" style="font-size:0.97em;">
                                                                    <strong>Advertencia:</strong> Esta acción es <u>irreversible</u>. Si elimina este producto, no podrá recuperarlo. Por favor, confirme que realmente desea eliminar el registro <strong id="nombreProductoEliminar"></strong>.
                                                                </div>
                                                                ¿Usted desea eliminar el registro <strong id="nombreProductoEliminar2"></strong>?
                                                            </div>
                                                            <div class="modal-footer justify-content-between border-0">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                    @empty
                                        <tr>
                                            <td colspan="13" class="text-center py-4" style="color:#888;">No hay registros que coincidan con la búsqueda</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix bg-white border-0">
                        {{$registros->appends(["texto"=>$texto])}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.getElementById('itemProducto').classList.add('active');
    document.getElementById('mnuCatalogo')?.classList.add('menu-open');
    document.getElementById('mnuCatalogoLink')?.classList.add('active');

    // Modal único para eliminar producto
    document.querySelectorAll('.btn-eliminar-producto').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const url = this.getAttribute('data-url');
            document.getElementById('nombreProductoEliminar').textContent = nombre;
            document.getElementById('nombreProductoEliminar2').textContent = nombre;
            const form = document.getElementById('formEliminarProducto');
            form.setAttribute('action', url);
            const modal = new bootstrap.Modal(document.getElementById('modal-eliminar-producto'));
            modal.show();
        });
    });
</script>
@endpush
@endsection
