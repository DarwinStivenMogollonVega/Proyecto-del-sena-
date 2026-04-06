<?php $__env->startSection('titulo', 'DiscZone - Recuperar contrasena'); ?>
<?php $__env->startPush('estilos'); ?>
<style>
  /* Modo oscuro inspirado en perfil */
  html[data-theme='dark'] .auth-shell {
    background: radial-gradient(circle at 8% 8%, rgba(245, 158, 11, 0.15), transparent 30%), radial-gradient(circle at 92% 0%, rgba(59, 130, 246, 0.14), transparent 28%), linear-gradient(180deg, rgba(31, 41, 55, 0.65), rgba(17, 24, 39, 0));
  }
  html[data-theme='dark'] .auth-card {
    background: #111827;
    border-color: #334155;
    box-shadow: 0 12px 24px rgba(2, 6, 23, 0.55);
  }
  html[data-theme='dark'] .auth-form-panel {
    background: transparent;
  }
  html[data-theme='dark'] .auth-summary-panel {
    background: linear-gradient(130deg, #111827 0%, #7c2d12 52%, #0f172a 100%);
    color: #fff;
  }
  html[data-theme='dark'] .summary-title,
  html[data-theme='dark'] .summary-copy,
  html[data-theme='dark'] .summary-pill strong,
  html[data-theme='dark'] .summary-pill span,
  html[data-theme='dark'] .summary-list li {
    color: #fff !important;
  }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="auth-shell">
  <section class="auth-form-panel">
    <div class="auth-card p-4 p-lg-5">
      <a href="<?php echo e(route('web.index')); ?>" class="auth-brand mb-4">
        <span class="auth-brand-mark"><i class="bi bi-vinyl-fill"></i></span>
        <span>
          <strong class="d-block fs-4">DiscZone</strong>
          <small class="auth-copy">Recuperacion de acceso</small>
        </span>
      </a>

      <div class="mb-4">
        <h1 class="h3 auth-heading mb-2">Recuperar contrasena</h1>
        <p class="login-box-msg text-start mb-0">Ingresa tu correo y te enviaremos un enlace para restablecer el acceso a tu cuenta.</p>
      </div>

      <?php if(session('error')): ?>
        <div class="alert alert-danger">
          <?php echo e(session('error')); ?>

        </div>
      <?php endif; ?>

      <?php if(Session::has('mensaje')): ?>
        <div class="alert alert-info alert-dismissible fade show mt-2">
          <?php echo e(Session::get('mensaje')); ?>

          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
      <?php endif; ?>

      <form action="<?php echo e(route('password.send-link')); ?>" method="post" class="mt-4">
        <?php echo csrf_field(); ?>
        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="loginEmail" type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="correo@ejemplo.com" />
            <label for="loginEmail">Correo electronico</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div class="invalid-feedback d-block mb-3"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <div class="d-grid mb-3">
          <button type="submit" class="btn auth-btn-primary">Enviar enlace de recuperacion</button>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2">
          <span class="auth-copy">Recordaste tu clave?</span>
          <a href="<?php echo e(route('login')); ?>" class="auth-link fw-semibold">Volver al login</a>
        </div>
      </form>
    </div>
  </section>

  <aside class="auth-summary-panel">
    <div>
      <span class="summary-kicker"><i class="bi bi-shield-lock-fill"></i> Acceso seguro</span>
      <h2 class="summary-title mt-3 mb-3">Recupera tu cuenta sin perder el seguimiento de tus compras.</h2>
      <p class="summary-copy mb-4">El proceso de recuperacion te permite volver a entrar para revisar pedidos, continuar con tu carrito y administrar tu perfil dentro de DiscZone.</p>

      <div class="summary-grid mb-4">
        <div class="summary-pill">
          <strong>Correo verificado</strong>
          <span>El enlace llega al email asociado a tu cuenta.</span>
        </div>
        <div class="summary-pill">
          <strong>Recuperacion rapida</strong>
          <span>Puedes restablecer tu acceso en pocos pasos.</span>
        </div>
      </div>
    </div>

    <div>
      <ul class="summary-list mb-4">
        <li><i class="bi bi-check2-circle"></i><span>Retoma tus pedidos pendientes y tu historial de compras.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Protege tu cuenta con una nueva contrasena.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Mantiene la misma experiencia visual y de lectura del login.</span></li>
      </ul>

      <a href="<?php echo e(route('web.index')); ?>" class="summary-cta">
        <i class="bi bi-arrow-left"></i>
        Volver a la tienda
      </a>
    </div>
  </aside>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('autenticacion.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/autenticacion/email.blade.php ENDPATH**/ ?>