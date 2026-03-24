@extends('web.app')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/formulario_pedido_section.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush


@section('contenido')
<section class="formulario-pedido-wrap py-5" style="margin-top: 0rem;">
    @include('web.partials.checkout_steps', ['currentStep' => 3])
    <div class="container px-4 px-lg-5 my-3 my-lg-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-1">Finalizar compra</h2>
                    <p class="mb-0 text-white-50">Selecciona la opción de pago que prefieras para finalizar tu compra.</p>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('pedido.entrega') }}" class="btn btn-outline-light btn-lg px-4 shadow-sm fw-semibold rounded-pill">
                        <i class="bi bi-arrow-left me-2"></i> Volver a entrega
                    </a>
                </div>
                <div class="checkout-card p-4 p-lg-5 mt-3">
                    <form action="{{ route('pedido.pago.guardar') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="list-group">
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input class="form-check-input me-2" type="radio" name="metodo_pago" value="tarjeta" required>
                                        <i class="bi bi-credit-card fs-4 text-primary"></i>
                                        <span>Tarjeta crédito o débito</span>
                                    </label>
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input class="form-check-input me-2" type="radio" name="metodo_pago" value="pse">
                                        <img src="{{ asset('assets/img/bancolombia.png') }}" alt="Bancolombia" style="width:28px;">
                                        <span class="bancolombia-text">Bancolombia</span>
                                    </label>
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input class="form-check-input me-2" type="radio" name="metodo_pago" value="nequi">
                                        <img src="{{ asset('assets/img/nequi.png') }}" alt="Nequi" style="width:28px;">
                                        <span class="nequi-text">Nequi</span>
                                    </label>
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input class="form-check-input me-2" type="radio" name="metodo_pago" value="efectivo">
                                        <i class="bi bi-cash-coin fs-4 text-success"></i>
                                        <span>Efectivo</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Campos condicionales para cada método de pago -->
                        <div id="pago-tarjeta" class="mt-3" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label">Número de tarjeta</label>
                                <input type="text" class="form-control" name="tarjeta_numero" maxlength="19">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Nombre en la tarjeta</label>
                                <input type="text" class="form-control" name="tarjeta_nombre">
                            </div>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="form-label">Expira</label>
                                    <input type="text" class="form-control" name="tarjeta_expira" placeholder="MM/AA" maxlength="5">
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">CVV</label>
                                    <input type="text" class="form-control" name="tarjeta_cvv" maxlength="4">
                                </div>
                            </div>
                        </div>
                        <div id="pago-pse" class="mt-3" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label">Banco</label>
                                <input type="text" class="form-control" name="pse_banco">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Cédula del titular</label>
                                <input type="text" class="form-control" name="pse_cedula">
                            </div>
                        </div>
                        <div id="pago-nequi" class="mt-3" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label">Número de celular Nequi</label>
                                <input type="text" class="form-control" name="nequi_celular">
                            </div>
                        </div>
                        <div id="pago-efectivo" class="mt-3" style="display:none;">
                            <div class="mb-2">
                                <label class="form-label">Punto de pago</label>
                                <select class="form-select" name="efectivo_punto">
                                    <option value="">Selecciona...</option>
                                    <option value="baloto">Baloto</option>
                                    <option value="efecty">Efecty</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                            <button type="submit" class="btn btn-dark px-4 flex-fill" style="background:#d87c23; border:none; color:#fff; font-weight:600; border-radius:12px;">
                                Finalizar compra <i class="bi bi-check-circle ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="metodo_pago"]');
    const bloques = {
        tarjeta: document.getElementById('pago-tarjeta'),
        pse: document.getElementById('pago-pse'),
        nequi: document.getElementById('pago-nequi'),
        efectivo: document.getElementById('pago-efectivo')
    };
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            Object.values(bloques).forEach(div => div.style.display = 'none');
            if (bloques[this.value]) {
                bloques[this.value].style.display = 'block';
            }
        });
    });
});
</script>
@push('estilos')
<style>
    .bancolombia-text {
        color: #0033a0;
        font-weight: 600;
        transition: color 0.2s;
    }
    .nequi-text {
        color: #d2005a;
        font-weight: 600;
        transition: color 0.2s;
    }
    @media (prefers-color-scheme: dark) {
        .bancolombia-text { color: #4d8fff; }
        .nequi-text { color: #ff5fa2; }
    }
</style>
@endpush
