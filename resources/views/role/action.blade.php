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
                        <h3 class="card-title">Roles</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ isset($registro)?route('roles.update', $registro->getKey()) : route('roles.store')}}"
                            method="POST" id="formRegistroRole" novalidate>
                            @csrf
                            @if(isset($registro))
                            @method('PUT')
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <strong>Corrige los siguientes errores:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{old('name', $registro->name ??'')}}" minlength="3" pattern="^(?!.*\d).+$" title="Este campo no puede contener números." required>
                                    @error('name')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Permisos:</label><br>
                                    @foreach($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input @error('permissions') is-invalid @enderror" type="checkbox" name="permissions[]"
                                            value="{{ $permission->name }}" id="permiso_{{ $permission->getKey() }}"
                                            {{ in_array($permission->name, old('permissions', isset($registro) ? $registro->permissions->pluck('name')->toArray() : []), true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permiso_{{ $permission->getKey() }}">
                                            {{ ucfirst($permission->name) }}
                                        </label>
                                    </div>
                                    @endforeach
                                    @error('permissions')
                                        <small class="text-danger d-block mt-1">{{$message}}</small>
                                    @enderror
                                    <small id="permissions_client_error" class="text-danger d-block mt-1 d-none">Debes seleccionar al menos un permiso.</small>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2"
                                    onclick="window.location.href='{{route('roles.index')}}'">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

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
document.getElementById('mnuSeguridad').classList.add('menu-open');
document.getElementById('itemRole').classList.add('active');
document.getElementById('mnuSeguridadLink')?.classList.add('active');
</script>
<script>
    (() => {
        const form = document.getElementById('formRegistroRole');
        if (!form) return;

        form.addEventListener('submit', (event) => {
            const checkedPermissions = form.querySelectorAll('input[name="permissions[]"]:checked').length;
            if (checkedPermissions === 0) {
                event.preventDefault();
                event.stopPropagation();
                const permissionInputs = form.querySelectorAll('input[name="permissions[]"]');
                permissionInputs.forEach((input) => input.classList.add('is-invalid'));
                document.getElementById('permissions_client_error')?.classList.remove('d-none');
            }
        });

        const permissionInputs = form.querySelectorAll('input[name="permissions[]"]');
        permissionInputs.forEach((input) => {
            input.addEventListener('change', () => {
                const selected = form.querySelectorAll('input[name="permissions[]"]:checked').length;
                if (selected > 0) {
                    permissionInputs.forEach((checkbox) => checkbox.classList.remove('is-invalid'));
                    document.getElementById('permissions_client_error')?.classList.add('d-none');
                }
            });
        });
    })();
</script>
@endpush