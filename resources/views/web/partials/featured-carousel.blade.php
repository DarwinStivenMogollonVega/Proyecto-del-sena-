@php
    $featured = $featuredProducts ?? collect();
    $chunks = $featured->chunk(4); // 4 items por slide en escritorio
@endphp

@if($featured->isNotEmpty())
    <section class="featured-carousel my-4">
        <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($chunks as $i => $chunk)
                    <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i==0 ? 'active' : '' }}" aria-current="{{ $i==0 ? 'true' : 'false' }}" aria-label="Slide {{ $i+1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($chunks as $i => $chunk)
                    <div class="carousel-item {{ $i==0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            @foreach($chunk as $prod)
                                <div class="card featured-card text-center">
                                    <a href="{{ route('web.show', $prod->getKey()) }}" class="stretched-link text-decoration-none text-reset">
                                        <div class="card-img-top featured-img-wrapper">
                                            @if($prod->imagen)
                                                <img src="{{ asset('uploads/productos/' . $prod->imagen) }}" alt="{{ $prod->nombre }}" loading="lazy">
                                            @else
                                                <img src="{{ asset('img/no-image.svg') }}" alt="Sin imagen" loading="lazy">
                                            @endif
                                        </div>
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1">{{ Str::limit($prod->nombre, 40) }}</h6>
                                            <p class="card-text small text-muted mb-1">{{ $prod->artista?->nombre ?? '' }}</p>
                                            <div class="price fw-bold">${{ number_format($prod->precio - ($prod->descuento ?? 0), 2) }}</div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </section>
@endif
