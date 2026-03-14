<form action="{{ route('pedido.realizar') }}" method="POST" class="needs-validation" novalidate>
    @csrf

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <strong>Datos del comprador</strong>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                    <div class="invalid-feedback">Por favor ingresa tu nombre completo.</div>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Por favor ingresa un correo válido.</div>
                </div>

                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                    <div class="invalid-feedback">Por favor ingresa tu número de teléfono.</div>
                </div>

                <div class="col-md-6">
                    <label for="direccion" class="form-label">Dirección de envío</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                    <div class="invalid-feedback">Por favor ingresa tu dirección.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Método de pago -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Método de pago</strong>
        </div>
        <div class="card-body">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" required>
                <label class="form-check-label" for="tarjeta">
                    <i class="bi bi-credit-card-2-front"></i> Tarjeta de crédito / débito
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo_pago" id="nequi" value="nequi">
                <label class="form-check-label" for="nequi">
                    <i class="bi bi-phone"></i> Nequi / Daviplata
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo_pago" id="efectivo" value="efectivo">
                <label class="form-check-label" for="efectivo">
                    <i class="bi bi-cash-coin"></i> Pago contra entrega
                </label>
            </div>
        </div>
    </div>

    <!-- Botón de envío -->
    <button type="submit" class="btn btn-primary w-100" id="checkout">
        <i class="bi bi-credit-card me-1"></i> Realizar pedido
    </button>
</form>

<!-- Validación del formulario -->
<script>
(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>