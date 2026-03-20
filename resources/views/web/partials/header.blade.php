<header class="dz-site-header py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="dz-header-flex text-white">
            <div class="dz-header-logo">
                <!-- Logos adaptados a modo claro/oscuro -->
                <img src="{{ asset('assets/img/recurso11.png') }}" alt="DisMusic Logo" class="img-fluid mb-2 logo-dis-music light">
                <img src="{{ asset('assets/img/recurso12.png') }}" alt="DisMusic Logo" class="img-fluid mb-2 logo-dis-music dark">
            </div>
            </div>
         <div class="dz-header-title">
            <p class="lead fw-normal text-white-50 mb-0">Tienda de Discos Musicales</p>
        </div>
    </div>
</header>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/header-section.css') }}">
@endpush