@extends('plantilla.app')

@section('contenido')

<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Todos las Facturas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div>
                            <form action="{{ route('admin.facturas.index') }}" method="get">
                                <div class="input-group">
                                    <input name="texto" type="text" class="form-control" value="{{$texto}}"
                                        placeholder="Ingrese texto a buscar">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i>
                                            Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            {{Session::get('mensaje')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        @endif
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="px-3">#</th>
                                        <th>Cliente</th>
                                        <th>Documento</th>
                                        <th>Razón social</th>
                                        <th>Correo FE</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th style="width: 140px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registros as $reg)
                                        <tr class="align-middle">
                                            <td>{{$reg->id}}</td>
                                            <td>{{ $reg->user->name ?? $reg->nombre }}</td>
                                            <td>{{ $reg->email }}</td>
                                            <td>{{ strtoupper($reg->tipo_documento ?? '-') }} {{ $reg->numero_documento ?? '' }}</td>
                                            <td>{{ $reg->razon_social ?? '-' }}</td>
                                            <td>{{ $reg->correo_factura ?? '-' }}</td>
                                            <td class="fw-bold">${{ number_format($reg->total, 2) }}</td>
                                            <td>
                                                <span class="badge" style="background:#6d4b1b;color:#ffbe5b;font-weight:600;font-size:.97em;padding:.48em 1.1em;box-shadow:0 1px 4px #0001;">
                                                    {{ ucfirst($reg->estado) }}
                                                </span>
                                            </td>
                                            <td>{{ $reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.facturas.edit', $reg->id) }}" class="btn btn-outline-primary btn-sm" style="font-weight:500;">Ver detalles</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4" style="color:var(--adm-muted)">
                                                <i class="bi bi-inbox me-2"></i>Sin facturas registradas
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{$registros->appends(["texto"=>$texto])}}
                    </div>
                </div>
                <!-- /.card -->
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
document.getElementById('mnuFacturas')?.classList.add('active');
document.getElementById('mnuComercial')?.classList.add('menu-open');
document.getElementById('mnuComercialLink')?.classList.add('active');
</script>
@endpush