# Funciones y tecnologías usadas en la página

Este documento resume qué archivos y funciones JavaScript (y algunas piezas de servidor) se usan en la página para las interacciones más comunes (mostrar mensajes, AJAX, selects dinámicos, etc.). Sirve como referencia rápida para entender dónde mirar cuando quieras cambiar comportamiento o depurar.

## Cómo leer esto
- Cada entrada indica el archivo principal y una descripción corta de lo que hace.
- Si necesitas un análisis más profundo (endpoints, payloads, controladores PHP), puedo ampliar cada entrada con rutas y controladores relacionados.

---

## Peticiones AJAX / Fetch / XHR

- `public/js/wishlist-toggle.js`:
  - Uso: `fetch` POST a `/deseados/toggle/{id}` para alternar un producto en la lista de deseados.
  - Comportamiento: deshabilita el botón, envía CSRF en cabeceras, procesa JSON de respuesta; actualiza el icono (bi-heart / bi-heart-fill), muestra toasts (función `showDzToast`) y elimina elementos del DOM si está dentro de la vista de "wishlist".

- `resources/js/bootstrap.js`:
  - Uso: instancia global de `axios` y configuración de cabecera `X-Requested-With: XMLHttpRequest`.
  - Comportamiento: facilita llamadas XHR en otros scripts que importen `axios`.

- `resources/views/web/partials/nav.blade.php` (script inline):
  - Uso: `fetch` para interceptar formularios "Agregar al carrito" y enviar mediante AJAX, actualizando la badge del carrito sin recargar.
  - Comportamiento: escucha `submit` delegado, usa `FormData`, actualiza `.cart-count-badge` con `data.items` de la respuesta y muestra un toast de confirmación.

- `resources/views/producto/action.blade.php` y `resources/views/artista/action.blade.php` (scripts inline):
  - Uso: validaciones/consultas remotas con `fetch` hacia rutas como `artistas.checkIdentifier` y `artistas.store`.
  - Comportamiento: llamadas POST/GET para comprobar identificadores y guardar entidades sin recarga completa.

- `resources/views/autenticacion/perfil.blade.php` (scripts inline):
  - Uso: varias llamadas `fetch` para:
    - Enviar telemetría a `POST /telemetry` (no bloqueante, `keepalive: true`).
    - Enviar formulario de avatar convertido a `Blob` usando `fetch(dataUrl).blob()` y luego POST multipart vía `fetch`.
  - Comportamiento: preprocesa imagen en canvas, convierte a blob, envía vía `FormData`; si la respuesta redirige, el cliente sigue la redirección.

- `public/js/colombia-selects.js`:
  - Uso: `fetch('/assets/colombia.json')` para cargar datos de departamentos/municipios y poblar selects dependientes.
  - Comportamiento: rellena opciones, mantiene selección tras validación y captura errores de carga.

- `public/js/wishlist-toggle.js` (toasts):
  - Uso: la función `showDzToast(message, type)` muestra toasts globales usando Bootstrap Toast.
  - Comportamiento: actualiza clases `text-bg-*`, texto del `.toast-body` y llama a `bootstrap.Toast.getOrCreateInstance`.

---

## Comportamientos DOM / UI sin AJAX

- Scripts inline en `resources/views/web/partials/nav.blade.php`:
  - Manejan la clase `scrolled` en la navegación según `window.scrollY`.
  - Alternan estilos (pills) en los botones del carrito y del tema.

- Validaciones y manipulación en `resources/views/autenticacion/perfil.blade.php`:
  - Validación en vivo del campo `fecha_nacimiento` y manejo de alertas/toasts con Bootstrap.

---

## Notas sobre seguridad y cabeceras
- CSRF: la mayoría de las llamadas POST usan token CSRF (meta tag o variable `TELEMETRY_CSRF`) o incluyen cabeceras `X-CSRF-TOKEN`.
- `X-Requested-With` es configurado en `resources/js/bootstrap.js` para compatibilidad con detección de peticiones AJAX en el servidor.

---

## Siguientes pasos (puedo ayudar con):
- Enumerar las rutas (endpoints) y controladores PHP que atienden cada `fetch`/`axios`.
- Añadir ejemplos de payload/respuesta (JSON) para cada petición.
- Generar un diagrama o tabla que conecte vista → script → ruta → controlador.

Si quieres que amplíe alguna entrada (por ejemplo: detallar el controlador que maneja `/deseados/toggle/{id}`), dime cuál y lo documento con rutas y fragmentos de código del servidor.
