@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-0" style="border-radius:1rem; background:#fff;">
                    <div class="card-header" style="background:transparent; border-bottom:1px solid #e5e7eb;">
                        <h3 class="card-title" style="color:#222;">{{ isset($registro) ? 'Editar artista' : 'Crear artista' }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($registro) ? route('artistas.update', $registro->id) : route('artistas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($registro))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $registro->nombre ?? '') }}" required>
                                    @error('nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fotografía</label>
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @if(isset($registro) && $registro->foto)
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/artistas/' . $registro->foto) }}" alt="{{ $registro->nombre }}" style="max-width:120px;border-radius:8px;">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Biografía</label>
                                <textarea name="biografia" rows="6" class="form-control @error('biografia') is-invalid @enderror">{{ old('biografia', $registro->biografia ?? '') }}</textarea>
                                @error('biografia')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('artistas.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
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
