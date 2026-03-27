<?php $__env->startSection('titulo', 'Mi perfil - DiscZone'); ?>

<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/perfil-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container px-4 px-lg-5 pb-5 profile-page">
    <section class="profile-hero">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold mb-1"><span class="profile-title-icon"><i class="bi bi-person-circle"></i></span>Mi perfil</h1>
                <p class="mb-0">Gestiona tus datos personales y seguridad de acceso desde una vista individual para tu cuenta.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-light"><i class="bi bi-bar-chart-line me-1"></i> dashboard</a>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="profile-card p-3 p-lg-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
                
                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
                    <div id="saveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body"><?php echo e(session('success')); ?></div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('perfil.update')); ?>" method="POST" id="formRegistroUsuario" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="remove_avatar" id="removeAvatarInput" value="0">
                <input type="hidden" name="avatar_rotation" id="avatarRotationInput" value="0">
                <input type="hidden" name="avatar_scale" id="avatarScaleInput" value="1">
                <input type="hidden" name="avatar_cropped" id="avatarCroppedInput" value="">

                
                <div class="avatar-upload-wrap">
                    <div class="avatar-ring" id="avatarRing" title="Cambiar foto">
                        <?php if($registro->avatar): ?>
                            <img src="<?php echo e(asset('uploads/avatars/' . $registro->avatar)); ?>" id="avatarPreview" alt="Avatar">
                        <?php else: ?>
                            <div class="avatar-initial" id="avatarInitial"><?php echo e(strtoupper(mb_substr(trim($registro->name), 0, 1))); ?></div>
                            <img src="" id="avatarPreview" alt="Avatar" style="display:none;">
                        <?php endif; ?>
                        <div class="avatar-overlay"><i class="bi bi-camera-fill"></i></div>
                    </div>
                    <input type="file" name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/webp" class="d-none">
                    <span class="avatar-hint">Haz clic en la imagen para cambiar tu foto de perfil (JPG, PNG o WEBP, máx. 2 MB)</span>
                    <small id="avatarError" class="text-danger" style="display:none; margin-left:0;">Archivo no válido</small>
                    <div id="avatarEditOptions" style="display:none; margin-top: 1rem;">
                        <div class="mb-2">Previsualización y recorte:</div>
                        <div style="display:flex;align-items:flex-start;gap:1rem;">
                            <div class="avatar-cropper" style="width:260px;height:260px;overflow:hidden;border-radius:6px;border:1px solid var(--dz-border);position:relative;background:#f6f6f6;">
                                <img id="avatarCropImage" src="" alt="Crop" style="position:absolute; left:0; top:0; will-change:transform; transform-origin:0 0;">
                            </div>
                            <div style="flex:1">
                                    <div class="mb-2">
                                        <label class="form-label">Tamaño de recorte</label>
                                        <div style="display:flex;gap:.5rem;align-items:center;">
                                            <input id="avatarCropSize" name="avatar_crop_size" type="number" min="<?php echo e(config('avatar.crop_min', 100)); ?>" max="<?php echo e(config('avatar.crop_max', 800)); ?>" step="1" value="260" class="form-control form-control-sm" style="width:120px;">
                                            <div style="display:flex;flex-direction:column;gap:.25rem;">
                                                <small class="text-muted">Mín <?php echo e(config('avatar.crop_min', 100)); ?> — Máx <?php echo e(config('avatar.crop_max', 800)); ?> (px)</small>
                                                <small id="avatarCropSizeError" class="text-danger" style="display:none; font-size:0.85rem;"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Zoom</label>
                                        <div style="display:flex;align-items:center;gap:.5rem;">
                                            <input id="avatarZoom" type="range" min="0.5" max="2.5" step="0.01" value="1" class="form-range">
                                            <span id="avatarZoomWarning" class="text-warning" title="Has alcanzado el tamaño mínimo; la imagen cubre justo la caja" style="display:none;font-size:1.1rem;">&#9888;</span>
                                        </div>
                                    </div>
                                <div class="mb-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="avatarRotate">Rotar</button>
                                </div>
                                <div class="mb-2">
                                    <button type="button" class="btn btn-danger btn-sm" id="avatarRemove">Eliminar foto</button>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="avatarEditCancel">Cancelar</button>
                                    <button type="button" class="btn btn-primary btn-sm" id="avatarEditSave">Guardar foto</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', $registro->name ?? '')); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email', $registro->email ?? '')); ?>" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="telefono" name="telefono" value="<?php echo e(old('telefono', $registro->telefono ?? '')); ?>" placeholder="Ejemplo: +591 70000000">
                        <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="documento_identidad" class="form-label">Documento de identidad</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['documento_identidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="documento_identidad" name="documento_identidad" value="<?php echo e(old('documento_identidad', $registro->documento_identidad ?? '')); ?>" placeholder="CI, DNI o pasaporte">
                        <?php $__errorArgs = ['documento_identidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row">
                    <?php
                        $maxDate = \Carbon\Carbon::today()->format('Y-m-d');
                        $minDate = \Carbon\Carbon::today()->subYears(80)->format('Y-m-d');
                    ?>
                    <div class="col-md-4 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo e(old('fecha_nacimiento', optional($registro->fecha_nacimiento)->format('Y-m-d'))); ?>" min="<?php echo e($minDate); ?>" max="<?php echo e($maxDate); ?>">
                        <div class="form-text">Seleccione su fecha de nacimiento. Rango permitido: <?php echo e($minDate); ?> — <?php echo e($maxDate); ?>.</div>
                        <small id="fechaNacimientoFeedback" class="text-danger" style="display:none;"></small>
                        <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['ciudad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="ciudad" name="ciudad" value="<?php echo e(old('ciudad', $registro->ciudad ?? '')); ?>">
                        <?php $__errorArgs = ['ciudad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pais" class="form-label">Pais</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['pais'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="pais" name="pais" value="<?php echo e(old('pais', $registro->pais ?? '')); ?>">
                        <?php $__errorArgs = ['pais'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="direccion" name="direccion" value="<?php echo e(old('direccion', $registro->direccion ?? '')); ?>" placeholder="Calle, zona, referencia">
                        <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="codigo_postal" class="form-label">Codigo postal</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['codigo_postal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="codigo_postal" name="codigo_postal" value="<?php echo e(old('codigo_postal', $registro->codigo_postal ?? '')); ?>">
                        <?php $__errorArgs = ['codigo_postal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Nueva contrasena</label>
                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" autocomplete="new-password">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar contrasena</label>
                        <input type="password" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-outline-secondary me-md-2" href="<?php echo e(route('cliente.dashboard')); ?>">Cancelar</a>
                    <button type="submit" class="btn btn-dark"><i class="bi bi-check2-circle me-1"></i> Actualizar datos</button>
                </div>
            </form>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Telemetry helper variables (blade-rendered)
const TELEMETRY_CSRF = '<?php echo e(csrf_token()); ?>';
const TELEMETRY_USER_ID = '<?php echo e(Auth::id() ?? ''); ?>';

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
    const rotateBtn = document.getElementById('avatarRotate');
    const removeBtn = document.getElementById('avatarRemove');

    if (!ring || !input || !cropImg || !cropBox) return;

    const MAX_BYTES = 2 * 1024 * 1024; // 2 MB
    const ALLOWED = ['image/jpeg','image/png','image/webp'];
    let posX = 0, posY = 0, isDragging = false, startX = 0, startY = 0;
    let currentScale = 1; // applied scale
    let currentRotation = 0; // rotation (UI only)

    // add a small transition so rotations/zooms feel smooth
    if (cropImg) cropImg.style.transition = 'transform 160ms ease';

    const zoomWarningEl = document.getElementById('avatarZoomWarning');

    function updateZoomWarning() {
        if (!zoomWarningEl || !cropImg || !cropBox) return;
        const dims = getRotatedDims(currentRotation, cropImg.naturalWidth || 0, cropImg.naturalHeight || 0);
        const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
        const minScale = Math.max(1e-6, Math.max(bw / Math.max(1, dims.w), bh / Math.max(1, dims.h)));
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
        } catch (e) {}
        updateZoomWarning();
    }

    const cropSizeSelect = document.getElementById('avatarCropSize');
    const cropSizeError = document.getElementById('avatarCropSizeError');
    function cropSize() {
        if (!cropSizeSelect) return 260;
        const raw = cropSizeSelect.value;
        let v = parseInt(raw || '260', 10);
        const min = parseInt(cropSizeSelect.getAttribute('min') || '100', 10);
        const max = parseInt(cropSizeSelect.getAttribute('max') || '800', 10);
        if (isNaN(v)) v = 260;
        let clamped = v;
        if (clamped < min) clamped = min;
        if (clamped > max) clamped = max;
        // reflect clamped value back to input
        cropSizeSelect.value = clamped;
        if (String(clamped) !== String(v)) {
            // show inline feedback briefly
            if (cropSizeError) {
                cropSizeError.textContent = `Valor fuera de rango. Se ajustó a ${clamped}px.`;
                cropSizeError.style.display = 'block';
                setTimeout(() => { cropSizeError.style.display = 'none'; }, 3000);
            }
        }
        return clamped;
    }

    // helper to resize crop box
    function resizeCropBox(size) {
        if (!cropBox) return;
        cropBox.style.width = size + 'px';
        cropBox.style.height = size + 'px';
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
        const minScale = Math.max(1e-6, Math.max(bw / Math.max(1, rotatedW), bh / Math.max(1, rotatedH)));
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

    // initialize crop box size from selector
    resizeCropBox(cropSize());

    if (cropSizeSelect) {
        // respond to input and change events, keep value within min/max
        const onCropSizeChange = function () {
            const newSize = cropSize();
            // recenter image using current scale
            const bw = newSize, bh = newSize;
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

    ring.addEventListener('click', () => input.click());

    input.addEventListener('change', function () {
        const file = this.files && this.files[0];
        avatarError.style.display = 'none';
        if (!file) return;

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
            cropImg.src = e.target.result;
                cropImg.onload = function () {
                // fit image to cover crop box
                const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
                const iw = cropImg.naturalWidth, ih = cropImg.naturalHeight;
                const scaleToCover = Math.max(bw / iw, bh / ih);
                currentScale = scaleToCover;
                if (zoomRange) zoomRange.value = currentScale;
                // center based on rotated dims
                const dims = getRotatedDims(currentRotation, iw, ih);
                posX = (bw - dims.w * currentScale) / 2;
                posY = (bh - dims.h * currentScale) / 2;
                currentRotation = 0;
                enforceCoverage();
                applyTransform();
                editOptions.style.display = 'block';
                ring.classList.remove('avatar-loading');
            };
        };
        reader.readAsDataURL(file);
    });

    // pointer drag on crop image
    cropImg.addEventListener('pointerdown', function (e) {
        isDragging = true; startX = e.clientX; startY = e.clientY; cropImg.setPointerCapture(e.pointerId);
    });
    window.addEventListener('pointermove', function (e) {
        if (!isDragging) return;
        const dx = e.clientX - startX; const dy = e.clientY - startY;
        startX = e.clientX; startY = e.clientY;
        posX += dx; posY += dy;
        // enforce strict coverage
        enforceCoverage();
        applyTransform();
    });
    window.addEventListener('pointerup', function () { isDragging = false; });

    if (zoomRange) {
        zoomRange.addEventListener('input', function () {
            const newScale = parseFloat(this.value);
            // scale about center of crop box
            const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
            const cx = bw / 2, cy = bh / 2;
            // compute minimal allowed scale so rotated image covers the box
            const dims = getRotatedDims(currentRotation, cropImg.naturalWidth || 0, cropImg.naturalHeight || 0);
            const minScale = Math.max(1e-6, Math.max(bw / Math.max(1, dims.w), bh / Math.max(1, dims.h)));
            let appliedScale = newScale;
            // if user attempts to go below min, clamp and trigger blink feedback
            if (newScale < minScale) {
                appliedScale = minScale;
                if (zoomWarningEl) {
                    zoomWarningEl.classList.add('blink-warning');
                    // remove blink class after animation ends
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

    if (rotateBtn) rotateBtn.addEventListener('click', function () {
        // rotate 90 degrees clockwise each click
        currentRotation = (currentRotation + 90) % 360;
        // after rotation, recenter based on rotated image dimensions
        const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
        const dims = getRotatedDims(currentRotation, cropImg.naturalWidth || 0, cropImg.naturalHeight || 0);
        // ensure minimal scale after rotation so it still covers
        const minScale = Math.max(bw / Math.max(1, dims.w), bh / Math.max(1, dims.h));
        if (currentScale < minScale) {
            // scale about center
            const cx = bw / 2, cy = bh / 2;
            posX = cx - ((cx - posX) * (minScale / currentScale));
            posY = cy - ((cy - posY) * (minScale / currentScale));
            currentScale = minScale;
            if (zoomRange) zoomRange.value = currentScale;
        }
        posX = (bw - dims.w * currentScale) / 2;
        posY = (bh - dims.h * currentScale) / 2;
        enforceCoverage();
        applyTransform();
    });

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
            fetch('<?php echo e(url('/telemetry')); ?>', {
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
        editSave.addEventListener('click', function () {
            const bw = cropBox.clientWidth, bh = cropBox.clientHeight;
            // produce cropped image from natural image coordinates
            const img = cropImg;
            if (!img.src) { editOptions.style.display = 'none'; return; }
            const canvas = document.createElement('canvas');
            canvas.width = bw; canvas.height = bh;
            const ctx = canvas.getContext('2d');
            // compute source rectangle on natural image, taking rotation into account
            const imgEl = img;
            const norm = ((currentRotation % 360) + 360) % 360;
            const iw = imgEl.naturalWidth || 0, ih = imgEl.naturalHeight || 0;

            // create rotated source canvas
            const rotCanvas = document.createElement('canvas');
            const rotCtx = rotCanvas.getContext('2d');
            if (norm === 90 || norm === 270) {
                rotCanvas.width = ih; rotCanvas.height = iw;
            } else {
                rotCanvas.width = iw; rotCanvas.height = ih;
            }
            // rotate around center
            rotCtx.translate(rotCanvas.width / 2, rotCanvas.height / 2);
            rotCtx.rotate(norm * Math.PI / 180);
            rotCtx.drawImage(imgEl, -iw / 2, -ih / 2);

            // source rect on rotated image (inverse of transform)
            const srcX = Math.max(0, Math.round((-posX) / currentScale));
            const srcY = Math.max(0, Math.round((-posY) / currentScale));
            const srcW = Math.round(bw / currentScale);
            const srcH = Math.round(bh / currentScale);
            const rIw = rotCanvas.width, rIh = rotCanvas.height;
            const adjSrcW = Math.min(srcW, Math.max(0, rIw - srcX));
            const adjSrcH = Math.min(srcH, Math.max(0, rIh - srcY));
            try {
                ctx.drawImage(rotCanvas, srcX, srcY, adjSrcW, adjSrcH, 0, 0, bw, bh);
            } catch (err) {
                console.error('drawImage failed (rotated)', err);
            }
            const dataUrl = canvas.toDataURL('image/jpeg', 0.75);
            // set hidden input so server can save it
            if (avatarCroppedInput) avatarCroppedInput.value = dataUrl;
            // save rotation and scale to hidden inputs so server can process if needed
            const avatarRotationInput = document.getElementById('avatarRotationInput');
            const avatarScaleInput = document.getElementById('avatarScaleInput');
            if (avatarRotationInput) avatarRotationInput.value = String(currentRotation);
            if (avatarScaleInput) avatarScaleInput.value = String(currentScale);
            // also update preview
            if (preview) { preview.src = dataUrl; preview.style.display = 'block'; if (initial) initial.style.display = 'none'; }
            editOptions.style.display = 'none';
            // submit form using FormData with Blob to avoid sending large base64 in a hidden input
            if (form) {
                // convert dataURL to Blob then submit via fetch as multipart/form-data
                (async function () {
                    try {
                        const blob = await (await fetch(dataUrl)).blob();
                        const fd = new FormData(form);
                        // replace avatar field with generated blob so server receives a proper file upload
                        fd.set('avatar', blob, 'avatar.jpg');

                        // ensure _method and other hidden fields are present (FormData(form) already includes them)
                        const opts = {
                            method: form.getAttribute('method') || 'POST',
                            headers: {
                                'X-CSRF-TOKEN': TELEMETRY_CSRF,
                                'Accept': 'text/html'
                            },
                            credentials: 'same-origin',
                            body: fd
                        };

                        const resp = await fetch(form.action, opts);
                        // if server redirected, follow it
                        if (resp.redirected) {
                            window.location.href = resp.url;
                            return;
                        }
                        // otherwise, replace current document with server response (useful for validation errors)
                        const text = await resp.text();
                        document.open(); document.write(text); document.close();
                    } catch (err) {
                        console.error('Error enviando formulario de avatar:', err);
                        alert('Error al subir la imagen. Inténtalo de nuevo.');
                    }
                })();
            }
        });
    }

    // Mostrar toast y ocultar alert inline si existe
    document.addEventListener('DOMContentLoaded', function () {
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
    });

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

});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('web.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/autenticacion/perfil.blade.php ENDPATH**/ ?>