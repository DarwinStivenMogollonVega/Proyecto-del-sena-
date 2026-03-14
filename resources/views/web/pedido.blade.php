@extends('web.app')

@push('estilos')
<style>
    .cart-wrap {
        padding-top: 2.25rem;
        padding-bottom: 2.25rem;
    }

    .cart-hero {
        background: linear-gradient(135deg, #fef8f3 0%, #fdf2ea 52%, #fdeee0 100%);
        border: 1px solid #e8cfc0;
        border-radius: 1.25rem;
        color: var(--dz-heading);
        padding: 1.5rem;
        margin-bottom: 1.35rem;
        box-shadow: 0 20px 36px -30px rgba(196, 99, 16, 0.30);
    }

    .cart-hero h2 {
        margin: 0;
        font-weight: 700;
        font-size: clamp(1.35rem, 1.1rem + 1vw, 2rem);
    }

    .cart-hero p {
        margin: 0.5rem 0 0;
        color: var(--dz-text-muted);
    }

    .cart-shell {
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        background: var(--dz-surface);
        box-shadow: 0 14px 30px -24px rgba(196, 99, 16, 0.22);
    }

    .cart-table-head {
        border-bottom: 1px solid var(--dz-border);
        padding: 0.9rem 1.1rem;
        background: rgba(196, 99, 16, 0.06);
    }

    .cart-table-head strong {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--dz-muted);
        font-weight: 700;
    }

    .cart-row {
        padding: 1rem 1.1rem;
        border-bottom: 1px solid var(--dz-border);
    }

    .cart-row:last-child {
        border-bottom: 0;
    }

    .cart-thumb {
        width: 84px;
        height: 84px;
        object-fit: cover;
        border-radius: 0.75rem;
        border: 1px solid var(--dz-border);
        flex-shrink: 0;
        background: #fff;
    }

    .cart-product-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dz-heading);
        margin-bottom: 0.15rem;
    }

    .cart-product-code {
        color: var(--dz-text-muted);
        font-size: 0.86rem;
    }

    .cart-price-value {
        font-weight: 700;
        color: var(--dz-heading);
        font-size: 0.98rem;
    }

    .cart-label-mobile {
        display: none;
        font-size: 0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--dz-text-muted);
        margin-bottom: 0.15rem;
    }

    .qty-box {
        display: inline-flex;
        align-items: center;
        border: 1px solid var(--dz-border);
        border-radius: 999px;
        overflow: hidden;
        background: var(--dz-body);
    }

    .qty-box .btn {
        border: 0;
        border-radius: 0;
        width: 34px;
        height: 34px;
        line-height: 1;
        font-weight: 700;
    }

    .qty-box .form-control {
        border: 0;
        border-left: 1px solid var(--dz-border);
        border-right: 1px solid var(--dz-border);
        width: 44px;
        height: 34px;
        padding: 0;
        background: transparent;
        font-weight: 700;
    }

    .cart-subtotal {
        font-weight: 700;
        color: #c46310;
        font-size: 1.05rem;
    }

    .cart-summary-head h5 {
        font-weight: 700;
        color: var(--dz-heading);
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .cart-total-label {
        font-size: 0.95rem;
        color: var(--dz-muted);
        font-weight: 600;
    }

    .cart-total-amount {
        font-size: 1.35rem;
        font-weight: 800;
        color: #c46310;
    }

    .cart-actions {
        border-top: 1px solid var(--dz-border);
        padding: 1rem 1.1rem;
        background: rgba(196, 99, 16, 0.05);
    }

    .cart-summary {
        border: 1px solid var(--dz-border);
        border-radius: 1rem;
        background: var(--dz-surface);
        box-shadow: 0 14px 30px -24px rgba(196, 99, 16, 0.22);
        overflow: hidden;
        position: sticky;
        top: 1.2rem;
    }

    .cart-summary-head {
        background: linear-gradient(130deg, #fdf2ea 0%, #fef8f3 100%);
        border-bottom: 1px solid var(--dz-border);
        padding: 0.95rem 1rem;
    }

    .cart-total-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 1.02rem;
    }

    .cart-note {
        margin: 0 0 1rem;
        color: var(--dz-text-muted);
        font-size: 0.85rem;
        line-height: 1.5;
    }

    .cart-empty {
        text-align: center;
        padding: 2.2rem 1rem;
    }

    .cart-empty i {
        font-size: 2.2rem;
        color: #c46310;
        display: inline-block;
        margin-bottom: 0.65rem;
    }

    html[data-theme='dark'] .cart-summary-head {
        background: linear-gradient(130deg, #240e04 0%, #1a0800 100%);
    }

    html[data-theme='dark'] .cart-shell,
    html[data-theme='dark'] .cart-summary {
        background: #1a0800;
        border-color: #3d1e0a;
        box-shadow: 0 14px 30px -24px rgba(0,0,0,0.55);
    }

    html[data-theme='dark'] .cart-hero {
        background: linear-gradient(135deg, #160800 0%, #c46310 55%, #4d2010 100%);
        border: 1px solid rgba(255, 255, 255, 0.16);
        color: #fdf0e4;
        box-shadow: 0 24px 42px -30px rgba(0, 0, 0, 0.65);
    }

    html[data-theme='dark'] .cart-hero p {
        color: rgba(253, 240, 228, 0.85);
    }

    html[data-theme='dark'] .cart-table-head,
    html[data-theme='dark'] .cart-actions {
        background: rgba(196, 99, 16, 0.10);
        border-color: #3d1e0a;
    }

    html[data-theme='dark'] .cart-row {
        border-color: #3d1e0a;
    }

    html[data-theme='dark'] .qty-box {
        background: #240e04;
        border-color: #3d1e0a;
    }

    html[data-theme='dark'] .qty-box .form-control {
        color: #f0e0d2;
        border-color: #3d1e0a;
    }

    html[data-theme='dark'] .cart-subtotal {
        color: #e07a30;
    }

    html[data-theme='dark'] .cart-price-value {
        color: #f0e0d2;
    }

    html[data-theme='dark'] .cart-total-amount {
        color: #e07a30;
    }

    html[data-theme='dark'] .cart-table-head strong {
        color: #c4a898;
    }

    @media (max-width: 991.98px) {
        .cart-summary {
            position: static;
            margin-top: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .cart-table-head {
            display: none;
        }

        .cart-row {
            padding: 0.95rem;
            margin-bottom: 0.6rem;
            border: 1px solid var(--dz-border);
            border-radius: 0.85rem;
            background: var(--dz-body);
        }

        .cart-row:last-child {
            border-bottom: 1px solid var(--dz-border);
        }

        .cart-label-mobile {
            display: block;
        }

        .cart-price,
        .cart-qty,
        .cart-line-total {
            margin-top: 0.7rem;
        }

        .cart-line-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-actions {
            padding: 0.95rem;
        }
    }
</style>
@endpush

@section('contenido')
<section class="cart-wrap">
    <div class="container px-4">
        @php
            $total = 0;
            $itemsCount = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
                $itemsCount += $item['cantidad'];
            }
        @endphp

        <div class="cart-hero">
            <h2>Tu carrito de compra</h2>
            <p>
                {{ $itemsCount }} producto(s) seleccionado(s) para completar tu pedido.
            </p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="cart-shell mb-4">
                    <div class="cart-table-head">
                        <div class="row">
                            <div class="col-md-5"><strong>Producto</strong></div>
                            <div class="col-md-2 text-center"><strong>Precio</strong></div>
                            <div class="col-md-2 text-center"><strong>Cantidad</strong></div>
                            <div class="col-md-3 text-end"><strong>Subtotal</strong></div>
                        </div>
                    </div>
                    <div class="p-0" id="cartItems">
                        @forelse($carrito as $id => $item)
                        <div class="row align-items-center cart-row">
                            <div class="col-md-5 d-flex align-items-center">
                                <img src="{{ asset('uploads/productos/' . $item['imagen']) }}"
                                class="cart-thumb" alt="{{ $item['nombre'] }}">
                                <div class="ms-3">
                                    <h6 class="cart-product-name">{{ $item['nombre'] }}</h6>
                                    <small class="cart-product-code">{{ $item['codigo'] }}</small>
                                </div>
                            </div>

                            <div class="col-md-2 text-center cart-price">
                                <div class="cart-label-mobile">Precio</div>
                                <span class="cart-price-value">${{ number_format($item['precio'], 2) }}</span>
                            </div>

                            <div class="col-md-2 d-flex justify-content-center cart-qty">
                                <div class="cart-label-mobile">Cantidad</div>
                                <div class="qty-box">
                                    <a class="btn btn-outline-secondary" href="{{ route('carrito.restar', ['producto_id' => $id]) }}"
                                        data-action="decrease">-</a>
                                    <input type="text" class="form-control text-center" value="{{ $item['cantidad'] }}"
                                        readonly>
                                    <a href="{{ route('carrito.sumar', ['producto_id' => $id]) }}" class="btn btn-outline-secondary">
                                        +
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-3 d-flex align-items-center justify-content-end cart-line-total">
                                <div class="cart-label-mobile">Subtotal</div>
                                <div class="text-end me-3">
                                    <span class="cart-subtotal">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                                </div>
                                <a class="btn btn-sm btn-outline-danger" href="{{ route('carrito.eliminar', $id) }}">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="cart-empty">
                            <i class="bi bi-cart-x"></i>
                            <p class="mb-0">Tu carrito esta vacio. Agrega productos para continuar.</p>
                        </div>
                        @endforelse
                    </div>

                    @if (session('mensaje'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            {{ session('mensaje') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif

                    <div class="cart-actions">
                        <div class="text-end">
                            <a class="btn btn-outline-danger" href="{{ route('carrito.vaciar') }}">
                                    <i class="bi bi-x-circle me-1"></i>Vaciar carrito
                                </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-summary">
                    <div class="cart-summary-head">
                        <h5 class="mb-0">Resumen del pedido</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="cart-total-line">
                            <span class="cart-total-label">Total a pagar</span>
                            <span class="cart-total-amount" id="orderTotal">${{ number_format($total, 2) }}</span>
                        </div>

                        <p class="cart-note">El total incluye los productos seleccionados actualmente en tu carrito.</p>

                        <a href="{{ route('pedido.formulario') }}" class="btn btn-primary w-100" id="checkout">
                            <i class="bi bi-credit-card me-1"></i>Realizar pedido
                        </a>

                        <a href="/" class="btn btn-outline-secondary w-100 mt-3">
                            <i class="bi bi-arrow-left me-1"></i>Continuar comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection