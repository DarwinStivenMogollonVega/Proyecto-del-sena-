<footer class="footer-discmusic py-5">
    <div class="container">
        <div class="row text-center text-md-start">
            @push('estilos')
            <link rel="stylesheet" href="{{ asset('css/footer-section.css') }}">
            @endpush

            <!-- Marca -->
            <div class="col-md-4 mb-3">
                <h5 class="footer-title">DiscMusic</h5>
                <p class="footer-text">
                    Tu catálogo musical digital. Descubre, explora y compra música de forma fácil y rápida.
                </p>
            </div>

            <!-- Enlaces -->
            <div class="col-md-4 mb-3">
                <h5 class="footer-title">Enlaces</h5>
                <ul class="footer-links list-unstyled">
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Catálogo</a></li>
                    <li><a href="#">Artistas</a></li>
                    <li><a href="#">Acerca de</a></li>
                </ul>
            </div>

            <!-- Contacto -->
            <div class="col-md-4 mb-3">
                <h5 class="footer-title">Contacto</h5>
                <p class="footer-text">Email: soporte@gmail.com</p>
                <p class="footer-text">Tel: +57 316 9439 582</p>
            </div>

        </div>

        <hr class="footer-divider">

        <p class="text-center footer-copy">
            &copy; 2026 DiscMusic. Todos los derechos reservados.
        </p>
    </div>
</footer>