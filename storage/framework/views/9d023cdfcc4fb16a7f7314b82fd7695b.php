<?php $__env->startPush('estilos'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/responsive-section.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/registro.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('titulo', 'DisMusic - Registro'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="auth-shell">
  <section class="auth-form-panel">
    <div class="auth-card p-4 p-lg-5">
      <a href="<?php echo e(route('web.index')); ?>" class="auth-brand register-brand mb-4">
        <span class="auth-brand-mark auth-brand-mark-full">
          <img src="<?php echo e(asset('assets/img/recurso12.png')); ?>" alt="DisMusic Logo" class="auth-brand-icon dark" />
        </span>
        <span class="auth-brand-mark auth-brand-mark-icon">
          <img src="<?php echo e(asset('assets/img/recurso11.png')); ?>" alt="DisMusic Logo" class="auth-brand-icon light" />
        </span>
      </a>
      <div class="mb-4">
        <h1 class="h3 auth-heading mb-2">Crear cuenta</h1>
        <p class="login-box-msg text-start mb-0">Regístrate para acceder a tus pedidos, carrito y perfil.</p>
      </div>
      <?php if(session('error')): ?>
        <div class="alert alert-danger">
          <?php echo e(session('error')); ?>

        </div>
      <?php endif; ?>
      <?php if($errors->any()): ?>
        <div class="alert alert-danger" role="alert">
          <strong>Revisa los siguientes errores:</strong>
          <ul class="mb-0 mt-2">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>
      <form action="<?php echo e(route('registro.store')); ?>" method="post" class="mt-4">
        <?php echo csrf_field(); ?>
        <div class="input-group mb-3">
          <div class="form-floating">
            <input id="registerName" type="text" name="name" value="<?php echo e(old('name')); ?>" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nombre" minlength="3" maxlength="100" pattern="^(?!.*\d).+$" title="El nombre no puede contener números." required />
            <label for="registerName">Nombre</label>
          </div>
          <div class="input-group-text"><span class="bi bi-person"></span></div>
        </div>
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="input-group mb-3">
          <div class="form-floating">
            <input id="registerEmail" type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="correo@ejemplo.com" maxlength="100" required />
            <label for="registerEmail">Correo electrónico</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="registerPassword" type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Contraseña" minlength="8" required />
            <label for="registerPassword">Contraseña</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="registerPasswordConfirmation" type="password" name="password_confirmation" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Confirmar contraseña" minlength="8" required />
            <label for="registerPasswordConfirmation">Confirmar contraseña</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>
        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="d-grid mb-3">
          <button type="submit" class="btn auth-btn-primary">Registrarse</button>
        </div>
        <div class="mt-3">
          <small class="auth-copy">¿Ya tienes cuenta?</small><br>
          <a class="auth-link" href="<?php echo e(route('login')); ?>">Iniciar sesión</a>
        </div>
      </form>
    </div>
  </section>
  <aside class="auth-summary-panel">
    <div>
      <h2 class="summary-title mt-3 mb-3">Tu tienda para descubrir, guardar y comprar discos sin perder el hilo.</h2>
      <p class="summary-copy mb-4">Regístrate para revisar productos, seguir tus pedidos y completar compras con rapidez.</p>
      <div class="summary-grid mb-4">
        <div class="summary-pill">
          <strong>Catalogos</strong>
          <span>Explora colecciones curadas por estilo o temporada.</span>
        </div>
        <div class="summary-pill">
          <strong>Categorias</strong>
          <span>Filtra por genero, formato o tipo de producto.</span>
        </div>
        <div class="summary-pill">
          <strong>Carrito</strong>
          <span>Retoma tu selección y finaliza la compra rápido.</span>
        </div>
        <div class="summary-pill">
          <strong>Pedidos</strong>
          <span>Consulta estados y el historial de tus compras.</span>
        </div>
      </div>
      <ul class="summary-list mb-4">
        <li><i class="bi bi-check2-circle"></i><span>Acceso directo a tu perfil y a tus pedidos recientes.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Colores y estilo alineados con la experiencia principal de la pagina.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Diseno adaptable para escritorio y movil sin perder legibilidad.</span></li>
      </ul>
    </div>
  </aside>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(() => {
  const nameInput = document.getElementById('registerName');
  const passwordInput = document.getElementById('registerPassword');
  const confirmationInput = document.getElementById('registerPasswordConfirmation');

  nameInput?.addEventListener('input', function () {
    if (/\d/.test(this.value)) {
      this.classList.add('is-invalid');
    } else {
      this.classList.remove('is-invalid');
    }
  });

  const validatePasswords = () => {
    if (!passwordInput || !confirmationInput) return;
    if (confirmationInput.value.length > 0 && passwordInput.value !== confirmationInput.value) {
      confirmationInput.classList.add('is-invalid');
    } else {
      confirmationInput.classList.remove('is-invalid');
    }
  };

  passwordInput?.addEventListener('input', validatePasswords);
  confirmationInput?.addEventListener('input', validatePasswords);
})();
</script>
<?php $__env->stopPush(); ?>

      
<?php echo $__env->make('autenticacion.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/autenticacion/registro.blade.php ENDPATH**/ ?>