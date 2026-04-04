@extends('web.app')

@section('titulo', 'Mi perfil - DiscZone')

@push('estilos')
<link rel="stylesheet" href="{{ asset('css/perfil-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/viewport-preview.css') }}">
<!-- intl-tel-input styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.min.css">
@endpush

@section('contenido')
<div class="container px-4 px-lg-5 pb-5 profile-page">
    <section class="profile-hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1"><span class="profile-title-icon"><i class="bi bi-person-circle"></i></span>Mi perfil</h1>
                <p class="mb-0">Gestiona tus datos personales y seguridad de acceso desde una vista individual para tu cuenta.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('dashboard') }}" class="btn btn-light"><i class="bi bi-bar-chart-line me-1"></i> dashboard</a>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="profile-card p-3 p-lg-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
                {{-- Toast de confirmación (también mostrable) --}}
                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
                    <div id="saveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">{{ session('success') }}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('perfil.update') }}" method="POST" id="formRegistroUsuario" enctype="multipart/form-data">
                @csrf                @method('PUT')
                <input type="hidden" name="remove_avatar" id="removeAvatarInput" value="0">
                <input type="hidden" name="avatar_rotation" id="avatarRotationInput" value="0">
                <input type="hidden" name="avatar_scale" id="avatarScaleInput" value="1">
                <input type="hidden" name="avatar_cropped" id="avatarCroppedInput" value="">

                {{-- ── Avatar ──────────────────────────────── --}}
                <div class="avatar-upload-wrap">
                    <div class="avatar-ring" id="avatarRing" title="Cambiar foto">
                        @if ($registro->avatar)
                            <img src="{{ asset('uploads/avatars/' . $registro->avatar) }}" id="avatarPreview" alt="Avatar">
                        @else
                            <div class="avatar-initial" id="avatarInitial">{{ strtoupper(mb_substr(trim($registro->name), 0, 1)) }}</div>
                            <img src="" id="avatarPreview" alt="Avatar" style="display:none;">
                        @endif
                        <div class="avatar-overlay"><i class="bi bi-camera-fill"></i></div>
                    </div>
                    <input type="file" name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/webp" class="d-none">
                    <span class="avatar-hint">Haz clic en la imagen para cambiar tu foto de perfil (JPG, PNG o WEBP, máx. 2 MB)</span>
                    <small id="avatarError" class="text-danger" style="display:none; margin-left:0;">Archivo no válido</small>
                    <div id="avatarEditOptions" style="display:none; margin-top: 1rem;">
                        <div class="mb-2">Previsualización y recorte:</div>
                        <div class="avatar-edit-flex" style="display:flex;align-items:flex-start;gap:1rem;">
                            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                                <!-- Viewport preview component (responsive) -->
                                <div class="viewport-viewport viewport-400 vp-shadow" data-role="viewport">
                                    <img class="viewport-img" src="" alt="Vista previa" />
                                    <!-- reuse hidden file input? we also read from #avatarInput in JS -->
                                </div>
                                <!-- Legacy hidden cropper for backward compatibility -->
                                <div class="avatar-cropper" style="display:none; visibility:hidden; width:1px; height:1px; overflow:hidden;">
                                    <img id="avatarCropImage" src="" alt="Crop" style="position:absolute; left:0; top:0; will-change:transform; transform-origin:0 0;">
                                </div>
                                <!-- controls -->
                                <div class="viewport-controls">
                                    <input type="range" min="0.5" max="4" step="0.01" value="1" class="viewport-zoom" aria-label="Zoom">
                                    <button type="button" class="btn btn-sm btn-outline-secondary vp-reset">Reset</button>
                                </div>
                            </div>
                            <div class="avatar-controls" style="flex:1">
                                <div class="avatar-hint-action" style="margin-bottom:.5rem;color:var(--dz-text-subtle);font-size:0.95rem;">Arrastra o usa las teclas &larr; &rarr; &uarr; &darr; para mover; usa + / - o los botones para acercar/alejar.</div>
                                    <div class="mb-2">
                                        <label class="form-label">Tamaño de recorte</label>
                                        <div style="display:flex;gap:.5rem;align-items:center;">
                                            <div style="display:flex;gap:.5rem;align-items:center;flex-direction:row;">
                                                <label class="form-label" style="margin:0;font-weight:600;font-size:0.85rem;">W</label>
                                                <input id="avatarCropWidth" name="avatar_crop_width" type="number" min="100" max="1200" step="1" value="260" class="form-control form-control-sm" style="width:100px;">
                                                <label class="form-label" style="margin:0;font-weight:600;font-size:0.85rem;">H</label>
                                                <input id="avatarCropHeight" name="avatar_crop_height" type="number" min="100" max="1200" step="1" value="260" class="form-control form-control-sm" style="width:100px;">
                                            </div>
                                            <div style="display:flex;flex-direction:column;gap:.25rem;margin-left:.5rem;">
                                                <label class="form-label" style="margin:0;font-weight:600;font-size:0.85rem;">Salida (px)</label>
                                                <input id="avatarOutputSize" name="avatar_output_size" type="number" min="64" max="800" step="1" value="600" class="form-control form-control-sm" style="width:120px;">
                                            </div>
                                            <div style="margin-top:.5rem;">
                                                <div id="avatarPresetSizes" style="display:flex;gap:.5rem;flex-wrap:wrap;">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary avatar-crop-preset" data-w="100" data-h="100">100×100</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary avatar-crop-preset" data-w="200" data-h="200">200×200</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary avatar-crop-preset" data-w="260" data-h="260">260×260</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary avatar-crop-preset" data-w="400" data-h="300">400×300</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary avatar-crop-preset" data-w="800" data-h="600">800×600</button>
                                                </div>
                                            </div>
                                            <div style="display:flex;flex-direction:column;gap:.25rem;">
                                                <small class="text-muted">Mín {{ config('avatar.crop_min', 100) }} — Máx {{ config('avatar.crop_max', 800) }} (px)</small>
                                                <small id="avatarCropSizeError" class="text-danger" style="display:none; font-size:0.85rem;"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Zoom</label>
                                        <div style="display:flex;align-items:center;gap:.5rem;">
                                            <button type="button" id="avatarZoomMinus" class="btn btn-sm btn-outline-secondary" style="width:34px;height:34px;">−</button>
                                            <input id="avatarZoom" type="range" min="0.5" max="2.5" step="0.01" value="1" class="form-range" style="flex:1;margin:0 0.5rem;">
                                            <button type="button" id="avatarZoomPlus" class="btn btn-sm btn-outline-secondary" style="width:34px;height:34px;">+</button>
                                            <span id="avatarZoomWarning" class="text-warning" title="Has alcanzado el tamaño mínimo; la imagen cubre justo la caja" style="display:none;font-size:1.1rem;">&#9888;</span>
                                        </div>
                                    </div>
                                <!-- Rotar eliminado según solicitud del usuario -->
                                <div class="mb-2">
                                    <button type="button" class="btn btn-danger btn-sm" id="avatarRemove">Eliminar foto</button>
                                </div>
                                <div class="mt-2 d-flex gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="avatarEditCancel">Cancelar</button>
                                    <button type="button" class="btn btn-secondary btn-sm" id="avatarUseTemp">Usar temporalmente</button>
                                    <button type="button" class="btn btn-primary btn-sm" id="avatarEditSave">Colocar foto</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $registro->name ?? '') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $registro->email ?? '') }}" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $registro->telefono ?? '') }}" placeholder="Ejemplo: +591 70000000">
                        <input type="hidden" name="phone_code" id="phone_code" value="{{ old('phone_code', '') }}">
                        @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="documento_identidad" class="form-label">Documento de identidad</label>
                        <input type="text" class="form-control @error('documento_identidad') is-invalid @enderror" id="documento_identidad" name="documento_identidad" value="{{ old('documento_identidad', $registro->documento_identidad ?? '') }}" placeholder="CI, DNI o pasaporte">
                        @error('documento_identidad') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    @php
                        $maxDate = \Carbon\Carbon::today()->format('Y-m-d');
                        $minDate = \Carbon\Carbon::today()->subYears(80)->format('Y-m-d');
                    @endphp
                    <div class="col-md-4 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', optional($registro->fecha_nacimiento)->format('Y-m-d')) }}" min="{{ $minDate }}" max="{{ $maxDate }}">
                        <div class="form-text">Seleccione su fecha de nacimiento. Rango permitido: {{ $minDate }} — {{ $maxDate }}.</div>
                        <small id="fechaNacimientoFeedback" class="text-danger" style="display:none;"></small>
                        @error('fecha_nacimiento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control @error('ciudad') is-invalid @enderror" id="ciudad" name="ciudad" value="{{ old('ciudad', $registro->ciudad ?? '') }}">
                        @error('ciudad') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pais" class="form-label">Pais</label>
                        <input type="text" class="form-control @error('pais') is-invalid @enderror" id="pais" name="pais" value="{{ old('pais', $registro->pais ?? '') }}">
                        @error('pais') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $registro->direccion ?? '') }}" placeholder="Calle, zona, referencia">
                        @error('direccion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="codigo_postal" class="form-label">Codigo postal</label>
                        <input type="text" class="form-control @error('codigo_postal') is-invalid @enderror" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal', $registro->codigo_postal ?? '') }}">
                        @error('codigo_postal') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Nueva contrasena</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar contrasena</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-outline-secondary me-md-2" href="{{ route('cliente.dashboard') }}">Cancelar</a>
                    <button type="submit" class="btn btn-dark"><i class="bi bi-check2-circle me-1"></i> Actualizar datos</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
// Telemetry helper variables (blade-rendered)
const TELEMETRY_CSRF = '{{ csrf_token() }}';
const TELEMETRY_USER_ID = '{{ Auth::id() ?? '' }}';

document.addEventListener('DOMContentLoaded', function () {
    const ring    = document.getElementById('avatarRing');
    const input   = document.getElementById('avatarInput');
    const preview = document.getElementById('avatarPreview');
    const initial = document.getElementById('avatarInitial');
    const editOptions = document.getElementById('avatarEditOptions');
    const cropImg = document.getElementById('avatarCropImage');
    const cropBox = document.querySelector('.avatar-cropper');
    const editCancel = document.getElementById('avatarEditCancel');
    const editSave = document.getElementById('avatarEditSave');
    const avatarError = document.getElementById('avatarError');
    const form = document.getElementById('formRegistroUsuario');
    const removeInput = document.getElementById('removeAvatarInput');
    const avatarCroppedInput = document.getElementById('avatarCroppedInput');
    const zoomRange = document.getElementById('avatarZoom');
    const removeBtn = document.getElementById('avatarRemove');

    if (!ring || !input) return;

    // init our viewport-preview component (if present)
    try {
        var vpScript = document.createElement('script'); vpScript.src = '{{ asset("js/viewport-preview.js") }}'; document.head.appendChild(vpScript);
        vpScript.onload = function () {
            // initialize instances
            window.initViewportPreview('.viewport-viewport');
            // wire file input to update viewport image as well
            input.addEventListener('change', function (ev) {
                const f = this.files && this.files[0];
                if (!f) return;
                const r = new FileReader(); r.onload = function(e){
                    document.querySelectorAll('.viewport-viewport .viewport-img').forEach(img=>{ img.src = e.target.result; });
                }; r.readAsDataURL(f);
            });
            // reset button behavior
            document.querySelectorAll('.vp-reset').forEach(btn=>{ btn.addEventListener('click', function(){ document.querySelectorAll('.viewport-viewport').forEach(el=>{ if (el.__vp) { el.__vp.scale = Math.max(1, el.__vp.scale); el.__vp.pos.x = 0; el.__vp.pos.y = 0; el.__vp.update(); } }); }); });
            // when the viewport changes, refresh the raster preview so the ring shows
            // the exact exported image in near real-time (debounced server input update)
            document.querySelectorAll('.viewport-viewport').forEach(el=>{
                el.addEventListener('viewport:change', function(){
                    try { if (typeof schedulePreviewRefresh === 'function') schedulePreviewRefresh(120); else if (typeof performPreviewRefresh === 'function') performPreviewRefresh(); } catch(e){}
                });
                // ensure viewport element can receive keyboard focus so arrow keys work
                try {
                    if (!el.hasAttribute('tabindex')) el.setAttribute('tabindex', '0');
                    el.addEventListener('click', function () { try { this.focus(); } catch (e) {} });
                } catch (e) {}
            });
        };
    } catch (e) { console.error('viewport init failed', e); }

    const MAX_BYTES = 2 * 1024 * 1024; // 2 MB
    const ALLOWED = ['image/jpeg','image/png','image/webp'];
    // minimal zoom to allow (1.0 = natural size)
    const MIN_INITIAL_SCALE = 1.0;
    let posX = 0, posY = 0, isDragging = false, startX = 0, startY = 0;
    let currentScale = 1; // applied scale
    let currentRotation = 0; // rotation (UI only)
    // when images are very large, we keep a downscaled canvas to render/process
    let scaledSourceCanvas = null;
    let scaledIw = 0, scaledIh = 0;

    // add a small transition so rotations/zooms feel smooth
    if (cropImg) {
        cropImg.style.transition = 'transform 160ms ease';
        // ensure pointer interactions behave consistently on all browsers
        cropImg.style.touchAction = 'none';
        cropImg.setAttribute('draggable', 'false');
    }

    const zoomWarningEl = document.getElementById('avatarZoomWarning');
    const zoomMinus = document.getElementById('avatarZoomMinus');
    const zoomPlus = document.getElementById('avatarZoomPlus');

    function updateZoomWarning() {
        if (!zoomWarningEl || !cropImg || !cropBox) return;
        const dims = getRotatedDims(currentRotation, cropImg.naturalWidth || 0, cropImg.naturalHeight || 0);
        const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
        const minScale = Math.max(MIN_INITIAL_SCALE, Math.max(bw / Math.max(1, dims.w), bh / Math.max(1, dims.h)));
        const threshold = minScale + 0.01; // small hysteresis
        if (currentScale <= threshold) {
            zoomWarningEl.style.display = 'inline-block';
        } else {
            zoomWarningEl.style.display = 'none';
        }
    }

    function applyTransform() {
        const t = `translate(${posX}px, ${posY}px) scale(${currentScale}) rotate(${currentRotation}deg)`;
        cropImg.style.transform = t;
        // also update main preview if visible
        try {
            if (preview) { preview.style.transition = 'transform 160ms ease'; preview.style.transform = t; }
            // if a viewport component is active, notify it to re-render
            const vpEl = document.querySelector('.viewport-viewport');
            if (vpEl && vpEl.__vp && typeof vpEl.__vp.update === 'function') {
                try { vpEl.__vp.update(); } catch (e) { /* ignore */ }
            }
        } catch (e) {}
        updateZoomWarning();
        // schedule a refresh of the rasterized preview so saved image matches what user sees
        schedulePreviewRefresh();
    }

    // Debounced rasterized preview updater: converts current crop to dataURL and applies to ring preview
    let _previewRefreshTimer = null;
    function schedulePreviewRefresh(delay = 180) {
        if (_previewRefreshTimer) clearTimeout(_previewRefreshTimer);
        _previewRefreshTimer = setTimeout(performPreviewRefresh, delay);
    }
    /**
     * Render a viewport-scaled preview that matches the visible ring/avatar size.
     * This draws the same crop region (respecting posX/posY/scale/rotation) but
     * outputs a raster sized to `px` so what the user sees exactly matches the
     * final raster saved.
     */
    function renderViewportPreview(px) {
        try {
            if (!cropImg || !cropImg.src) return null;
            const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
            const imgEl = cropImg;
            const norm = ((currentRotation % 360) + 360) % 360;
            const iw = scaledSourceCanvas ? scaledIw : (imgEl.naturalWidth || 0), ih = scaledSourceCanvas ? scaledIh : (imgEl.naturalHeight || 0);
            // create rotated source canvas same as in getCroppedData
            const rotCanvas = document.createElement('canvas');
            const rotCtx = rotCanvas.getContext('2d');
            if (norm === 90 || norm === 270) { rotCanvas.width = ih; rotCanvas.height = iw; } else { rotCanvas.width = iw; rotCanvas.height = ih; }
            rotCtx.translate(rotCanvas.width / 2, rotCanvas.height / 2);
            rotCtx.rotate(norm * Math.PI / 180);
            if (scaledSourceCanvas) rotCtx.drawImage(scaledSourceCanvas, -iw / 2, -ih / 2); else rotCtx.drawImage(imgEl, -iw / 2, -ih / 2);

            const srcX = Math.max(0, Math.round((-posX) / currentScale));
            const srcY = Math.max(0, Math.round((-posY) / currentScale));
            const srcW = Math.round(bw / currentScale);
            const srcH = Math.round(bh / currentScale);
            const rIw = rotCanvas.width, rIh = rotCanvas.height;
            const adjSrcW = Math.min(srcW, Math.max(0, rIw - srcX));
            const adjSrcH = Math.min(srcH, Math.max(0, rIh - srcY));

            const outCanvas = document.createElement('canvas');
            outCanvas.width = px; outCanvas.height = px;
            const outCtx = outCanvas.getContext('2d');
            try { outCtx.drawImage(rotCanvas, srcX, srcY, adjSrcW, adjSrcH, 0, 0, px, px); } catch (err) { try { outCtx.drawImage(rotCanvas, 0, 0, rIw, rIh, 0, 0, px, px); } catch (e) { console.error('viewport draw failed', e); } }
            return outCanvas.toDataURL('image/jpeg', 0.85);
        } catch (e) { console.error('renderViewportPreview error', e); return null; }
    }

    async function performPreviewRefresh() {
        _previewRefreshTimer = null;
        try {
            // Prefer using the viewport component export if present so preview exactly
            // matches the final raster that will be uploaded.
            const avatarCroppedInputEl = document.getElementById('avatarCroppedInput');
            const vpEl = document.querySelector('.viewport-viewport');
            const outSizeEl = document.getElementById('avatarOutputSize');
            const outSizeVal = outSizeEl ? parseInt(outSizeEl.value || '', 10) : null;
            const ringEl = document.getElementById('avatarRing');
            const ringSize = ringEl ? Math.max(24, Math.round(Math.min(ringEl.clientWidth || 110, 200))) : 110;

            if (vpEl && vpEl.__vp && typeof vpEl.__vp.exportCropped === 'function') {
                try {
                    // full-size (or configured) raster for server
                    const full = await vpEl.__vp.exportCropped(outSizeVal || null);
                    if (avatarCroppedInputEl) avatarCroppedInputEl.value = full;
                    // small ring-sized preview
                    const ringPreviewData = await vpEl.__vp.exportCropped(ringSize);
                    if (ringPreviewData && preview) {
                        preview.style.transition = '';
                        preview.style.transform = '';
                        preview.src = ringPreviewData;
                        preview.style.display = 'block';
                        if (initial) initial.style.display = 'none';
                    }
                    // ALSO: rasterize a display-sized preview for the viewport itself so
                    // what the user sees in the editor equals the exported raster.
                    try {
                        const displayEl = cropBox || vpEl; // prefer cropBox dimensions
                        const displayPx = Math.max(100, Math.min(1200, Math.round((displayEl && displayEl.clientWidth) || (outSizeVal || 300))));
                        // Instead of replacing the viewport's internal image (which
                        // would break pointer interactions), create or update a
                        // non-interactive overlay image that visually matches the
                        // exported raster. This lets users still drag/zoom the
                        // viewport while showing the final rasterized preview.
                        try {
                            // Remove any previously created overlay so nothing is shown
                            const old = vpEl.querySelector('.viewport-overlay-raster');
                            if (old && old.remove) old.remove();
                        } catch (e) {
                            console.warn('failed to remove viewport overlay', e);
                        }
                    } catch (e) {
                        console.warn('viewport display rasterization failed', e);
                    }
                    return;
                } catch (e) {
                    console.warn('viewport preview export failed, falling back', e);
                }
            }

            // Legacy fallback: use cropper's rasterized output
            const res = typeof getCroppedData === 'function' ? getCroppedData() : null;
            if (!res || !res.dataUrl) return;
            if (avatarCroppedInputEl) avatarCroppedInputEl.value = res.dataUrlFull || res.dataUrl;
            // fallback viewport-sized preview using existing renderer
            const vp = renderViewportPreview(ringSize);
            if (vp && preview) {
                preview.style.transition = '';
                preview.style.transform = '';
                preview.src = vp;
                preview.style.display = 'block';
                if (initial) initial.style.display = 'none';
            } else if (preview) {
                preview.style.transition = '';
                preview.style.transform = '';
                preview.src = res.dataUrl;
                preview.style.display = 'block';
                if (initial) initial.style.display = 'none';
            }
        } catch (e) { console.error('performPreviewRefresh failed', e); }
    }

    // Zoom +/- handlers
    if (zoomMinus) zoomMinus.addEventListener('click', function () {
        if (!zoomRange) return; const step = parseFloat(zoomRange.step || '0.05'); let v = parseFloat(zoomRange.value || '1'); v = Math.max(parseFloat(zoomRange.min || '0.5'), v - step); zoomRange.value = v; zoomRange.dispatchEvent(new Event('input'));
    });
    if (zoomPlus) zoomPlus.addEventListener('click', function () {
        if (!zoomRange) return; const step = parseFloat(zoomRange.step || '0.05'); let v = parseFloat(zoomRange.value || '1'); v = Math.min(parseFloat(zoomRange.max || '2.5'), v + step); zoomRange.value = v; zoomRange.dispatchEvent(new Event('input'));
    });

    const cropSizeSelect = document.getElementById('avatarCropSize');
    const cropSizeError = document.getElementById('avatarCropSizeError');
    function cropSize() {
        const wEl = document.getElementById('avatarCropWidth');
        const hEl = document.getElementById('avatarCropHeight');
        const outEl = document.getElementById('avatarOutputSize');
        const defaultVal = 260;
        let w = wEl ? parseInt(wEl.value || defaultVal, 10) : defaultVal;
        let h = hEl ? parseInt(hEl.value || defaultVal, 10) : defaultVal;
        const minW = parseInt(wEl ? (wEl.getAttribute('min') || '100') : '100', 10);
        const maxW = parseInt(wEl ? (wEl.getAttribute('max') || '1200') : '1200', 10);
        const minH = parseInt(hEl ? (hEl.getAttribute('min') || '100') : '100', 10);
        const maxH = parseInt(hEl ? (hEl.getAttribute('max') || '1200') : '1200', 10);
        if (isNaN(w)) w = defaultVal; if (isNaN(h)) h = defaultVal;
        let cw = Math.min(Math.max(w, minW), maxW);
        let ch = Math.min(Math.max(h, minH), maxH);
        if (wEl) wEl.value = cw; if (hEl) hEl.value = ch;
        if (cropSizeError) {
            // hide previous
            cropSizeError.style.display = 'none';
        }
        const out = outEl ? parseInt(outEl.value || defaultVal, 10) : defaultVal;
        // if crop is square, enable circular preview style
        try {
            if (cropBox) {
                if (cw === ch) {
                    cropBox.classList.add('circular');
                } else {
                    cropBox.classList.remove('circular');
                }
            }
        } catch (e) {}
        return { w: cw, h: ch, out: out };
    }

    // helper to resize crop box responsively
    function resizeCropBox(size) {
        if (!cropBox) return;
        const parent = cropBox.parentElement || cropBox.parentNode;
        const parentWidth = parent ? parent.clientWidth : window.innerWidth;
        // compute a sensible max available width so controls remain visible
        // prefer to reserve space for the controls column (measured when available)
        const controlsEl = parent.querySelector ? parent.querySelector('.avatar-controls') : null;
        const controlsMin = (controlsEl && controlsEl.clientWidth) ? controlsEl.clientWidth : 340;
        const gutter = 24; // minimal gap between cropper and controls
        const viewportLimit = Math.floor(window.innerWidth * 0.6); // allow slightly more room on wide screens
        const parentLimit = Math.floor(parentWidth * 0.9); // leave small gutter
        const maxAvailable = Math.max(120, Math.min(parentWidth - controlsMin - gutter, viewportLimit, parentLimit));
        // maintain aspect ratio from requested size (w:h)
        const aspect = (size && size.w && size.h) ? (size.h / size.w) : 1;
        // If requested crop width exceeds available side-by-side space,
        // allow the cropper to expand and stack controls below for a larger preview.
        let displayW;
        if (size && size.w > maxAvailable) {
            const stackedMax = Math.floor(window.innerWidth * 0.9); // allow up to 90% of viewport when stacked
            const hardCap = Math.max(600, Math.min(900, Math.floor(window.innerWidth * 0.95)));
            displayW = Math.min(size.w, stackedMax, hardCap);
        } else {
            displayW = Math.min(size.w, maxAvailable);
        }
        displayW = Math.max(120, displayW);
        let displayH = Math.round(displayW * aspect);
        // ensure not taller than a reasonable viewport fraction
        const vhLimit = Math.floor(window.innerHeight * 0.7);
        if (displayH > vhLimit) {
            displayH = vhLimit;
            displayW = Math.max(120, Math.round(displayH / aspect));
        }
        cropBox.style.width = displayW + 'px';
        cropBox.style.height = displayH + 'px';
        // if cropper is using most of the available width, stack controls below to give it space
        try {
            const flexParent = parent.classList && parent.classList.contains('avatar-edit-flex') ? parent : parent.closest('.avatar-edit-flex');
            if (flexParent) {
                if (displayW >= Math.floor(maxAvailable * 0.9) || window.innerWidth < 900) {
                    flexParent.style.flexDirection = 'column';
                    // center cropper when stacked
                    cropBox.style.margin = '0 auto 1rem auto';
                    const controls = flexParent.querySelector('.avatar-controls'); if (controls) controls.style.width = '100%';
                } else {
                    flexParent.style.flexDirection = 'row';
                    cropBox.style.margin = '';
                    const controls = flexParent.querySelector('.avatar-controls'); if (controls) controls.style.width = '';
                }
            }
        } catch (e) { /* ignore styling errors */ }
    }

    // compute rotated image dimensions given currentRotation
    function getRotatedDims(rotationDeg, naturalW, naturalH) {
        const norm = ((rotationDeg % 360) + 360) % 360;
        if (norm === 90 || norm === 270) return { w: naturalH, h: naturalW };
        return { w: naturalW, h: naturalH };
    }

    // enforce that the image always fully covers the crop box
    function enforceCoverage() {
        if (!cropImg || !cropBox) return;
        const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
        const dims = getRotatedDims(currentRotation, cropImg.naturalWidth || 0, cropImg.naturalHeight || 0);
        const rotatedW = dims.w, rotatedH = dims.h;
        // minimal scale so rotated image covers the box
        const minScale = Math.max(MIN_INITIAL_SCALE, Math.max(bw / Math.max(1, rotatedW), bh / Math.max(1, rotatedH)));
        if (currentScale < minScale) {
            // scale about center
            const cx = bw / 2, cy = bh / 2;
            posX = cx - ((cx - posX) * (minScale / currentScale));
            posY = cy - ((cy - posY) * (minScale / currentScale));
            currentScale = minScale;
            if (zoomRange) zoomRange.value = currentScale;
        }
        const dispW = rotatedW * currentScale, dispH = rotatedH * currentScale;
        // allowed posX range so image covers box: posX in [bw - dispW, 0]
        const minX = Math.min(0, bw - dispW);
        const maxX = 0;
        const minY = Math.min(0, bh - dispH);
        const maxY = 0;
        if (posX < minX) posX = minX;
        if (posX > maxX) posX = maxX;
        if (posY < minY) posY = minY;
        if (posY > maxY) posY = maxY;
    }

    // initialize crop box size from selector (responsive) and update on resize
    resizeCropBox(cropSize());
    window.addEventListener('resize', function () {
        resizeCropBox(cropSize());
        enforceCoverage();
        applyTransform();
    });

    if (cropSizeSelect) {
        // respond to input and change events, keep value within min/max
        const onCropSizeChange = function () {
            const newSize = cropSize();
            // recenter image using current scale
            const bw = newSize.w, bh = newSize.h;
            const iw = (cropImg.naturalWidth || 0) * currentScale;
            const ih = (cropImg.naturalHeight || 0) * currentScale;
            posX = (bw - iw) / 2;
            posY = (bh - ih) / 2;
            resizeCropBox(newSize);
            applyTransform();
        };
        cropSizeSelect.addEventListener('input', onCropSizeChange);
        cropSizeSelect.addEventListener('change', onCropSizeChange);
    }

    // Make direct W/H/Salida inputs reactive so their arrows/buttons update the preview immediately.
    (function () {
        const wEl = document.getElementById('avatarCropWidth');
        const hEl = document.getElementById('avatarCropHeight');
        const outEl = document.getElementById('avatarOutputSize');
        if (!wEl && !hEl && !outEl) return;

        const onInputChange = function () {
            const newSize = cropSize();
            // recenter image using current scale and rotated dims
            const bw = newSize.w, bh = newSize.h;
            const dims = getRotatedDims(currentRotation, cropImg.naturalWidth || 0, cropImg.naturalHeight || 0);
            // center based on displayed size of rotated image
            posX = (bw - dims.w * currentScale) / 2;
            posY = (bh - dims.h * currentScale) / 2;
            resizeCropBox(newSize);
            enforceCoverage();
            applyTransform();
        };

        ['input','change'].forEach(ev => {
            if (wEl) wEl.addEventListener(ev, onInputChange);
            if (hEl) hEl.addEventListener(ev, onInputChange);
            if (outEl) outEl.addEventListener(ev, onInputChange);
        });
    })();

    // Preset size buttons
    (function () {
        const presetContainer = document.getElementById('avatarPresetSizes');
        if (!presetContainer) return;
        presetContainer.addEventListener('click', function (ev) {
            const btn = ev.target.closest('.avatar-crop-preset');
            if (!btn) return;
            const w = parseInt(btn.getAttribute('data-w') || '260', 10);
            const h = parseInt(btn.getAttribute('data-h') || String(w), 10);
            const wEl = document.getElementById('avatarCropWidth');
            const hEl = document.getElementById('avatarCropHeight');
            const outEl = document.getElementById('avatarOutputSize');
            if (wEl) wEl.value = Math.min(Math.max(w, parseInt(wEl.min || '100', 10)), parseInt(wEl.max || '1200', 10));
            if (hEl) hEl.value = Math.min(Math.max(h, parseInt(hEl.min || '100', 10)), parseInt(hEl.max || '1200', 10));
            if (outEl) outEl.value = Math.min(Math.max(Math.min(w, h), parseInt(outEl.min || '64', 10)), parseInt(outEl.max || '800', 10));
            // apply change and recenter image
            const newSize = cropSize();
            // center image
            const bw = newSize.w, bh = newSize.h;
            const dims = getRotatedDims(currentRotation, cropImg.naturalWidth || 0, cropImg.naturalHeight || 0);
            posX = (bw - dims.w * currentScale) / 2;
            posY = (bh - dims.h * currentScale) / 2;
            resizeCropBox(newSize);
            enforceCoverage();
            applyTransform();
            // If viewport component present, try to reflect preset in the viewport size/aspect
            try {
                const vpEl = document.querySelector('.viewport-viewport');
                if (vpEl && vpEl.__vp) {
                    // map preset to utility class names
                    const map = {
                        '100x100': 'vp-size-100',
                        '200x200': 'vp-size-200',
                        '260x260': 'vp-size-260',
                        '400x300': 'vp-size-400x300',
                        '800x600': 'vp-size-800x600'
                    };
                    const key = String(w) + 'x' + String(h);
                    const cls = map[key] || null;
                    // remove any existing vp-size-* classes
                    Array.from(vpEl.classList).filter(c => c.indexOf('vp-size-') === 0).forEach(c => vpEl.classList.remove(c));
                    if (cls) {
                        vpEl.classList.add(cls);
                    } else {
                        // fallback: for unknown sizes, keep responsive max and set inline temporarily
                        vpEl.style.width = Math.min(w, Math.min(window.innerWidth * 0.8, 600)) + 'px';
                        vpEl.style.height = Math.min(h, Math.min(window.innerWidth * 0.8, 600 * (h/w))) + 'px';
                    }
                    // toggle circular visual for square presets
                    if (w === h) vpEl.classList.add('vp-circle'); else vpEl.classList.remove('vp-circle');
                    // notify instance to recompute constraints
                    try { vpEl.__vp.constrain(); vpEl.__vp.update(); } catch (e) {}
                }
            } catch (e) { /* ignore */ }
        });
    })();

    // open editor in modal and trigger file input
    function openAvatarModal() {
        let overlay = document.getElementById('avatarModalOverlay');
        if (!overlay) {
            overlay = document.createElement('div'); overlay.id = 'avatarModalOverlay'; overlay.className = 'avatar-modal-overlay';
            const modal = document.createElement('div'); modal.className = 'avatar-modal'; modal.innerHTML = '<div class="modal-header"><div class="modal-title">Editar foto de perfil</div><button class="modal-close" id="avatarModalClose">×</button></div>';
            const modalBody = document.createElement('div'); modalBody.className = 'modal-body';
            modal.appendChild(modalBody); overlay.appendChild(modal); document.body.appendChild(overlay);
            document.getElementById('avatarModalClose').addEventListener('click', closeAvatarModal);
        }
        const modalBody = overlay.querySelector('.modal-body');
        // move editOptions into modal
        modalBody.appendChild(editOptions);
        // mark cropper for modal-mode so CSS shows large circular mask
        try { cropBox.classList.add('modal-mode'); } catch (e) {}
        overlay.classList.add('show'); document.body.style.overflow = 'hidden';
    }

    function closeAvatarModal() {
        const overlay = document.getElementById('avatarModalOverlay');
        if (!overlay) return;
        // move editOptions back to original place inside avatar-upload-wrap
        const avatarWrap = document.querySelector('.avatar-upload-wrap');
        avatarWrap.appendChild(editOptions);
        // remove modal-mode class
        try { cropBox.classList.remove('modal-mode'); } catch (e) {}
        overlay.classList.remove('show'); document.body.style.overflow = ''; overlay.remove();
    }

    // Open file picker first; show modal only after a file is selected.
    ring.addEventListener('click', function () { input.click(); });

    // keep behavior simple: overlay shown only by CSS :hover

    input.addEventListener('change', function () {
        const file = this.files && this.files[0];
        avatarError.style.display = 'none';
        // If user cancelled file selection, close any leftover modal and exit
        if (!file) {
            const overlay = document.getElementById('avatarModalOverlay');
            if (overlay) { overlay.classList.remove('show'); document.body.style.overflow = ''; overlay.remove(); }
            return;
        }
        // Generate a center-cropped square preview that matches server's final output
        try {
            const readerPreview = new FileReader();
            readerPreview.onload = function (ev) {
                const imgTemp = new Image();
                imgTemp.onload = function () {
                    // determine desired output size from input or default
                    const outSizeEl = document.getElementById('avatarOutputSize');
                    let outSize = outSizeEl ? parseInt(outSizeEl.value || '300', 10) : 300;
                    if (!outSize || isNaN(outSize)) outSize = 300;
                    // create square canvas and draw image to cover (center-crop)
                    const cw = outSize, ch = outSize;
                    const c = document.createElement('canvas'); c.width = cw; c.height = ch;
                    const ctx = c.getContext('2d');
                    // compute scale to cover
                    const scale = Math.max(cw / imgTemp.naturalWidth, ch / imgTemp.naturalHeight);
                    const sw = Math.round(cw / scale); const sh = Math.round(ch / scale);
                    const sx = Math.round((imgTemp.naturalWidth - sw) / 2);
                    const sy = Math.round((imgTemp.naturalHeight - sh) / 2);
                    try { ctx.drawImage(imgTemp, sx, sy, sw, sh, 0, 0, cw, ch); } catch (e) { try { ctx.drawImage(imgTemp, 0, 0, imgTemp.naturalWidth, imgTemp.naturalHeight, 0, 0, cw, ch); } catch (ee) { console.error('preview draw failed', ee); } }
                    const previewData = c.toDataURL('image/jpeg', 0.85);
                    // set preview in ring
                    const ringPreview = document.getElementById('avatarPreview');
                    const avatarInitial = document.getElementById('avatarInitial');
                    if (ringPreview) { ringPreview.src = previewData; ringPreview.style.display = 'block'; }
                    if (avatarInitial) { avatarInitial.style.display = 'none'; }
                    // put base64 in hidden input so server can save exactly this preview
                    const avatarCroppedInputEl = document.getElementById('avatarCroppedInput');
                    if (avatarCroppedInputEl) avatarCroppedInputEl.value = previewData;
                };
                imgTemp.src = ev.target.result;
            };
            readerPreview.readAsDataURL(file);
        } catch (e) { console.error('preview generation failed', e); }

        if (!ALLOWED.includes(file.type)) {
            avatarError.textContent = 'Tipo de archivo no válido. Usa JPG, PNG o WEBP.';
            avatarError.style.display = 'block';
            input.value = '';
            return;
        }
        if (file.size > MAX_BYTES) {
            avatarError.textContent = 'El archivo supera 2 MB. Reduzca el tamaño e intente de nuevo.';
            avatarError.style.display = 'block';
            input.value = '';
            return;
        }

        const reader = new FileReader();
        ring.classList.add('avatar-loading');
        reader.onload = function (e) {
            const originalData = e.target.result;
            // load into a temporary Image to decide whether to downscale
            const tmp = new Image();
            tmp.onload = function () {
                const iw0 = tmp.naturalWidth || 0, ih0 = tmp.naturalHeight || 0;
                const MAX_RENDER_DIM = 1600; // clamp for in-memory processing
                scaledSourceCanvas = null; scaledIw = 0; scaledIh = 0;
                if (Math.max(iw0, ih0) > MAX_RENDER_DIM) {
                    const factor = Math.max(1, Math.max(iw0, ih0) / MAX_RENDER_DIM);
                    scaledIw = Math.max(1, Math.round(iw0 / factor));
                    scaledIh = Math.max(1, Math.round(ih0 / factor));
                    const sC = document.createElement('canvas'); sC.width = scaledIw; sC.height = scaledIh;
                    const sCtx = sC.getContext('2d');
                    sCtx.drawImage(tmp, 0, 0, scaledIw, scaledIh);
                    // keep scaled canvas for processing (rotations/exports)
                    scaledSourceCanvas = sC;
                    // use scaled data URL for the visible image to reduce memory/CPU on transforms
                    cropImg.src = sC.toDataURL('image/jpeg', 0.9);
                } else {
                    // small enough — use original directly
                    cropImg.src = originalData;
                }
                // once cropImg has new src, wait for it to be ready
                cropImg.onload = function () {
                    // choose dimensions from scaled canvas when available
                    const iw = scaledSourceCanvas ? scaledIw : (cropImg.naturalWidth || 0);
                    const ih = scaledSourceCanvas ? scaledIh : (cropImg.naturalHeight || 0);
                    const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
                    // Default: show image at natural size (scale = 1)
                    currentScale = 1;
                    // If requested crop is larger than available side-by-side space, stack controls and expand preview
                    try {
                        const requested = cropSize();
                        const parent = cropBox.parentElement || cropBox.parentNode;
                        const controlsEl = parent.querySelector ? parent.querySelector('.avatar-controls') : null;
                        const controlsMin = (controlsEl && controlsEl.clientWidth) ? controlsEl.clientWidth : 340;
                        const gutter = 24;
                        const sideBySideAvailable = Math.max(120, Math.min(parent.clientWidth - controlsMin - gutter, Math.floor(window.innerWidth * 0.6), Math.floor(parent.clientWidth * 0.9)));
                        const flexParent = parent.classList && parent.classList.contains('avatar-edit-flex') ? parent : parent.closest('.avatar-edit-flex');
                        if (requested && requested.w > sideBySideAvailable && flexParent) {
                            flexParent.style.flexDirection = 'column';
                            // ensure controls occupy full width below
                            if (controlsEl) controlsEl.style.width = '100%';
                            // recompute crop box to allow larger stacked preview
                            resizeCropBox(requested);
                        } else {
                            if (flexParent) { flexParent.style.flexDirection = 'row'; if (controlsEl) controlsEl.style.width = ''; }
                        }
                    } catch (e) { /* ignore layout errors */ }
                    // After layout adjustments, ensure image covers the crop box if needed (zoom-in)
                    const bw2 = cropBox.clientWidth, bh2 = cropBox.clientHeight;
                    const scaleToCover = Math.max(bw2 / Math.max(1, iw), bh2 / Math.max(1, ih));
                    if (scaleToCover > currentScale) currentScale = scaleToCover;
                    if (zoomRange) zoomRange.value = currentScale;
                    // center based on rotated dims
                    const dims = getRotatedDims(currentRotation, iw, ih);
                    posX = (bw - dims.w * currentScale) / 2;
                    posY = (bh - dims.h * currentScale) / 2;
                    // ensure pointer behavior and prevent native dragging
                    try { cropImg.style.touchAction = 'none'; } catch (e) {}
                    try { cropImg.setAttribute('draggable', 'false'); } catch (e) {}
                    currentRotation = 0;
                    enforceCoverage();
                    applyTransform();
                    editOptions.style.display = 'block';
                    ring.classList.remove('avatar-loading');
                };
            };
            tmp.src = originalData;
        };
        reader.readAsDataURL(file);
    });

    // pointer drag on crop image (legacy) — skip if viewport component is active
    try {
        const _hasViewport = !!document.querySelector('.viewport-viewport');
        cropImg.addEventListener('pointerdown', function (e) {
            if (_hasViewport) return; // viewport handles dragging
            isDragging = true; startX = e.clientX; startY = e.clientY;
            try { if (typeof e.pointerId !== 'undefined' && cropImg.setPointerCapture) cropImg.setPointerCapture(e.pointerId); } catch (err) { /* ignore */ }
        });
        window.addEventListener('pointermove', function (e) {
            if (_hasViewport) return; // viewport handles movement
            if (!isDragging) return;
            const dx = e.clientX - startX; const dy = e.clientY - startY;
            startX = e.clientX; startY = e.clientY;
            posX += dx; posY += dy;
            // enforce strict coverage
            enforceCoverage();
            applyTransform();
        });
        window.addEventListener('pointerup', function (e) {
            if (_hasViewport) return;
            isDragging = false;
            try { if (typeof e.pointerId !== 'undefined' && cropImg.releasePointerCapture) cropImg.releasePointerCapture(e.pointerId); } catch (err) { /* ignore */ }
        });
    } catch (e) { /* ignore if cropImg missing */ }

    if (zoomRange) {
        // ensure zoom control respects minimum configured initial scale
        try { zoomRange.min = String(MIN_INITIAL_SCALE); } catch (e) {}
        zoomRange.addEventListener('input', function () {
            const newScale = parseFloat(this.value);
            // If viewport component is present, apply scale via its API and update
            const vpEl = document.querySelector('.viewport-viewport');
            if (vpEl && vpEl.__vp) {
                try {
                    // apply scale to viewport instance
                    vpEl.__vp.scale = Math.max(parseFloat(vpEl.__vp.minScale || MIN_INITIAL_SCALE), newScale);
                    if (typeof vpEl.__vp.constrain === 'function') vpEl.__vp.constrain();
                    if (typeof vpEl.__vp.update === 'function') vpEl.__vp.update();
                } catch (e) {
                    console.warn('viewport scale update failed', e);
                }
                // make sure the raster preview updates to reflect viewport state
                schedulePreviewRefresh();
                return;
            }

            // Legacy behaviour (cropImg-based): scale about center of crop box
            const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
            const cx = bw / 2, cy = bh / 2;
            const dims = getRotatedDims(currentRotation, cropImg.naturalWidth || 0, cropImg.naturalHeight || 0);
            const minScale = Math.max(MIN_INITIAL_SCALE, Math.max(bw / Math.max(1, dims.w), bh / Math.max(1, dims.h)));
            let appliedScale = newScale;
            if (newScale < minScale) {
                appliedScale = minScale;
                if (zoomWarningEl) {
                    zoomWarningEl.classList.add('blink-warning');
                    setTimeout(() => { zoomWarningEl.classList.remove('blink-warning'); }, 500);
                }
            }
            posX = cx - ((cx - posX) * (appliedScale / currentScale));
            posY = cy - ((cy - posY) * (appliedScale / currentScale));
            currentScale = appliedScale;
            if (zoomRange) zoomRange.value = currentScale;
            enforceCoverage();
            applyTransform();
        });
    }

    // rotation feature removed — no handler necessary

    // telemetry: push to dataLayer (if available) and POST to /telemetry endpoint
    function sendTelemetry(eventName, extra) {
        const payload = {
            event: eventName,
            user_id: TELEMETRY_USER_ID || null,
            crop_size: cropSize(),
            current_scale: currentScale,
            timestamp: new Date().toISOString(),
            extra: extra || {}
        };

        // dataLayer push (GTM)
        try {
            if (window.dataLayer && typeof window.dataLayer.push === 'function') {
                window.dataLayer.push(Object.assign({ event: eventName }, payload));
            }
        } catch (e) { console.debug('dataLayer push failed', e); }

        // non-blocking POST
        try {
            fetch('{{ url('/telemetry') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': TELEMETRY_CSRF,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload),
                keepalive: true
            }).catch(err => { console.debug('telemetry POST failed', err); });
        } catch (e) { console.debug('telemetry fetch failed', e); }
    }

    if (editCancel) editCancel.addEventListener('click', function () { input.value = ''; editOptions.style.display = 'none'; avatarError.style.display = 'none'; });

    // remove handler
    if (removeBtn) {
        removeBtn.addEventListener('click', function () {
            if (!form) return; if (!confirm('¿Eliminar foto de perfil? Esta acción no se puede deshacer.')) return; removeInput.value = '1'; form.submit();
        });
    }

    // save: generate cropped data and submit
    if (editSave) {
        // helper to generate cropped canvases and data URLs
        function getCroppedData() {
            const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
            const img = cropImg;
            if (!img.src) return null;
            const canvas = document.createElement('canvas');
            canvas.width = bw; canvas.height = bh;
            const ctx = canvas.getContext('2d');
            const imgEl = img;
            const norm = ((currentRotation % 360) + 360) % 360;
            const iw = scaledSourceCanvas ? scaledIw : (imgEl.naturalWidth || 0), ih = scaledSourceCanvas ? scaledIh : (imgEl.naturalHeight || 0);
            const rotCanvas = document.createElement('canvas');
            const rotCtx = rotCanvas.getContext('2d');
            if (norm === 90 || norm === 270) { rotCanvas.width = ih; rotCanvas.height = iw; } else { rotCanvas.width = iw; rotCanvas.height = ih; }
            rotCtx.translate(rotCanvas.width / 2, rotCanvas.height / 2);
            rotCtx.rotate(norm * Math.PI / 180);
            if (scaledSourceCanvas) rotCtx.drawImage(scaledSourceCanvas, -iw / 2, -ih / 2); else rotCtx.drawImage(imgEl, -iw / 2, -ih / 2);
            const srcX = Math.max(0, Math.round((-posX) / currentScale));
            const srcY = Math.max(0, Math.round((-posY) / currentScale));
            const srcW = Math.round(bw / currentScale);
            const srcH = Math.round(bh / currentScale);
            const rIw = rotCanvas.width, rIh = rotCanvas.height;
            const adjSrcW = Math.min(srcW, Math.max(0, rIw - srcX));
            const adjSrcH = Math.min(srcH, Math.max(0, rIh - srcY));
            try { ctx.drawImage(rotCanvas, srcX, srcY, adjSrcW, adjSrcH, 0, 0, bw, bh); } catch (err) { console.error('drawImage failed (rotated)', err); }
            // determine output size
            const outWEl = document.getElementById('avatarCropWidth');
            const outHEl = document.getElementById('avatarCropHeight');
            const outSizeEl = document.getElementById('avatarOutputSize');
            let outW = outWEl ? parseInt(outWEl.value || String(bw), 10) : null;
            let outH = outHEl ? parseInt(outHEl.value || String(bh), 10) : null;
            if ((!outW || isNaN(outW)) && outSizeEl) outW = parseInt(outSizeEl.value || String(bw), 10);
            if ((!outH || isNaN(outH)) && outSizeEl) outH = parseInt(outSizeEl.value || String(bh), 10);
            if (!outW || isNaN(outW) || outW < 16) outW = bw;
            if (!outH || isNaN(outH) || outH < 16) outH = bh;
            const minCrop = parseInt('{{ config("avatar.crop_min", 100) }}', 10) || 100;
            const maxCrop = parseInt('{{ config("avatar.crop_max", 800) }}', 10) || 800;
            outW = Math.min(Math.max(outW, minCrop), maxCrop);
            outH = Math.min(Math.max(outH, minCrop), maxCrop);
            const outCanvas = document.createElement('canvas'); outCanvas.width = outW; outCanvas.height = outH; const outCtx = outCanvas.getContext('2d');
            try { outCtx.drawImage(canvas, 0, 0, bw, bh, 0, 0, outW, outH); } catch (err) { try { outCtx.drawImage(rotCanvas, srcX, srcY, adjSrcW, adjSrcH, 0, 0, outW, outH); } catch (e) { console.error('fallback draw failed', e); } }
            const dataUrlFull = canvas.toDataURL('image/jpeg', 0.9);
            const dataUrl = outCanvas.toDataURL('image/jpeg', 0.85);
            return { dataUrl, dataUrlFull, outW, outH };
        }

        editSave.addEventListener('click', async function () {
            // Simplified save: export final cropped data URL (full size when possible),
            // write it to the hidden `avatar_cropped` input and submit the form.
            try {
                if (removeInput) removeInput.value = '0';
                // close modal if open
                const overlay = document.getElementById('avatarModalOverlay');
                if (overlay) { overlay.classList.remove('show'); document.body.style.overflow = ''; overlay.remove(); }

                let dataUrl = null;
                const vpEl = document.querySelector('.viewport-viewport');
                const outSizeEl = document.getElementById('avatarOutputSize');
                const outSizeVal = outSizeEl ? parseInt(outSizeEl.value || '', 10) : null;
                if (vpEl && vpEl.__vp && typeof vpEl.__vp.exportCropped === 'function') {
                    try { dataUrl = await vpEl.__vp.exportCropped(outSizeVal || null); } catch (e) { console.warn('viewport export failed', e); }
                }

                if (!dataUrl) {
                    const avatarCroppedInputEl = document.getElementById('avatarCroppedInput');
                    if (avatarCroppedInputEl && avatarCroppedInputEl.value) dataUrl = avatarCroppedInputEl.value;
                    else {
                        try { const res = typeof getCroppedData === 'function' ? getCroppedData() : null; if (res) dataUrl = res.dataUrlFull || res.dataUrl; } catch (e) { /* ignore */ }
                    }
                }

                if (!dataUrl) {
                    if (input && input.files && input.files[0]) { form.submit(); return; }
                    alert('Seleccione una imagen antes de colocar la foto.');
                    return;
                }

                const avatarCroppedInputEl = document.getElementById('avatarCroppedInput');
                if (avatarCroppedInputEl) avatarCroppedInputEl.value = dataUrl;

                const avatarRotationInput = document.getElementById('avatarRotationInput');
                const avatarScaleInput = document.getElementById('avatarScaleInput');
                if (avatarRotationInput) avatarRotationInput.value = String(currentRotation);
                if (avatarScaleInput) avatarScaleInput.value = String(currentScale);

                form.submit();
            } catch (err) {
                console.error('avatar save error', err);
                alert('Error al preparar la imagen. Inténtalo de nuevo.');
            }
        });
    }

    // Use temporarily: set preview but do not submit
    const useTempBtn = document.getElementById('avatarUseTemp');
    if (useTempBtn) {
        useTempBtn.addEventListener('click', function () {
            try {
                const res = getCroppedData();
                if (!res) return;
                if (preview) { preview.src = res.dataUrl; preview.style.display = 'block'; if (initial) initial.style.display = 'none'; }
                // keep hidden input in case server needs fallback
                if (avatarCroppedInput) avatarCroppedInput.value = res.dataUrlFull;
                const avatarRotationInput = document.getElementById('avatarRotationInput');
                const avatarScaleInput = document.getElementById('avatarScaleInput');
                if (avatarRotationInput) avatarRotationInput.value = String(currentRotation);
                if (avatarScaleInput) avatarScaleInput.value = String(currentScale);
                // hide editor but do not submit
                editOptions.style.display = 'none';
            } catch (e) { console.error('useTemp error', e); }
        });
    }

    // Keyboard handlers for moving and zooming while editor is open
    window.addEventListener('keydown', function (ev) {
        if (!editOptions || editOptions.style.display === 'none') return;
        const step = ev.shiftKey ? 20 : 6;
        // Prefer controlling the viewport instance when available
        const vpEl = document.querySelector('.viewport-viewport');
        const vp = vpEl && vpEl.__vp ? vpEl.__vp : null;
        if (vp) {
            if (ev.key === 'ArrowLeft') { ev.preventDefault(); vp.pos.x -= step; if (typeof vp.constrain === 'function') try { vp.constrain(); } catch(e) {} if (typeof vp.update === 'function') try { vp.update(); } catch(e) {} schedulePreviewRefresh(); }
            if (ev.key === 'ArrowRight') { ev.preventDefault(); vp.pos.x += step; if (typeof vp.constrain === 'function') try { vp.constrain(); } catch(e) {} if (typeof vp.update === 'function') try { vp.update(); } catch(e) {} schedulePreviewRefresh(); }
            if (ev.key === 'ArrowUp') { ev.preventDefault(); vp.pos.y -= step; if (typeof vp.constrain === 'function') try { vp.constrain(); } catch(e) {} if (typeof vp.update === 'function') try { vp.update(); } catch(e) {} schedulePreviewRefresh(); }
            if (ev.key === 'ArrowDown') { ev.preventDefault(); vp.pos.y += step; if (typeof vp.constrain === 'function') try { vp.constrain(); } catch(e) {} if (typeof vp.update === 'function') try { vp.update(); } catch(e) {} schedulePreviewRefresh(); }
            if (ev.key === '+' || ev.key === '=' ) { ev.preventDefault(); vp.scale = Math.min((vp.maxScale||5), (vp.scale||1) + (ev.shiftKey ? 0.1 : 0.05)); if (typeof vp.constrain === 'function') try { vp.constrain(); } catch(e) {} if (typeof vp.update === 'function') try { vp.update(); } catch(e) {} schedulePreviewRefresh(); }
            if (ev.key === '-') { ev.preventDefault(); vp.scale = Math.max((vp.minScale||0.1), (vp.scale||1) - (ev.shiftKey ? 0.1 : 0.05)); if (typeof vp.constrain === 'function') try { vp.constrain(); } catch(e) {} if (typeof vp.update === 'function') try { vp.update(); } catch(e) {} schedulePreviewRefresh(); }
            if (ev.key === 'Enter') { ev.preventDefault(); if (editSave) editSave.click(); }
            return;
        }
        // Legacy fallback for cropImg-based flow
        if (ev.key === 'ArrowLeft') { ev.preventDefault(); posX += step; enforceCoverage(); applyTransform(); }
        if (ev.key === 'ArrowRight') { ev.preventDefault(); posX -= step; enforceCoverage(); applyTransform(); }
        if (ev.key === 'ArrowUp') { ev.preventDefault(); posY += step; enforceCoverage(); applyTransform(); }
        if (ev.key === 'ArrowDown') { ev.preventDefault(); posY -= step; enforceCoverage(); applyTransform(); }
        if (ev.key === '+' || ev.key === '=' ) { ev.preventDefault(); if (zoomRange) { let v = parseFloat(zoomRange.value||'1'); v = Math.min(parseFloat(zoomRange.max||'2.5'), v + parseFloat(zoomRange.step||'0.05')); zoomRange.value = v; zoomRange.dispatchEvent(new Event('input')); } }
        if (ev.key === '-') { ev.preventDefault(); if (zoomRange) { let v = parseFloat(zoomRange.value||'1'); v = Math.max(parseFloat(zoomRange.min||'0.5'), v - parseFloat(zoomRange.step||'0.05')); zoomRange.value = v; zoomRange.dispatchEvent(new Event('input')); } }
        if (ev.key === 'Enter') { ev.preventDefault(); if (editSave) editSave.click(); }
    }, true);

    // Mostrar toast y ocultar alert inline si existe
    (function () {
        var toastEl = document.getElementById('saveToast');
        if (toastEl && typeof bootstrap !== 'undefined') {
            try {
                var bsToast = new bootstrap.Toast(toastEl);
                bsToast.show();
            } catch (e) {
                console.error('Error mostrando toast:', e);
            }
        }

        // ocultar alert inline automáticamente tras 4s
        var inlineAlert = document.querySelector('.profile-card .alert');
        if (inlineAlert) {
            setTimeout(function () {
                if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                    try {
                        var bsAlert = bootstrap.Alert.getOrCreateInstance(inlineAlert);
                        bsAlert.close();
                    } catch (e) {
                        inlineAlert.classList.remove('show');
                        inlineAlert.style.display = 'none';
                    }
                } else {
                    inlineAlert.classList.remove('show');
                    inlineAlert.style.display = 'none';
                }
            }, 4000);
        }
    })();
    // Live validation for fecha_nacimiento (client-side immediate feedback)
    (function () {
        const fechaEl = document.getElementById('fecha_nacimiento');
        const feedbackEl = document.getElementById('fechaNacimientoFeedback');
        if (!fechaEl || !feedbackEl) return;
        function validateFecha() {
            const val = fechaEl.value;
            if (!val) { feedbackEl.style.display = 'none'; fechaEl.classList.remove('is-invalid'); return; }
            const min = fechaEl.getAttribute('min');
            const max = fechaEl.getAttribute('max');
            if (min && val < min) {
                feedbackEl.textContent = `La fecha de nacimiento no puede ser anterior a ${min}.`;
                feedbackEl.style.display = 'block';
                fechaEl.classList.add('is-invalid');
                return;
            }
            if (max && val > max) {
                feedbackEl.textContent = `La fecha de nacimiento no puede ser posterior a ${max}.`;
                feedbackEl.style.display = 'block';
                fechaEl.classList.add('is-invalid');
                return;
            }
            // valid
            feedbackEl.style.display = 'none';
            fechaEl.classList.remove('is-invalid');
        }
        fechaEl.addEventListener('input', validateFecha);
        fechaEl.addEventListener('change', validateFecha);
        // initial validate (in case server rendered an out-of-range value)
        validateFecha();
    })();

    // Initialize intl-tel-input and client-side phone/postal validation
    (function () {
        const telefonoEl = document.getElementById('telefono');
        const phoneCodeEl = document.getElementById('phone_code');
        const codigoPostalEl = document.getElementById('codigo_postal');
        if (!telefonoEl) return;

        // load intlTelInput if available (CDN script added below)
        try {
            const iti = window.intlTelInput ? window.intlTelInput(telefonoEl, {
                separateDialCode: false,
                initialCountry: 'auto',
                utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js'
            }) : null;

            function updatePhoneCode() {
                if (iti && typeof iti.getSelectedCountryData === 'function') {
                    const data = iti.getSelectedCountryData();
                    if (data && data.dialCode) {
                        phoneCodeEl.value = String(data.dialCode);
                    }
                }
            }

            // if server rendered a stored full phone like +57300111222, try set it
            const initialVal = telefonoEl.value || '';
            if (iti && initialVal.indexOf('+') === 0) {
                try { iti.setNumber(initialVal); } catch (e) { /* ignore */ }
            }

            // keep phone_code in sync when user changes country or number
            if (iti) {
                telefonoEl.addEventListener('countrychange', updatePhoneCode);
                telefonoEl.addEventListener('blur', updatePhoneCode);
                updatePhoneCode();
            }

            // postal code length map (mirror backend)
            const postalMap = { '57': 6, '1': 5, '34': 5 };
            function applyPostalRules() {
                const code = phoneCodeEl.value || '';
                if (code && postalMap[code]) {
                    codigoPostalEl.setAttribute('maxlength', String(postalMap[code]));
                    codigoPostalEl.setAttribute('pattern', `\\d{${postalMap[code]}}`);
                } else {
                    codigoPostalEl.removeAttribute('maxlength');
                    codigoPostalEl.setAttribute('pattern', '\\d{1,10}');
                }
            }
            if (codigoPostalEl) {
                telefonoEl.addEventListener('blur', applyPostalRules);
                phoneCodeEl.addEventListener('change', applyPostalRules);
                applyPostalRules();
            }

            // basic client-side validation before submit
            const formEl = document.getElementById('formRegistroUsuario');
            if (formEl) {
                formEl.addEventListener('submit', function (ev) {
                    // update phone_code one last time
                    updatePhoneCode();

                    // validate telefono digits length
                    const telDigits = (telefonoEl.value || '').replace(/\D+/g, '');
                    if (telDigits && (telDigits.length < 4 || telDigits.length > 15)) {
                        ev.preventDefault();
                        telefonoEl.classList.add('is-invalid');
                        alert('El número de teléfono debe tener entre 4 y 15 dígitos.');
                        return false;
                    }

                    // validate codigo_postal against pattern
                    if (codigoPostalEl && codigoPostalEl.value) {
                        const pat = codigoPostalEl.getAttribute('pattern');
                        if (pat) {
                            const re = new RegExp('^' + pat + '$');
                            if (!re.test(codigoPostalEl.value)) {
                                ev.preventDefault();
                                codigoPostalEl.classList.add('is-invalid');
                                alert('El código postal no cumple el formato esperado para el país seleccionado.');
                                return false;
                            }
                        }
                    }

                    return true;
                });
            }
        } catch (err) {
            console.debug('intl-tel-input init failed', err);
        }
    })();

});
</script>
<!-- intl-tel-input script -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
@endpush
