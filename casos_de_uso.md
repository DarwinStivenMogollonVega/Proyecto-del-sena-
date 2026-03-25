# Casos de Uso del Sistema

## 1. Actores

- **Visitante**: Usuario no autenticado que navega el sitio público.
- **Cliente**: Usuario registrado y autenticado.
- **Administrador**: Usuario con permisos de gestión (rol `admin`).
- **Proveedor**: (Solo gestión interna, no interactúa directamente con el sistema).
- **Sistema**: (Procesos automáticos internos, como logs de actividad).

---

## 2. Casos de Uso

### Módulo: Catálogo y Descubrimiento

#### CU1: Explorar catálogo de productos
- **Actor:** Visitante, Cliente, Administrador
- **Descripción:** Permite navegar y filtrar productos por categoría, catálogo o búsqueda.
- **Precondiciones:** El sistema debe estar disponible.
- **Flujo principal:**
  1. El actor accede a la página principal o a una categoría/catálogo.
  2. Visualiza el listado de productos y puede aplicar filtros.
  3. Puede ver detalles de un producto.
- **Flujos alternativos:** Si no hay productos, se muestra mensaje de catálogo vacío.
- **Postcondiciones:** El actor visualiza productos según sus criterios.
- **Evidencia en el código:**  
  - routes/web.php (`/`, `/categoria-web/{id}`, `/catalogo-web/{id}`)  
  - WebController@index, CategoriaController@show, CatalogoController@show  
  - views/web/index.blade.php, views/web/categoria.blade.php

#### CU2: Ver detalle de producto
- **Actor:** Visitante, Cliente, Administrador
- **Descripción:** Permite ver información detallada de un producto, incluyendo imagen, descripción y reseñas.
- **Precondiciones:** El producto existe.
- **Flujo principal:**
  1. El actor selecciona un producto del catálogo.
  2. El sistema muestra la ficha detallada.
- **Flujos alternativos:** Si el producto no existe, se muestra error.
- **Postcondiciones:** El actor visualiza el detalle del producto.
- **Evidencia en el código:**  
  - routes/web.php (`/producto/{id}`)  
  - WebController@show  
  - views/web/show.blade.php

---

### Módulo: Carrito y Compra

#### CU3: Agregar producto al carrito
- **Actor:** Visitante, Cliente
- **Descripción:** Permite agregar productos al carrito de compras.
- **Precondiciones:** El producto existe y hay stock.
- **Flujo principal:**
  1. El actor selecciona un producto y elige “Agregar al carrito”.
  2. El sistema añade el producto al carrito en sesión.
- **Flujos alternativos:** Si el producto no existe o no hay stock, se muestra error.
- **Postcondiciones:** El producto queda en el carrito.
- **Evidencia en el código:**  
  - CarritoController@agregar  
  - routes/web.php (`/carrito/agregar`)

#### CU4: Modificar cantidades o eliminar productos del carrito
- **Actor:** Visitante, Cliente
- **Descripción:** Permite sumar, restar o eliminar productos del carrito.
- **Precondiciones:** El producto está en el carrito.
- **Flujo principal:**
  1. El actor accede al carrito.
  2. Puede aumentar, disminuir o eliminar productos.
- **Flujos alternativos:** Si la cantidad llega a cero, el producto se elimina.
- **Postcondiciones:** El carrito refleja los cambios.
- **Evidencia en el código:**  
  - CarritoController@sumar, @restar, @eliminar, @vaciar  
  - views/web/pedido.blade.php

#### CU5: Iniciar proceso de compra (checkout)
- **Actor:** Cliente
- **Descripción:** Permite al usuario autenticado iniciar el proceso de compra.
- **Precondiciones:** El carrito tiene productos y el usuario está autenticado.
- **Flujo principal:**
  1. El cliente accede al formulario de compra.
  2. Ingresa datos personales y de entrega.
  3. Adjunta comprobante de pago si aplica.
  4. Confirma el pedido.
- **Flujos alternativos:** Si faltan datos obligatorios, se muestra error.
- **Postcondiciones:** El pedido queda registrado.
- **Evidencia en el código:**  
  - PedidoController@datosForm, @realizar  
  - views/web/formulario_pedido.blade.php

---

