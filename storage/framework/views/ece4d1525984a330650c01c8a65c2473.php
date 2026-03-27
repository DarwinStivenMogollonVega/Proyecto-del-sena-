<?php $__env->startPush('estilos'); ?>
<style>
  .login-brand .auth-brand-mark-full {
    width: min(15rem, 62vw);
    height: 4.2rem;
    padding: 0.28rem 0.4rem;
  }

  .login-brand .auth-brand-mark-icon {
    width: 3.4rem;
    height: 3.4rem;
  }

  @media (max-width: 575.98px) {
    .login-brand .auth-brand-mark-icon {
      width: 4rem;
      height: 4rem;
    }
  }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('titulo', 'DisMusic - Login'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="auth-shell">
  <section class="auth-form-panel">
    <div class="auth-card p-4 p-lg-5">
      <a href="<?php echo e(route('web.index')); ?>" class="auth-brand login-brand mb-4">
        <span class="auth-brand-mark auth-brand-mark-full">
          <img src="<?php echo e(asset('assets/img/recurso11.png')); ?>" alt="DisMusic Logo" class="auth-brand-icon light" />
          <img src="<?php echo e(asset('assets/img/recurso12.png')); ?>" alt="DisMusic Logo" class="auth-brand-icon dark" />
        </span>
        <span class="auth-brand-mark auth-brand-mark-icon">
          <img src="<?php echo e(asset('assets/img/recurso11.png')); ?>" alt="DisMusic Logo" class="auth-brand-icon light" />
          <img src="<?php echo e(asset('assets/img/recurso12.png')); ?>" alt="DisMusic Logo" class="auth-brand-icon dark" />
        </span>
      </a>

      <div class="mb-4">
        <h1 class="h3 auth-heading mb-2">Inicia sesion</h1>
        <p class="login-box-msg text-start mb-0">Accede a tus pedidos, carrito y perfil para continuar tu compra.</p>
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

      <form action="<?php echo e(route('login.post')); ?>" method="post" class="mt-4">
        <?php echo csrf_field(); ?>
        <div class="input-group mb-3">
          <div class="form-floating">
            <input id="loginEmail" type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control" placeholder="correo@ejemplo.com" />
            <label for="loginEmail">Correo electronico</label>
          </div>
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>

        <div class="input-group mb-2">
          <div class="form-floating">
            <input id="loginPassword" type="password" name="password" class="form-control" placeholder="Contrasena" />
            <label for="loginPassword">Contrasena</label>
          </div>
          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
          <small class="auth-copy">Tu acceso esta protegido y vinculado a tus compras.</small>
          <a class="auth-link" href="<?php echo e(route('password.request')); ?>">Recuperar contrasena</a>
        </div>

        <div class="d-grid mb-3">
          <button type="submit" class="btn auth-btn-primary">Entrar a DisMusic</button>
        </div>
        <div class="mt-3">
          <small class="auth-copy">¿No tienes cuenta?</small><br>
          <a class="auth-link" href="<?php echo e(route('registro')); ?>">Registrarse</a>
        </div>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2">
          <span class="auth-copy">Prefieres seguir explorando primero?</span>
          <a href="<?php echo e(route('web.index')); ?>" class="auth-link fw-semibold">Volver a la tienda</a>
        </div>
      </form>
    </div>
  </section>

  <aside class="auth-summary-panel">
    <div>
      <h2 class="summary-title mt-3 mb-3">Tu tienda para descubrir, guardar y comprar discos sin perder el hilo.</h2>
      <p class="summary-copy mb-4">Desde aqui puedes entrar a tu cuenta y retomar tu experiencia: revisar productos, seguir tus pedidos y completar compras con rapidez.</p>

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
          <span>Retoma tu seleccion y finaliza la compra rapido.</span>
        </div>
        <div class="summary-pill">
          <strong>Pedidos</strong>
          <span>Consulta estados y el historial de tus compras.</span>
        </div>
      </div>
    </div>

    <div>
      <ul class="summary-list mb-4">
        <li><i class="bi bi-check2-circle"></i><span>Acceso directo a tu perfil y a tus pedidos recientes.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Colores y estilo alineados con la experiencia principal de la pagina.</span></li>
        <li><i class="bi bi-check2-circle"></i><span>Diseno adaptable para escritorio y movil sin perder legibilidad.</span></li>
      </ul>
    </div>
  </aside>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('autenticacion.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/laravelapp/resources/views/autenticacion/login.blade.php ENDPATH**/ ?>