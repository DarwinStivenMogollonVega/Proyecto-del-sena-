@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">{{ isset($registro) ? 'Editar proveedor' : 'Nuevo proveedor' }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($registro) ? route('proveedores.update', $registro->getKey()) : route('proveedores.store') }}" method="POST" id="formProveedor" novalidate>
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
                                    <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $registro->nombre ?? '') }}" minlength="3" maxlength="120" required pattern="^[^0-9]+$" oninput="this.value = this.value.replace(/[0-9]/g, '')" title="El nombre no puede contener números">
                                    @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="contacto" class="form-label">Contacto</label>
                                    <input type="text" id="contacto" name="contacto" class="form-control @error('contacto') is-invalid @enderror" value="{{ old('contacto', $registro->contacto ?? '') }}" minlength="3" maxlength="120">
                                    @error('contacto') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="telefono" class="form-label">Telefono</label>
                                    <input type="text" id="telefono" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $registro->telefono ?? '') }}" maxlength="40" pattern="^[0-9+\-\s()]+$">
                                    @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $registro->email ?? '') }}" maxlength="120">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="direccion" class="form-label">Direccion</label>
                                    <input type="text" id="direccion" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion', $registro->direccion ?? '') }}" maxlength="255">
                                    @error('direccion') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-2 mb-3 d-flex align-items-center">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" {{ old('activo', $registro->activo ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activo">Activo</label>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label">Descripcion</label>
                                    <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="4" maxlength="1000">{{ old('descripcion', $registro->descripcion ?? '') }}</textarea>
                                    @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2" onclick="window.location.href='{{ route('proveedores.index') }}'">Cancelar</button>
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
    document.getElementById('mnuComercial')?.classList.add('menu-open');
    document.getElementById('mnuComercialLink')?.classList.add('active');
    document.getElementById('mnuProveedores')?.classList.add('active');

    (() => {
        const form = document.getElementById('formProveedor');
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

        const telefono = document.getElementById('telefono');
        telefono?.addEventListener('input', () => {
            telefono.value = telefono.value.replace(/[^0-9+\-\s()]/g, '');
        });
    })();
</script>
@endpush
