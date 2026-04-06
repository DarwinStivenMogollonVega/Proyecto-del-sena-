<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Recuperación de contraseña</title>
  </head>
  <body>
    <p>Hola,</p>
    <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta. Haz clic en el siguiente enlace para continuar:</p>
    <p>
      <a href="<?php echo e(url('password/reset/'.$token)); ?>">Restablecer contraseña</a>
    </p>
    <p>Si no solicitaste esto, ignora este mensaje.</p>
    <p>Token: <?php echo e($token); ?></p>
  </body>
</html>
<p>ArtCode.</p>
<p>Has solicitado restablecer tu contraseña.</p>
<p>Haz clic en el siguiente enlace para restablecerla:</p>
<a href="<?php echo e(url('/password/reset/'.$token)); ?>">Restablecer contraseña</a>
<p>Si no solicitaste esto, ignora este mensaje.</p><?php /**PATH C:\Proyectos\proyecto para corregir }\proyecto actual\Proyecto-del-sena-\resources\views/emails/reset-password.blade.php ENDPATH**/ ?>