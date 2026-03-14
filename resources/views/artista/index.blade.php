@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Gestion de artistas</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('artistas.index') }}" method="get" class="mb-3">
                            <div class="input-group">
                                <input name="texto" type="text" class="form-control" value="{{ $texto }}" placeholder="Buscar artista...">
                                <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i> Buscar</button>
                                <a href="{{ route('artistas.create') }}" class="btn btn-primary">Nuevo artista</a>
                            </div>
                        </form>

                        @if(Session::has('mensaje'))
                            <div class="alert alert-info alert-dismissible fade show mt-2">
                                {{ Session::get('mensaje') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:150px">Opciones</th>
                                        <th>ID</th>
                                        <th>Foto</th>
                                        <th>Nombre</th>
                                        <th>Slug</th>
                                        <th>Biografia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registros as $reg)
                                        <tr>
                                            <td>
                                                <a href="{{ route('artistas.edit', $reg->id) }}" class="btn btn-info btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                                <form action="{{ route('artistas.destroy', $reg->id) }}" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar artista?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit"><i class="bi bi-trash-fill"></i></button>
                                                </form>
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
                                            <td colspan="6">No hay artistas registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $registros->appends(['texto' => $texto])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('itemArtista')?.classList.add('active');
    document.getElementById('mnuCatalogo')?.classList.add('menu-open');
    document.getElementById('mnuCatalogoLink')?.classList.add('active');
</script>
@endpush