### Módulo: Gestión de Pedidos y Perfil

#### CU6: Consultar historial y estado de pedidos
- **Actor:** Cliente
- **Descripción:** Permite ver el historial de compras y el estado de cada pedido.
- **Precondiciones:** El usuario está autenticado.
- **Flujo principal:**
  1. El cliente accede a “Mis pedidos”.
  2. Visualiza la lista y detalles de sus pedidos.
- **Flujos alternativos:** Si no hay pedidos, se muestra mensaje.
- **Postcondiciones:** El usuario visualiza su historial.
- **Evidencia en el código:**  
  - PedidoController@misPedidos  
  - views/web/mis_pedidos.blade.php

#### CU7: Descargar recibos y comprobantes de compra
- **Actor:** Cliente
- **Descripción:** Permite descargar recibos/facturas de pedidos realizados.
- **Precondiciones:** El usuario tiene pedidos con comprobante.
- **Flujo principal:**
  1. El cliente accede a la sección de recibos.
  2. Descarga el archivo correspondiente.
- **Flujos alternativos:** Si no hay comprobante, se muestra mensaje.
- **Postcondiciones:** El usuario obtiene el archivo.
- **Evidencia en el código:**  
  - PedidoController@recibosFactura  
  - views/web/recibos_factura.blade.php

#### CU8: Editar perfil de usuario
- **Actor:** Cliente
- **Descripción:** Permite modificar datos personales y contraseña.
- **Precondiciones:** El usuario está autenticado.
- **Flujo principal:**
  1. El cliente accede a su perfil.
  2. Modifica los datos y guarda cambios.
- **Flujos alternativos:** Si los datos no son válidos, se muestra error.
- **Postcondiciones:** El perfil se actualiza.
- **Evidencia en el código:**  
  - UserController@edit, @update  
  - views/autenticacion/perfil.blade.php

---

### Módulo: Reseñas de Productos

#### CU9: Publicar reseña de producto
- **Actor:** Cliente
- **Descripción:** Permite dejar una calificación y comentario sobre un producto adquirido.
- **Precondiciones:** El usuario está autenticado y ha comprado el producto.
- **Flujo principal:**
  1. El cliente accede al detalle del producto.
  2. Escribe y envía su reseña.
- **Flujos alternativos:** Si ya reseñó o no compró, se restringe la acción.
- **Postcondiciones:** La reseña queda registrada.
- **Evidencia en el código:**  
  - WebController@guardarResena  
  - routes/web.php (`/producto/{id}/resena`)

---

### Módulo: Administración

#### CU10: Gestionar productos, categorías, catálogos y artistas (CRUD)
- **Actor:** Administrador
- **Descripción:** Permite crear, editar, eliminar y listar productos, categorías, catálogos y artistas.
- **Precondiciones:** El usuario tiene rol `admin`.
- **Flujo principal:**
  1. El administrador accede al panel.
  2. Realiza operaciones CRUD sobre las entidades.
- **Flujos alternativos:** Si no tiene permisos, se deniega el acceso.
- **Postcondiciones:** Los cambios se reflejan en el sistema.
- **Evidencia en el código:**  
  - ProductoController, CategoriaController, CatalogoController, ArtistaController  
  - routes/web.php (rutas protegidas)

#### CU11: Gestionar usuarios y roles
- **Actor:** Administrador
- **Descripción:** Permite crear, editar, eliminar usuarios y asignar roles/permisos.
- **Precondiciones:** El usuario tiene rol `admin`.
- **Flujo principal:**
  1. El administrador accede a la gestión de usuarios/roles.
  2. Realiza operaciones CRUD y asignaciones.
- **Flujos alternativos:** Si no tiene permisos, se deniega el acceso.
- **Postcondiciones:** Los cambios se reflejan en el sistema.
- **Evidencia en el código:**  
  - UserController, RoleController  
  - routes/web.php

#### CU12: Gestionar pedidos y facturación
- **Actor:** Administrador
- **Descripción:** Permite ver, actualizar y gestionar pedidos y facturas, incluyendo facturación electrónica.
- **Precondiciones:** El usuario tiene rol `admin`.
- **Flujo principal:**
  1. El administrador accede a la gestión de pedidos/facturas.
  2. Visualiza, edita o elimina registros.
