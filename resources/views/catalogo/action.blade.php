@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-0" style="border-radius:1rem;">
                    <div class="card-header" style="background:transparent; border-bottom:1px">
                        <h3 class="card-title">Formato</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ isset($registro) ? route('formato.update', $registro->getKey()) : route('formato.store') }}" 
                              method="POST" id="formRegistroCatalogo" novalidate>

                            @csrf
                            @if(isset($registro))
                                @method('PUT')
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <strong>Corrige los siguientes errores:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" 
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           id="nombre" 
                                           name="nombre" 
                                           value="{{ old('nombre', $registro->nombre ?? '') }}" 
                                           minlength="3"
                                           maxlength="150"
                                           required>
                                    @error('nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea name="descripcion" 
                                              class="form-control @error('descripcion') is-invalid @enderror" 
                                              id="descripcion" 
                                              maxlength="1000"
                                              rows="4">{{ old('descripcion', $registro->descripcion ?? '') }}</textarea>
                                    @error('descripcion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2"
                                        onclick="window.location.href='{{ route('formato.index') }}';">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('mnuFormato')?.classList.add('menu-open');
    document.getElementById('mnuFormatoLink')?.classList.add('active');
    document.getElementById('itemFormato')?.classList.add('active');

    (() => {
        const form = document.getElementById('formRegistroCatalogo');
        if (!form) return;

        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.querySelectorAll('input, textarea').forEach((field) => {
                    if (!field.checkValidity()) field.classList.add('is-invalid');
                });
            }
        });
    })();
</script>
@endpush
