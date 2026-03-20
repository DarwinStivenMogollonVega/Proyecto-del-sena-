@extends('web.app')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/acerca-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/header-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 pb-5">
    <section class="about-hero text-center mb-4">
        <h1 class="fw-bold mb-2">Acerca de DiscZone</h1>
        <p class="lead mb-3">
            DiscZone es una tienda digital enfocada en usuarios que valoran la música en formato físico y buscan una experiencia de compra clara, completa y confiable.
        </p>
    </section>
    <!-- Separador visual -->
    <hr class="d-none d-md-block mb-4">

    <section class="mt-4">
        <div class="row g-3 justify-content-center">
            <div class="col-12 col-md-4 mb-3">
                <div class="about-card h-100 shadow-sm rounded">
                    <h5 class="fw-bold">Descubrimiento musical</h5>
                    <p>
                        En DiscZone, el usuario puede navegar por categorías y catálogos para encontrar discos según estilo, colección o preferencia personal. La búsqueda y el ordenamiento por precio ayudan a localizar productos de forma rápida.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="about-card h-100 shadow-sm rounded">
                    <h5 class="fw-bold">Compra guiada</h5>
                    <p>
                        El proceso de compra está pensado para ser sencillo: agregar al carrito, ajustar cantidades, completar datos de entrega y método de pago, y confirmar el pedido. Todo el flujo está orientado a reducir pasos innecesarios.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="about-card h-100 shadow-sm rounded">
                    <h5 class="fw-bold">Seguimiento del usuario</h5>
                    <p>
                        Cada usuario puede gestionar su perfil y consultar sus pedidos, incluyendo estado de compra y detalles de productos adquiridos. Esto permite tener trazabilidad y control sobre su historial dentro de la plataforma.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-block mt-4">
        <div class="bg-white p-4 rounded shadow-sm">
            <h4 class="fw-bold mb-2 text-dark">¿Qué representa DiscZone para el usuario?</h4>
            <p>
                DiscZone combina una interfaz moderna con una estructura de compra práctica para quienes quieren adquirir música física sin complicaciones. El sistema prioriza la experiencia del usuario en cada paso: desde la exploración del catálogo hasta la confirmación del pedido.
            </p>
            <p>
                La plataforma está construida para que el usuario siempre tenga contexto: ve disponibilidad, conoce el precio claramente, administra su carrito y recibe retroalimentación en cada acción importante. Esto mejora la confianza y evita fricciones durante el proceso de compra.
            </p>
            <p>
                Además, DiscZone no se limita a mostrar productos. También permite que la relación con la tienda continúe después de la compra, gracias al perfil y a la sección de pedidos, donde el usuario puede consultar su información y revisar el estado de sus órdenes de forma organizada.
            </p>
            <div class="about-highlight mt-2 bg-warning bg-opacity-10 p-3 rounded">
                <span class="fw-bold text-warning">En resumen, DiscZone es una tienda musical centrada en el usuario: descubrir, comprar y dar seguimiento a sus pedidos en un solo lugar.</span>
            </div>
        </div>
    </section>

    <!-- Sección de adaptabilidad visual -->
    <section class="about-responsive mt-5">
        <h3 class="fw-bold mb-4 text-center">Adaptabilidad visual según el dispositivo</h3>
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="about-card h-100 shadow-sm rounded bg-light">
                    <h5 class="fw-bold text-primary mb-2">Vista adaptable desde un celular</h5>
                    <ul class="mb-2">
                        <li>Elementos compactos y apilados verticalmente.</li>
                        <li>Botones grandes y fáciles de tocar.</li>
                        <li>Menú accesible y navegación simplificada.</li>
                        <li>Imágenes optimizadas para pantallas pequeñas.</li>
                        <li>Tarjetas y bloques ocupan el ancho completo.</li>
                    </ul>
                    <div class="text-center">
                        <i class="bi bi-phone display-6 text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="about-card h-100 shadow-sm rounded bg-light">
                    <h5 class="fw-bold text-success mb-2">Vista adaptable desde un computador</h5>
                    <ul class="mb-2">
                        <li>Distribución en columnas para aprovechar el espacio.</li>
                        <li>Menú superior fijo y accesible.</li>
                        <li>Imágenes de mayor resolución.</li>
                        <li>Tarjetas y bloques con sombra y bordes redondeados.</li>
                        <li>Interacciones con mouse y teclado.</li>
                    </ul>
                    <div class="text-center">
                        <i class="bi bi-laptop display-6 text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="about-card h-100 shadow-sm rounded bg-light">
                    <h5 class="fw-bold text-warning mb-2">Vista adaptable desde un televisor</h5>
                    <ul class="mb-2">
                        <li>Elementos grandes y espaciados.</li>
                        <li>Texto e íconos de mayor tamaño.</li>
                        <li>Interfaz simplificada para control remoto.</li>
                        <li>Menú y navegación optimizados para pantalla amplia.</li>
                        <li>Imágenes y botones visibles desde lejos.</li>
                    </ul>
                    <div class="text-center">
                        <i class="bi bi-tv display-6 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin sección de adaptabilidad visual -->
</div>
@endsection
