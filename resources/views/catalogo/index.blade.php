@extends('plantilla.app')
@section('contenido')
<div class="app-content py-3">
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-1" style="color:var(--adm-heading)">
            <i class="bi bi-journal-bookmark-fill me-2" style="color:var(--adm-accent)"></i>Catálogo musical
        </h4>
    </div>
    <div class="card shadow-sm border-0" style="border-radius:1rem; background:#fff;">
        <div class="card-header" style="background:transparent; border-bottom:1px solid #e5e7eb; padding:1.2rem 1.5rem 1rem 1.5rem;">
            <div class="fw-bold mb-2" style="color:#222; font-size:1.1rem; letter-spacing:.01em;">
                <i class="bi bi-music-note-list me-2" style="color:var(--adm-accent)"></i>Gestión de catálogos
            </div>
            <form action="{{ route('catalogo.index') }}" method="get" class="d-flex align-items-center flex-wrap gap-2 mb-0">
                <input name="texto" type="text" class="form-control form-control-sm" value="{{ $texto }}" style="max-width:220px; background:#f3f4f6;color:#222;border:1px solid #d1d5db;border-radius:.5rem;padding:.7rem 1rem;box-shadow:none;" placeholder="Ingrese texto a buscar">
                <button type="submit" class="btn btn-sm btn-secondary" style="border-radius:.4rem;padding:.5rem 1.1rem;"><i class="bi bi-search"></i></button>
                @can('catalogo-create')
                <a href="{{ route('catalogo.create') }}" class="btn btn-sm btn-primary" style="border-radius:.4rem;padding:.5rem 1.1rem;">Nuevo</a>
                @endcan
            </form>
        </div>
        <div class="card-body p-0" style="padding:0 1.5rem 1.5rem 1.5rem;">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:.95rem; background:transparent; color:#222;">
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
                                    @can('catalogo-edit')
                                    <a href="{{ route('catalogo.edit', $reg->id) }}" class="btn btn-outline-info btn-sm d-flex align-items-center justify-content-center" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                    @can('catalogo-delete')
                                    <button class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#modal-eliminar-{{$reg->id}}" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endcan
                                </td>
                                <td>{{ $reg->id }}</td>
                                <td><span class="badge bg-primary" style="font-size:.97em;">{{ $reg->nombre }}</span></td>
                                <td>{{ $reg->descripcion }}</td>
                            </tr>
                            @can('catalogo-delete')
                                @include('catalogo.delete')
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
@endsection
