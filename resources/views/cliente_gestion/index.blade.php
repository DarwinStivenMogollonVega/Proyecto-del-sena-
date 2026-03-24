@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Gestion de clientes</h3>
                        </div>
                    <div class="card-body">
                        <form action="{{ route('admin.clientes.index') }}" method="get" class="mb-3">
                            <div class="input-group">
                                <input name="texto" type="text" class="form-control" value="{{ $texto }}" placeholder="Buscar cliente por nombre o email">
                                <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i> Buscar</button>
                            </div>
                        </form>

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Estado</th>
                                        <th>Compras</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registros as $reg)
                                        <tr>
                                            <td>{{ $reg->id }}</td>
                                            <td>{{ $reg->name }}</td>
                                            <td>{{ $reg->email }}</td>
                                            <td>
                                                <span class="badge {{ $reg->activo ? 'bg-success' : 'bg-secondary' }}">{{ $reg->activo ? 'Activo' : 'Inactivo' }}</span>
                                            </td>
                                            <td>{{ $reg->pedidos_count }}</td>
                                            <td>
                                                <a href="{{ route('admin.clientes.show', $reg->id) }}" class="btn btn-sm btn-primary">Ver detalle</a>
                                                <a href="{{ route('usuarios.edit', $reg->id) }}" class="btn btn-sm btn-info">Editar</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6">No hay clientes registrados.</td></tr>
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
    document.getElementById('mnuClientes')?.classList.add('active');
</script>
@endpush
