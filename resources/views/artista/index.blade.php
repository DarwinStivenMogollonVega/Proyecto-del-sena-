@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-0" style="border-radius:1rem; background:#fff;">
                    <div class="card-header" style="background:transparent; border-bottom:1px solid #e5e7eb;">
                        <h3 class="card-title" style="color:#222;">Artistas</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('artistas.index') }}" method="get" class="d-flex align-items-center flex-wrap gap-2 mb-3">
                            <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto ?? '' }}" style="max-width:260px; background:#f3f4f6;color:#222;border:1px solid #d1d5db;border-radius:.5rem;padding:.7rem 1rem;box-shadow:none;" placeholder="Ingrese texto a buscar">
                            <button type="submit" class="btn btn-sm btn-secondary" style="border-radius:.4rem;padding:.5rem 1.1rem;"><i class="bi bi-search"></i></button>
                            @can('artista-create')
                            <a href="{{ route('artistas.create') }}" class="btn btn-sm btn-primary" style="border-radius:.4rem;padding:.5rem 1.1rem;">Nuevo</a>
                            @endcan
                        </form>

                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            {{Session::get('mensaje')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        @endif

                        <div class="table-responsive mt-3">
                            <table class="table table-hover align-middle mb-0" style="min-width:700px; color:#222;">
                                <thead>
                                    <tr>
                                        <th style="width: 100px">Opciones</th>
                                        <th style="width: 20px">ID</th>
                                        <th>Foto</th>
                                        <th>Nombre</th>
                                        <th>Slug</th>
                                        <th>Biografía</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registros as $reg)
                                        <tr class="align-middle">
                                            <td class="d-flex flex-row gap-2 justify-content-center">
                                                <a href="{{ route('artistas.edit', $reg->id) }}" class="btn btn-outline-info btn-sm d-flex align-items-center justify-content-center" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button 
                                                    class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center btn-eliminar-artista" 
                                                    data-id="{{$reg->id}}" 
                                                    data-nombre="{{$reg->nombre}}" 
                                                    data-url="{{ route('artistas.destroy', $reg->id) }}"
                                                    title="Eliminar"
                                                    type="button"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                            <td>{{ $reg->id }}</td>
                                            <td>
                                                @if($reg->foto)
                                                    <img src="{{ asset('uploads/artistas/' . $reg->foto) }}" alt="{{ $reg->nombre }}" style="width:55px;height:55px;object-fit:cover;border-radius:8px;">
                                                @else
                                                    <span class="text-muted">Sin foto</span>
                                                @endif
                                            </td>
                                            <td>{{ $reg->nombre }}</td>
                                            <td>{{ $reg->slug }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($reg->biografia, 120) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4" style="color:#888;">
                                                <i class="bi bi-inbox me-2"></i>No hay artistas registrados.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div> <!-- cierre de card-body -->


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix bg-white border-0">
                        {{-- Aquí puedes agregar la paginación si la tienes --}}
                        {{-- {{$registros->appends(["texto"=>$texto])->links()}} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Bloque duplicado eliminado para corregir error de sintaxis -->

<!-- Modal único de eliminación de artista, fuera de la tarjeta y tabla para evitar problemas visuales y de stacking -->
<div class="modal fade" id="modal-eliminar-artista" tabindex="-1" aria-labelledby="modalEliminarArtistaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 540px; width: 100vw;">
        <div class="modal-content bg-white p-4" style="border-radius:1.2rem; box-shadow:0 8px 32px rgba(0,0,0,.18);">
            <form id="formEliminarArtista" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 pb-0">
                    <h2 class="modal-title fw-bold" style="color:#b91c1c; font-size:2rem;">Eliminar artista</h2>
                </div>
                <div class="modal-body" style="color:#222; font-size:1.13rem;">
                    <div class="alert alert-warning mb-4" style="font-size:1em;">
                        <strong>Advertencia:</strong> Esta acción es <u>irreversible</u>. Si elimina este artista, no podrá recuperarlo.<br>
                        Por favor, confirme que realmente desea eliminar el artista <strong id="nombreArtistaEliminar"></strong>.
                    </div>
                    <p class="mb-0">¿Usted desea eliminar el artista <strong id="nombreArtistaEliminar2"></strong>?</p>
                </div>
                <div class="modal-footer justify-content-between border-0 pt-0">
                    <button type="button" class="btn btn-secondary px-4 py-2" style="font-size:1.1rem; border-radius:.6rem;" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger px-4 py-2" style="font-size:1.1rem; border-radius:.6rem;">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('itemArtista')?.classList.add('active');
    document.getElementById('mnuCatalogo')?.classList.add('menu-open');
    document.getElementById('mnuCatalogoLink')?.classList.add('active');

    // Modal único para eliminar artista
    document.querySelectorAll('.btn-eliminar-artista').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var nombre = this.getAttribute('data-nombre');
            var url = this.getAttribute('data-url');
            var nombre1 = document.getElementById('nombreArtistaEliminar');
            var nombre2 = document.getElementById('nombreArtistaEliminar2');
            if (nombre1) nombre1.textContent = nombre;
            if (nombre2) nombre2.textContent = nombre;
            var form = document.getElementById('formEliminarArtista');
            if (form) form.setAttribute('action', url);
            var modalEl = document.getElementById('modal-eliminar-artista');
            if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        });
    });
});
</script>
@endpush

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush
