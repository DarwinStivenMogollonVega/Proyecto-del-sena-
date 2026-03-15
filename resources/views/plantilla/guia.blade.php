@extends('plantilla.app')

@push('estilos')
<style>
    .guide-wrap {
        display: grid;
        gap: 1rem;
    }

    .guide-hero {
        border: 1px solid var(--adm-border);
        border-radius: 1rem;
        background: linear-gradient(135deg, color-mix(in srgb, var(--adm-accent) 10%, var(--adm-surface)) 0%, var(--adm-surface) 100%);
        padding: 1.25rem;
        box-shadow: var(--adm-shadow);
    }

    .guide-hero h1 {
        margin: 0;
        font-size: 1.4rem;
        color: var(--adm-heading);
        font-weight: 800;
    }

    .guide-hero p {
        margin: 0.45rem 0 0;
        color: var(--adm-muted);
        font-size: 0.92rem;
    }

    .guide-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .guide-card {
        border: 1px solid var(--adm-border);
        border-radius: 0.9rem;
        background: var(--adm-surface);
        box-shadow: var(--adm-shadow);
        padding: 1rem;
    }

    .guide-card h3 {
        margin: 0;
        font-size: 1rem;
        color: var(--adm-heading);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .guide-card p {
        margin: 0.5rem 0 0.65rem;
        color: var(--adm-muted);
        font-size: 0.87rem;
    }

    .guide-list {
        margin: 0;
        padding-left: 1.05rem;
        color: var(--adm-text);
        font-size: 0.86rem;
        line-height: 1.45;
    }

    .guide-list li + li {
        margin-top: 0.35rem;
    }

    .guide-tip {
        margin-top: 0.7rem;
        font-size: 0.8rem;
        color: var(--adm-muted);
        border-top: 1px dashed var(--adm-border);
        padding-top: 0.6rem;
    }

    @media (max-width: 991.98px) {
        .guide-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('contenido')
<div class="container-fluid py-2">
    <div class="guide-wrap">
        <section class="guide-hero">
            <h1><i class="bi bi-life-preserver me-2"></i>Guia de soporte rapido</h1>
            <p>Soluciones faciles para errores comunes del sistema. Sigue estos pasos antes de reportar una incidencia.</p>
        </section>

        <section class="guide-grid">
            <article class="guide-card">
                <h3><i class="bi bi-moon-stars"></i>Tema visual no cambia</h3>
                <p>Cuando el modo oscuro o claro no se aplica correctamente.</p>
                <ol class="guide-list">
                    <li>Recarga la pagina con <strong>Ctrl + F5</strong>.</li>
                    <li>Cierra y vuelve a abrir la sesion.</li>
                    <li>Verifica que tu navegador permita Local Storage.</li>
                </ol>
                <div class="guide-tip">Tip: si persiste, prueba en ventana privada para descartar cache del navegador.</div>
            </article>

            <article class="guide-card">
                <h3><i class="bi bi-image"></i>Imagen de producto no aparece</h3>
                <p>La miniatura puede no cargarse si la ruta del archivo es invalida.</p>
                <ol class="guide-list">
                    <li>Abre el producto y confirma que tenga imagen asignada.</li>
                    <li>Vuelve a subir la imagen en formato JPG, PNG o WEBP.</li>
                    <li>Evita nombres de archivo con caracteres especiales.</li>
                </ol>
                <div class="guide-tip">Tip: usa imagenes ligeras (menos de 2MB) para mejorar la carga.</div>
            </article>

            <article class="guide-card">
                <h3><i class="bi bi-bag-x"></i>Error al agregar al carrito</h3>
                <p>Suele ocurrir por stock insuficiente o por una sesion expirada.</p>
                <ol class="guide-list">
                    <li>Verifica que el producto tenga stock disponible.</li>
                    <li>Actualiza la pagina e intenta nuevamente.</li>
                    <li>Si estabas inactivo, vuelve a iniciar sesion.</li>
                </ol>
                <div class="guide-tip">Tip: revisa el estado del producto en el panel antes de reintentar.</div>
            </article>

            <article class="guide-card">
                <h3><i class="bi bi-receipt"></i>Factura o recibo no se genera</h3>
                <p>Puede fallar si faltan datos obligatorios del perfil del cliente.</p>
                <ol class="guide-list">
                    <li>Completa nombre, email y documento de identidad en Perfil.</li>
                    <li>Confirma que el pedido este en estado permitido para facturar.</li>
                    <li>Intenta abrir el PDF desde la seccion de recibos nuevamente.</li>
                </ol>
                <div class="guide-tip">Tip: si el PDF abre en blanco, descarga el archivo y vuelve a abrirlo localmente.</div>
            </article>
        </section>
    </div>
</div>
@endsection
