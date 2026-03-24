@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="app-content py-3">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">
                    <i class="bi bi-shield-lock-fill me-2" style="color:var(--adm-accent)"></i>Seguridad y usuarios
                </h4>
            </div>
            <div class="card" style="border-radius:1rem; background:#181f2a; border:1px solid #232a3b; box-shadow:0 2px 8px rgba(0,0,0,.08);">
                <div class="card-header" style="background:transparent; border-bottom:1px solid #232a3b; padding:1.2rem 1.5rem 1rem 1.5rem;">
                    <div class="fw-bold mb-2" style="color:#fff; font-size:1.1rem; letter-spacing:.01em;">
                        <i class="bi bi-people-fill me-2" style="color:var(--adm-accent)"></i>Gestión de usuarios
                    </div>
                    <form action="{{ route('seguridad.index') }}" method="get" class="d-flex align-items-center" style="gap:.5rem;">
                        <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" style="background:#232a3b;color:#fff;border:1px solid #3b4253;min-width:220px;border-radius:.5rem;padding:.7rem 1rem;box-shadow:none;" placeholder="Ingrese texto a buscar">
                        <button type="submit" class="btn btn-sm btn-secondary" style="border-radius:.4rem;padding:.5rem 1.1rem;">Buscar</button>
                        @can('user-create')
                        <a href="{{ route('seguridad.create') }}" class="btn btn-sm btn-primary" style="border-radius:.4rem;padding:.5rem 1.1rem;">Nuevo</a>
                        @endcan
                    </form>
                </div>
                <div class="card-body p-0" style="padding:0 1.5rem 1.5rem 1.5rem;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:.95rem; background:transparent; color:#fff;">
                            <thead>
                                <tr>
                                    <th style="width: 150px">Opciones</th>
                                    <th style="width: 20px">ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($registros) <= 0)
                                    <tr>
                                        <td colspan="6" class="text-center py-4" style="color:var(--adm-muted)">
                                            <i class="bi bi-inbox me-2"></i>No hay registros que coincidan con la búsqueda
                                        </td>
                                    </tr>
                                @else
                                    @foreach($registros as $reg)
                                        <tr class="align-middle">
                                            <td>
                                                @can('user-edit')
                                                <a href="{{ route('seguridad.edit', $reg->id) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                @endcan
                                                @can('user-delete')
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#modal-eliminar-{{ $reg->id }}">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                                @endcan
                                            </td>
                                            <td>{{ $reg->id }}</td>
                                            <td>{{ $reg->name }}</td>
                                            <td>{{ $reg->email }}</td>
                                            <td>{{ $reg->roles->pluck('name')->join(', ') }}</td>
                                            <td>
                                                @if($reg->activo)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @can('user-delete')
                                            @include('seguridad.delete')
                                        @endcan
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@push('scripts')
<script>
    document.getElementById('mnuSeguridadPanel')?.classList.add('active');
    document.getElementById('mnuSeguridad')?.classList.add('menu-open');
    document.getElementById('mnuSeguridadLink')?.classList.add('active');
</script>
@endpush
