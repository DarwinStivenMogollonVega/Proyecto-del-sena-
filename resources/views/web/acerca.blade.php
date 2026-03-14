@extends('web.app')

@push('estilos')
<style>
    .about-hero {
        background:
            radial-gradient(circle at 10% 15%, rgba(245, 158, 11, 0.26), transparent 36%),
            radial-gradient(circle at 88% 14%, rgba(249, 115, 22, 0.22), transparent 30%),
            linear-gradient(135deg, #111827 0%, #7c2d12 52%, #1f2937 100%);
        color: #fff;
        border-radius: 1rem;
        padding: 2.1rem;
        margin-top: 1.5rem;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
    }

    .about-hero p {
        color: rgba(255, 255, 255, 0.88);
        margin-bottom: 0;
    }

    .about-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        padding: 1.3rem 1.25rem;
        height: 100%;
    }

    .about-card h5 {
        font-weight: 700;
        margin-bottom: 0.7rem;
        color: #0f172a;
    }

    .about-card p {
        color: #475569;
        line-height: 1.65;
        margin-bottom: 0;
    }

    .about-block {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        padding: 1.4rem;
    }

    .about-block h4 {
        font-weight: 700;
        margin-bottom: 0.85rem;
    }

    .about-block p {
        color: #475569;
        line-height: 1.75;
        margin-bottom: 0.95rem;
    }

    .about-highlight {
        border-left: 4px solid #f97316;
        background: #fff7ed;
        border-radius: 0.75rem;
        padding: 0.95rem 1rem;
        color: #9a3412;
        font-weight: 500;
    }
</style>
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 pb-5">
    <section class="about-hero">
        <h1 class="fw-bold mb-2">Acerca de DiscZone</h1>
        <p>
            DiscZone es una tienda digital enfocada en usuarios que valoran la musica en formato fisico y buscan una experiencia de compra clara, completa y confiable.
        </p>
    </section>

    <section class="mt-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="about-card">
                    <h5>Descubrimiento musical</h5>
                    <p>
                        En DiscZone, el usuario puede navegar por categorias y catalogos para encontrar discos segun estilo, coleccion o preferencia personal. La busqueda y el ordenamiento por precio ayudan a localizar productos de forma rapida.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-card">
                    <h5>Compra guiada</h5>
                    <p>
                        El proceso de compra esta pensado para ser sencillo: agregar al carrito, ajustar cantidades, completar datos de entrega y metodo de pago, y confirmar el pedido. Todo el flujo esta orientado a reducir pasos innecesarios.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-card">
                    <h5>Seguimiento del usuario</h5>
                    <p>
                        Cada usuario puede gestionar su perfil y consultar sus pedidos, incluyendo estado de compra y detalles de productos adquiridos. Esto permite tener trazabilidad y control sobre su historial dentro de la plataforma.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-block mt-4">
        <h4>Que representa DiscZone para el usuario</h4>
        <p>
            DiscZone combina una interfaz moderna con una estructura de compra practica para quienes quieren adquirir musica fisica sin complicaciones. El sistema prioriza la experiencia del usuario en cada paso: desde la exploracion del catalogo hasta la confirmacion del pedido.
        </p>
        <p>
            La plataforma esta construida para que el usuario siempre tenga contexto: ve disponibilidad, conoce el precio claramente, administra su carrito y recibe retroalimentacion en cada accion importante. Esto mejora la confianza y evita fricciones durante el proceso de compra.
        </p>
        <p>
            Ademas, DiscZone no se limita a mostrar productos. Tambien permite que la relacion con la tienda continue despues de la compra, gracias al perfil y a la seccion de pedidos, donde el usuario puede consultar su informacion y revisar el estado de sus ordenes de forma organizada.
        </p>
        <div class="about-highlight mt-2">
            En resumen, DiscZone es una tienda musical centrada en el usuario: descubrir, comprar y dar seguimiento a sus pedidos en un solo lugar.
        </div>
    </section>
</div>
@endsection
