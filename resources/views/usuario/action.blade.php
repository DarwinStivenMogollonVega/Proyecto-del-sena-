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
                        <h3 class="card-title">Usuarios</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ isset($registro)?route('usuarios.update', $registro->getKey()) : route('usuarios.store')}}" method="POST" id="formRegistroUsuario" novalidate>
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
                                <div class="col-md-4 mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                     id="name" name="name" value="{{old('name', $registro->name ??'')}}" minlength="3" maxlength="100" pattern="^(?!.*\d).+$" title="Este campo no puede contener números." required>
                                     @error('name')
                                        <small class="text-danger">{{$message}}</small>
                                     @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                     id="email" name="email" value="{{old('email',  $registro->email ??'')}}" maxlength="100" required>
                                     @error('email')
                                        <small class="text-danger">{{$message}}</small>
                                     @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="activo" class="form-label">Activo</label>
                                    <select class="form-select @error('activo') is-invalid @enderror" id="activo" name="activo">
                                        <option value="1" {{ old('activo', $registro->activo ?? '1') == '1' ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('activo', $registro->activo ?? '1') == '0' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    @error('activo')
                                        <small class="text-danger">{{$message}}</small>
                                     @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                     id="password" name="password" minlength="8" autocomplete="new-password" @if(!isset($registro)) required @endif>
                                     @error('password')
                                        <small class="text-danger">{{$message}}</small>
                                     @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirme el password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                     id="password_confirmation" name="password_confirmation" minlength="8" autocomplete="new-password" @if(!isset($registro)) required @endif>
                                     @error('password_confirmation')
                                        <small class="text-danger">{{$message}}</small>
                                     @enderror
                                     <small id="password_confirmation_client_error" class="text-danger d-none">La confirmación de contraseña no coincide.</small>
                                </div>                                
                                <div class="col-md-4 mb-3">
                                    <label for="role" class="form-label">Rol</label>
                                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="">Seleccione un rol</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" 
                                                {{ old('role', isset($registro) ? $registro->roles->first()?->name : '') === $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2"
                                    onclick="window.location.href='{{route('usuarios.index')}}'">Cancelar</button>
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
    document.getElementById('itemUsuario').classList.add('active');
    document.getElementById('mnuSeguridad')?.classList.add('menu-open');
    document.getElementById('mnuSeguridadLink')?.classList.add('active');
</script>
<script>
    (() => {
        const form = document.getElementById('formRegistroUsuario');
        if (!form) return;

        form.addEventListener('submit', (event) => {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            let hasErrors = false;

            if (password && passwordConfirmation && password.value !== passwordConfirmation.value) {
                passwordConfirmation.classList.add('is-invalid');
                const passwordClientError = document.getElementById('password_confirmation_client_error');
                passwordClientError?.classList.remove('d-none');
                hasErrors = true;
            } else {
                const passwordClientError = document.getElementById('password_confirmation_client_error');
                passwordClientError?.classList.add('d-none');
            }

            if (email && email.value && !email.checkValidity()) {
                email.classList.add('is-invalid');
                hasErrors = true;
            }

            if (hasErrors) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        const liveValidationInputs = form.querySelectorAll('input, select');
        liveValidationInputs.forEach((input) => {
            input.addEventListener('input', () => {
                if (input.checkValidity()) {
                    input.classList.remove('is-invalid');
                }
                if (input.id === 'password_confirmation') {
                    document.getElementById('password_confirmation_client_error')?.classList.add('d-none');
                }
            });
            input.addEventListener('change', () => {
                if (input.checkValidity()) {
                    input.classList.remove('is-invalid');
                }
                if (input.id === 'password_confirmation') {
                    document.getElementById('password_confirmation_client_error')?.classList.add('d-none');
                }
            });
        });
    })();
</script>
@endpush