@extends('web.app')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush

@section('titulo', 'Soporte | Guía de uso')
@section('contenido')
<div class="container py-5">
    <h2 class="mb-4">Guía de uso de la página</h2>
    <div class="accordion" id="soporteAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingInicio">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInicio" aria-expanded="true" aria-controls="collapseInicio">
                    Inicio
                </button>
            </h2>
            <div id="collapseInicio" class="accordion-collapse collapse show" aria-labelledby="headingInicio" data-bs-parent="#soporteAccordion">
                <div class="accordion-body">
                    <strong>Inicio</strong> es la página principal donde puedes:
                    <ul>
                        <li>Ver novedades y productos destacados.</li>
                        <li>Acceder rápidamente a las principales secciones de la tienda.</li>
                        <li>Visualizar estadísticas rápidas de productos, categorías y catálogos.</li>
                        <li>Utilizar accesos directos para explorar el catálogo o buscar productos.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingAcerca">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAcerca" aria-expanded="false" aria-controls="collapseAcerca">
                    Acerca
                </button>
            </h2>
            <div id="collapseAcerca" class="accordion-collapse collapse" aria-labelledby="headingAcerca" data-bs-parent="#soporteAccordion">
                <div class="accordion-body">
                    En <strong>Acerca</strong> puedes:
                    <ul>
                        <li>Conocer la misión, visión y valores de DiscZone.</li>
                        <li>Entender el propósito de la tienda y su enfoque en la experiencia del usuario.</li>
                        <li>Ver información de contacto y detalles sobre el equipo.</li>
                        <li>Leer sobre la filosofía de compra y atención al cliente.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingDeseados">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeseados" aria-expanded="false" aria-controls="collapseDeseados">
                    Deseados
                </button>
            </h2>
            <div id="collapseDeseados" class="accordion-collapse collapse" aria-labelledby="headingDeseados" data-bs-parent="#soporteAccordion">
                <div class="accordion-body">
                    En <strong>Deseados</strong> puedes:
                    <ul>
                        <li>Guardar productos de interés para verlos o comprarlos después.</li>
                        <li>Comparar productos guardados antes de agregarlos al carrito.</li>
                        <li>Eliminar productos de la lista de deseados en cualquier momento.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingCatalogo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCatalogo" aria-expanded="false" aria-controls="collapseCatalogo">
                    Catálogo
                </button>
            </h2>
            <div id="collapseCatalogo" class="accordion-collapse collapse" aria-labelledby="headingCatalogo" data-bs-parent="#soporteAccordion">
                <div class="accordion-body">
                    En <strong>Catálogo</strong> puedes:
                    <ul>
                        <li>Explorar todos los productos disponibles en la tienda.</li>
                        <li>Filtrar productos por categoría, precio, disponibilidad y otros criterios.</li>
                        <li>Ver detalles completos de cada producto, incluyendo imágenes, descripciones y reseñas.</li>
                        <li>Agregar productos directamente al carrito o a la lista de deseados.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingCategorias">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategorias" aria-expanded="false" aria-controls="collapseCategorias">
                    Categorías
                </button>
            </h2>
            <div id="collapseCategorias" class="accordion-collapse collapse" aria-labelledby="headingCategorias" data-bs-parent="#soporteAccordion">
                <div class="accordion-body">
                    En <strong>Categorías</strong> puedes:
                    <ul>
                        <li>Ver los productos organizados por tipo, género o temática.</li>
                        <li>Filtrar productos dentro de una categoría específica.</li>
                        <li>Acceder rápidamente a los productos más populares de cada categoría.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingCarrito">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCarrito" aria-expanded="false" aria-controls="collapseCarrito">
                    Carrito
                </button>
            </h2>
            <div id="collapseCarrito" class="accordion-collapse collapse" aria-labelledby="headingCarrito" data-bs-parent="#soporteAccordion">
                <div class="accordion-body">
                    En <strong>Carrito</strong> puedes:
                    <ul>
                        <li>Ver todos los productos que has agregado para comprar.</li>
                        <li>Modificar la cantidad de cada producto o eliminar productos del carrito.</li>
                        <li>Ver el total a pagar y los detalles de tu compra antes de finalizarla.</li>
                        <li>Proceder al proceso de pago y completar tu pedido.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingPedidos">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePedidos" aria-expanded="false" aria-controls="collapsePedidos">
                    Mis pedidos
                </button>
            </h2>
            <div id="collapsePedidos" class="accordion-collapse collapse" aria-labelledby="headingPedidos" data-bs-parent="#soporteAccordion">
                <div class="accordion-body">
                    En <strong>Mis pedidos</strong> puedes:
                    <ul>
                        <li>Consultar el historial completo de tus compras.</li>
                        <li>Ver el estado actual de cada pedido (pendiente, enviado, entregado, etc.).</li>
                        <li>Descargar recibos y facturas de tus compras.</li>
                        <li>Revisar los detalles de cada producto adquirido.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingPerfil">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePerfil" aria-expanded="false" aria-controls="collapsePerfil">
                    Mi perfil
                </button>
            </h2>
            <div id="collapsePerfil" class="accordion-collapse collapse" aria-labelledby="headingPerfil" data-bs-parent="#soporteAccordion">
                <div class="accordion-body">
                    En <strong>Mi perfil</strong> puedes:
                    <ul>
                        <li>Actualizar tus datos personales y de contacto.</li>
                        <li>Cambiar tu contraseña de acceso.</li>
                        <li>Gestionar tus preferencias de usuario.</li>
                        <li>Ver y editar la información asociada a tu cuenta.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
