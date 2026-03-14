@extends('web.app')

@push('estilos')
<style>
    .checkout-hero {
        background: linear-gradient(135deg, #111827, #7c2d12);
        border-radius: 1rem;
        color: #fff;
        overflow: hidden;
        position: relative;
    }

    .checkout-hero::after {
        content: '';
        position: absolute;
        left: -60px;
        bottom: -70px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(245, 158, 11, 0.25);
    }

    .checkout-card {
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        box-shadow: 0 12px 28px rgba(17, 24, 39, 0.08);
        background: var(--dz-surface);
    }

    .checkout-label {
        font-weight: 600;
        color: var(--dz-text);
        margin-bottom: 0.4rem;
    }

    .checkout-summary {
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        box-shadow: 0 12px 28px rgba(17, 24, 39, 0.08);
        background: var(--dz-surface);
        position: sticky;
        top: 1rem;
    }

    .checkout-total {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--dz-heading);
    }

    .comprobante-wrap {
        display: none;
    }

    .factura-wrap {
        display: none;
        border: 1px dashed var(--dz-border);
        border-radius: 0.8rem;
        padding: 1rem;
        background: rgba(148, 163, 184, 0.08);
    }

    html[data-theme='dark'] .checkout-card,
    html[data-theme='dark'] .checkout-summary {
        background: #111827;
        border-color: #334155;
        box-shadow: 0 12px 24px rgba(2, 6, 23, 0.55);
    }

    html[data-theme='dark'] .checkout-label,
    html[data-theme='dark'] .checkout-summary .text-muted,
    html[data-theme='dark'] .checkout-summary strong,
    html[data-theme='dark'] .checkout-summary span,
    html[data-theme='dark'] .checkout-summary small {
        color: #e5e7eb !important;
    }

    html[data-theme='dark'] .checkout-total {
        color: #fbbf24;
    }

    @media (max-width: 991.98px) {
        .checkout-summary {
            position: static;
            top: auto;
        }
    }

    @media (max-width: 575.98px) {
        .checkout-hero {
            padding: 1.25rem !important;
        }

        .checkout-hero::after {
            width: 130px;
            height: 130px;
            left: -40px;
            bottom: -45px;
        }

        .checkout-card,
        .checkout-summary {
            border-radius: 0.85rem;
        }

        .checkout-total {
            font-size: 1.35rem;
        }
    }
</style>
@endpush

