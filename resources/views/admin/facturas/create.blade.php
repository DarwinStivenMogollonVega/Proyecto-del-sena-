@extends('plantilla.app')

@section('contenido')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Crear factura</h3>
                        <a href="{{ route('admin.facturas.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                        <div class="card dz-admin-table-card">
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.facturas.store') }}" method="post">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Usuario</label>
                                    <select name="user_id" id="user_id" class="form-select" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($usuarios as $u)
                                            <option
                                                value="{{ $u->getKey() }}"
                                                data-name="{{ $u->name }}"
                                                data-email="{{ $u->email }}"
                                                data-telefono="{{ $u->telefono ?? '' }}"
                                                data-documento="{{ $u->documento_identidad ?? '' }}"
                                                data-direccion="{{ $u->direccion ?? '' }}"
                                                {{ old('user_id') == $u->getKey() ? 'selected' : '' }}
                                            >
                                                {{ $u->name }} ({{ $u->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nombre cliente</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email cliente</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Telefono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Metodo de pago</label>
                                    <select name="metodo_pago" class="form-select" required>
                                        <option value="">Seleccione...</option>
                                        @foreach(['tarjeta' => 'Tarjeta', 'nequi' => 'Nequi', 'efectivo' => 'Efectivo'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('metodo_pago') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Total</label>
                                    <input type="number" step="0.01" min="0" name="total" class="form-control" value="{{ old('total') }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Estado</label>
                                    <select name="estado" class="form-select" required>
                                        @foreach(['pendiente', 'enviado', 'entregado', 'cancelado', 'anulado'] as $estado)
                                            <option value="{{ $estado }}" {{ old('estado', 'pendiente') === $estado ? 'selected' : '' }}>{{ ucfirst($estado) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tipo documento</label>
                                    <select name="tipo_documento" class="form-select" required>
                                        <option value="nit" {{ old('tipo_documento') === 'nit' ? 'selected' : '' }}>NIT</option>
                                        <option value="cedula" {{ old('tipo_documento') === 'cedula' ? 'selected' : '' }}>Cedula</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Numero documento</label>
                                    <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Razon social</label>
                                    <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{ old('razon_social') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Correo factura</label>
                                    <input type="email" name="correo_factura" id="correo_factura" class="form-control" value="{{ old('correo_factura') }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Direccion</label>
                                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}" required>
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Guardar factura
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

(function () {
    var userSelect = document.getElementById('user_id');
    var nombre = document.getElementById('nombre');
    var email = document.getElementById('email');
    var telefono = document.getElementById('telefono');
    var numeroDocumento = document.getElementById('numero_documento');
    var razonSocial = document.getElementById('razon_social');
    var correoFactura = document.getElementById('correo_factura');
    var direccion = document.getElementById('direccion');

    if (!userSelect || !nombre || !email || !telefono || !numeroDocumento || !razonSocial || !correoFactura || !direccion) {
        return;
    }

    function fillFromUser(force) {
        var selected = userSelect.options[userSelect.selectedIndex];
        if (!selected || !selected.value) {
            return;
        }

        var setValue = function (el, value) {
            if (force || !el.value) {
                el.value = value || '';
            }
        };

        setValue(nombre, selected.dataset.name || '');
        setValue(email, selected.dataset.email || '');
        setValue(telefono, selected.dataset.telefono || '');
        setValue(numeroDocumento, selected.dataset.documento || '');
        setValue(razonSocial, selected.dataset.name || '');
        setValue(correoFactura, selected.dataset.email || '');
        setValue(direccion, selected.dataset.direccion || '');
    }

    userSelect.addEventListener('change', function () {
        fillFromUser(true);
    });

    fillFromUser(false);
})();
</script>
@endpush
