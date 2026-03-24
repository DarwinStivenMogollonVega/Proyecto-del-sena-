@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-0" style="border-radius:1rem; background:#fff;">
                    <div class="card-header" style="background:transparent; border-bottom:1px solid #e5e7eb;">
                        <h3 class="card-title" style="color:#222;">Categorías</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categoria.index') }}" method="get" class="d-flex align-items-center flex-wrap gap-2 mb-3">
                            <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto ?? '' }}" style="max-width:260px; background:#f3f4f6;color:#222;border:1px solid #d1d5db;border-radius:.5rem;padding:.7rem 1rem;box-shadow:none;" placeholder="Ingrese texto a buscar">
                            <button type="submit" class="btn btn-sm btn-secondary" style="border-radius:.4rem;padding:.5rem 1.1rem;"><i class="bi bi-search"></i></button>
                            @can('categoria-create')
                            <a href="{{ route('categoria.create') }}" class="btn btn-sm btn-primary" style="border-radius:.4rem;padding:.5rem 1.1rem;">Nuevo</a>
                            @endcan
                        </form>

                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            {{Session::get('mensaje')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        @endif

                        <div class="table-responsive mt-3">
                            <table class="table table-hover align-middle mb-0" style="min-width:600px; color:#222;">
                                <thead>
                                    <tr>
                                        <th style="width: 100px">Opciones</th>
                                        <th style="width: 20px">ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registros as $reg)
                                        <tr class="align-middle">
                                            <td class="d-flex flex-row gap-2 justify-content-center">
                                                @can('categoria-edit')
                                                <a href="{{ route('categoria.edit', $reg->id) }}" class="btn btn-outline-info btn-sm d-flex align-items-center justify-content-center" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @endcan
                                                @can('categoria-delete')
                                                <button class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#modal-eliminar-{{$reg->id}}" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                @endcan
                                            </td>
                                            <td>{{ $reg->id }}</td>
                                            <td><span class="badge bg-primary" style="font-size:.97em;">{{ $reg->nombre }}</span></td>
                                            <td>{{ $reg->descripcion }}</td>
                                        </tr>
                                        @can('categoria-delete')
                                            @include('categoria.delete')
                                        @endcan
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4" style="color:#888;">
                                                <i class="bi bi-inbox me-2"></i>No hay registros que coincidan con la búsqueda
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix bg-white border-0">
                        {{ $registros->appends(['texto' => $texto]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
                    </div>
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('mnuCatalogo')?.classList.add('menu-open');
    document.getElementById('mnuCatalogoLink')?.classList.add('active');
    document.getElementById('itemCategoria').classList.add('active');
</script>
@endpush