@section('contenido')
<section class="py-5">
    <div class="container px-4 px-lg-5 my-3 my-lg-5">
        <div class="checkout-hero p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-1">Finalizar compra</h2>
                    <p class="mb-0 text-white-50">Completa tus datos para confirmar el pedido y recibir la entrega.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('carrito.mostrar') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i> Volver al carrito
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Revisa los datos del formulario:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="checkout-card p-4 p-lg-5">
                    <h5 class="fw-bold mb-4">Informacion del cliente</h5>

                    <form action="{{ route('pedido.realizar') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="checkout-label">Nombre completo</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', auth()->user()->name ?? '') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="checkout-label">Correo electronico</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="telefono" class="checkout-label">Telefono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', auth()->user()->telefono ?? '') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="metodo_pago" class="checkout-label">Metodo de pago</label>
                                <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta de credito</option>
                                    <option value="nequi" {{ old('metodo_pago') == 'nequi' ? 'selected' : '' }}>Nequi</option>
                                    <option value="efectivo" {{ old('metodo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="direccion" class="checkout-label">Direccion de entrega</label>
                                <textarea name="direccion" id="direccion" class="form-control" rows="3" required>{{ old('direccion', auth()->user()->direccion ?? '') }}</textarea>
                            </div>

                            <div class="col-12">
                                <div class="form-check mt-1">
                                    <input class="form-check-input" type="checkbox" value="1" id="requiere_factura_electronica" name="requiere_factura_electronica" {{ old('requiere_factura_electronica') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="requiere_factura_electronica">
                                        Necesito factura electronica para esta compra
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 factura-wrap" id="facturaWrap">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="tipo_documento" class="checkout-label">Tipo de documento</label>
                                        <select name="tipo_documento" id="tipo_documento" class="form-select">
                                            <option value="">Seleccione...</option>
                                            <option value="nit" {{ old('tipo_documento') == 'nit' ? 'selected' : '' }}>NIT</option>
                                            <option value="cedula" {{ old('tipo_documento', auth()->user()->documento_identidad ? 'cedula' : '') == 'cedula' ? 'selected' : '' }}>Cedula</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="numero_documento" class="checkout-label">Numero de documento</label>
                                        <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento', auth()->user()->documento_identidad ?? '') }}" maxlength="40">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="correo_factura" class="checkout-label">Correo para facturacion</label>
                                        <input type="email" name="correo_factura" id="correo_factura" class="form-control" value="{{ old('correo_factura', auth()->user()->email ?? '') }}" maxlength="120">
                                    </div>
                                    <div class="col-12">
                                        <label for="razon_social" class="checkout-label">Nombre o razon social</label>
                                        <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{ old('razon_social', auth()->user()->name ?? '') }}" maxlength="140">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 comprobante-wrap" id="comprobanteWrap">
                                <label for="comprobante_pago" class="checkout-label">Foto o captura del pago</label>
                                <input type="file" name="comprobante_pago" id="comprobante_pago" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                                <small class="text-muted">Obligatorio si eliges Nequi. Formatos permitidos: JPG, PNG, WEBP. Maximo 4MB.</small>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                            <button type="submit" class="btn btn-dark px-4">
                                <i class="bi bi-check-circle me-1"></i> Confirmar pedido
                            </button>

                            <a href="{{ route('carrito.mostrar') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-cart3 me-1"></i> Regresar al carrito
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="checkout-summary p-4">
                    <h6 class="fw-bold mb-3">Resumen del pedido</h6>

                    @php
                        $total = 0;
                        $items = 0;
                        foreach ($carrito as $item) {
                            $total += $item['precio'] * $item['cantidad'];
                            $items += $item['cantidad'];
                        }
                    @endphp

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Articulos</span>
                        <strong>{{ $items }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <strong>${{ number_format($total, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Envio</span>
                        <strong>Gratis</strong>
                    </div>

                    <div class="border-top pt-3 d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Total a pagar</span>
                        <span class="checkout-total">${{ number_format($total, 2) }}</span>
                    </div>

                    <small class="text-muted d-block">
                        <i class="bi bi-lock me-1"></i> Tus datos se procesan de forma segura.
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        var metodoPago = document.getElementById('metodo_pago');
        var wrap = document.getElementById('comprobanteWrap');
        var comprobante = document.getElementById('comprobante_pago');
        var requiereFactura = document.getElementById('requiere_factura_electronica');
        var facturaWrap = document.getElementById('facturaWrap');
        var tipoDocumento = document.getElementById('tipo_documento');
        var numeroDocumento = document.getElementById('numero_documento');
        var razonSocial = document.getElementById('razon_social');
        var correoFactura = document.getElementById('correo_factura');

        if (!metodoPago || !wrap || !comprobante || !requiereFactura || !facturaWrap || !tipoDocumento || !numeroDocumento || !razonSocial || !correoFactura) {
            return;
        }

        function toggleComprobante() {
            var isNequi = metodoPago.value === 'nequi';
            wrap.style.display = isNequi ? 'block' : 'none';
            comprobante.required = isNequi;
            if (!isNequi) {
                comprobante.value = '';
            }
        }

        function toggleFactura() {
            var activaFactura = requiereFactura.checked;
            facturaWrap.style.display = activaFactura ? 'block' : 'none';
            tipoDocumento.required = activaFactura;
            numeroDocumento.required = activaFactura;
            razonSocial.required = activaFactura;
            correoFactura.required = activaFactura;
            if (!activaFactura) {
                tipoDocumento.value = '';
                numeroDocumento.value = '';
                razonSocial.value = '';
                correoFactura.value = '';
            }
        }

        metodoPago.addEventListener('change', toggleComprobante);
        requiereFactura.addEventListener('change', toggleFactura);
        toggleComprobante();
        toggleFactura();
    })();
</script>
@endsection