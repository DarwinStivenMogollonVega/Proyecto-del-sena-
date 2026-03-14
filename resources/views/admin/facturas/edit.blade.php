@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Editar factura #{{ $registro->id }}</h3>
                        <a href="{{ route('admin.facturas.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.facturas.update', $registro->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Usuario</label>
                                    <select name="user_id" class="form-select" required>
                                        @foreach($usuarios as $u)
                                            <option value="{{ $u->id }}" {{ (string) old('user_id', $registro->user_id) === (string) $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nombre cliente</label>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $registro->nombre) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email cliente</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $registro->email) }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Telefono</label>
                                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $registro->telefono) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Metodo de pago</label>
                                    <select name="metodo_pago" class="form-select" required>
                                        @foreach(['tarjeta' => 'Tarjeta', 'nequi' => 'Nequi', 'efectivo' => 'Efectivo'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('metodo_pago', $registro->metodo_pago) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Total</label>
                                    <input type="number" step="0.01" min="0" name="total" class="form-control" value="{{ old('total', $registro->total) }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Estado</label>
                                    <select name="estado" class="form-select" required>
                                        @foreach(['pendiente', 'enviado', 'entregado', 'cancelado', 'anulado'] as $estado)
                                            <option value="{{ $estado }}" {{ old('estado', $registro->estado) === $estado ? 'selected' : '' }}>{{ ucfirst($estado) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tipo documento</label>
                                    <select name="tipo_documento" class="form-select" required>
                                        <option value="nit" {{ old('tipo_documento', $registro->tipo_documento) === 'nit' ? 'selected' : '' }}>NIT</option>
                                        <option value="cedula" {{ old('tipo_documento', $registro->tipo_documento) === 'cedula' ? 'selected' : '' }}>Cedula</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Numero documento</label>
                                    <input type="text" name="numero_documento" class="form-control" value="{{ old('numero_documento', $registro->numero_documento) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Razon social</label>
                                    <input type="text" name="razon_social" class="form-control" value="{{ old('razon_social', $registro->razon_social) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Correo factura</label>
                                    <input type="email" name="correo_factura" class="form-control" value="{{ old('correo_factura', $registro->correo_factura) }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Direccion</label>
                                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $registro->direccion) }}" required>
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Actualizar factura
                                </button>
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
document.getElementById('mnuFacturas')?.classList.add('active');
document.getElementById('mnuComercial')?.classList.add('menu-open');
document.getElementById('mnuComercialLink')?.classList.add('active');
</script>
@endpush