- **Flujos alternativos:** Si no tiene permisos, se deniega el acceso.
- **Postcondiciones:** Los cambios se reflejan en el sistema.
- **Evidencia en el código:**  
  - PedidoController, FacturaController  
  - routes/web.php

#### CU13: Gestionar inventario y movimientos de stock
- **Actor:** Administrador
- **Descripción:** Permite registrar entradas, salidas y ajustes de inventario.
- **Precondiciones:** El usuario tiene rol `admin`.
- **Flujo principal:**
  1. El administrador accede al módulo de inventario.
  2. Registra movimientos y consulta alertas de bajo stock.
- **Flujos alternativos:** Si no tiene permisos, se deniega el acceso.
- **Postcondiciones:** El inventario se actualiza.
- **Evidencia en el código:**  
  - InventarioController@moverStock  
  - routes/web.php (`/admin/inventario`)

#### CU14: Consultar panel de control y estadísticas
- **Actor:** Administrador
- **Descripción:** Permite visualizar métricas clave, actividad reciente y rankings.
- **Precondiciones:** El usuario tiene rol `admin`.
- **Flujo principal:**
  1. El administrador accede al dashboard.
  2. Consulta estadísticas y accesos rápidos.
- **Flujos alternativos:** Si no tiene permisos, se deniega el acceso.
- **Postcondiciones:** El administrador obtiene información para la toma de decisiones.
- **Evidencia en el código:**  
  - routes/web.php (`/dashboard`)  
  - AdminAnalyticsService.php

---

### Módulo: Autenticación

#### CU15: Registrarse en el sistema
- **Actor:** Visitante
- **Descripción:** Permite crear una cuenta de cliente.
- **Precondiciones:** No estar autenticado.
- **Flujo principal:**
  1. El visitante accede al formulario de registro.
  2. Ingresa sus datos y envía el formulario.
- **Flujos alternativos:** Si el email ya existe o los datos son inválidos, se muestra error.
- **Postcondiciones:** El usuario queda registrado y puede iniciar sesión.
- **Evidencia en el código:**  
  - views/autenticacion/registro.blade.php  
  - UserController@store

#### CU16: Iniciar sesión
- **Actor:** Visitante, Cliente, Administrador
- **Descripción:** Permite autenticarse en el sistema.
- **Precondiciones:** Tener cuenta registrada.
- **Flujo principal:**
  1. El usuario accede al formulario de login.
  2. Ingresa sus credenciales y accede.
- **Flujos alternativos:** Si los datos son incorrectos, se muestra error.
- **Postcondiciones:** El usuario accede a su área correspondiente.
- **Evidencia en el código:**  
  - views/autenticacion/login.blade.php

#### CU17: Recuperar contraseña
- **Actor:** Visitante, Cliente, Administrador
- **Descripción:** Permite solicitar el restablecimiento de contraseña.
- **Precondiciones:** Tener email registrado.
- **Flujo principal:**
  1. El usuario accede al formulario de recuperación.
  2. Ingresa su email y recibe instrucciones.
- **Flujos alternativos:** Si el email no existe, se muestra error.
- **Postcondiciones:** El usuario puede restablecer su contraseña.
- **Evidencia en el código:**  
  - views/autenticacion/email.blade.php, views/autenticacion/reset.blade.php

---

### Módulo: Páginas informativas y soporte

#### CU18: Consultar información de la tienda y guía de uso
- **Actor:** Visitante, Cliente
- **Descripción:** Permite acceder a páginas estáticas como “Acerca de” y guía de uso.
- **Precondiciones:** El sistema debe estar disponible.
- **Flujo principal:**
  1. El actor accede a la página informativa.
  2. Consulta la información relevante.
- **Flujos alternativos:** Si la página no existe, se muestra error.
- **Postcondiciones:** El usuario obtiene información de la tienda.
- **Evidencia en el código:**  
  - routes/web.php (`/acerca`, `/soporte`)  
  - views/web/acerca.blade.php, views/web/soporte.blade.php

---

## 3. Notas

- No se evidencia integración con APIs externas ni webhooks.
- No se detectan casos de uso automáticos fuera de logs internos y paginación.
- Si algún flujo alternativo no está explícito en el código, se indica como “suposición basada en el código”.
