# Documentación del Proyecto

## 1. Descripción General

Aplicación e‑commerce construida con Laravel. Soporta navegación pública (catálogo, búsqueda, detalle de producto, reseñas, wishlist), carrito y proceso de compra multi‑paso, gestión administrativa (CRUD de usuarios, roles, productos, categorías, catálogos, artistas, proveedores), gestión de inventario, administración de pedidos y facturas, y panel analítico/estadísticas.

## 2. Usabilidades del Sistema (Funcionalidades desde perspectiva de negocio)

- **Navegación pública y búsqueda de productos**: buscar productos, filtrar por categoría y catálogo, ordenar por precio.
- **Detalle de producto y reseñas**: ver ficha de producto, leer reseñas, agregar/modificar reseña (usuarios autenticados).
- **Wishlist (Lista de deseados)**: agregar y quitar productos de la lista de deseados (sesión).
- **Carrito de compras**: agregar, aumentar, disminuir, eliminar ítems y vaciar el carrito.
- **Proceso de compra multi‑paso**: formulario de datos → formulario de entrega → formulario de pago → crear pedido y factura.
- **Autenticación y gestión de sesión**: inicio de sesión, registro, recuperación de contraseña, perfil de usuario (editar datos).
- **Mis pedidos y facturas**: consultar historial de pedidos, generar/descargar factura en PDF.
- **Panel administrativo**: CRUD para `usuarios`, `roles`, `productos`, `categorias`, `catalogos`, `artistas`, `proveedores`.
- **Gestión de inventario**: registrar movimientos de inventario (entrada, ajuste), ver historial en panel.
- **Gestión de pedidos en admin**: listar pedidos, cambiar estado, administración de facturas (crear/editar/eliminar/recargar).
- **Panel de estadísticas / analíticas**: vistas y exportación (PDF/Excel) por categoría.
- **Telemetría**: endpoint para almacenar eventos/telemetría de usuarios autenticados.

## 3. Métodos del Sistema (nivel técnico)

Nota: se listan controladores y métodos más relevantes encontrados en el código. Cada entrada indica archivo, método, descripción, parámetros y retorno.

- Archivo: [app/Http/Controllers/WebController.php](app/Http/Controllers/WebController.php#L1)
  - Método: `index(Request $request)`
    - Descripción: Página principal pública; lista productos por secciones (más vendidos, mejor valorados, ofertas, disponibles), soporta búsqueda y ordenamientos; devuelve vista `web.index` con paginación.
    - Parámetros: `Request $request` (opciones `search`, `sort`)
    - Retorno: `View` con conjuntos de productos y métricas.
  - Método: `show($id)`
    - Descripción: Muestra detalle de un producto con reseñas y promedio.
    - Parámetros: `$id` (ID de producto)
    - Retorno: `View` `web.item` con `producto`, `promedio`, `totalResenas`, `miResena`.
  - Método: `guardarResena(Request $request, $id)`
    - Descripción: Valida y guarda/actualiza reseña del usuario autenticado para un producto.
    - Parámetros: `Request` (puntuacion, comentario), `$id` producto
    - Retorno: Redirección a `web.show` con mensaje.

- Archivo: [app/Http/Controllers/CarritoController.php](app/Http/Controllers/CarritoController.php#L1)
  - Método: `agregar(Request $request)`
    - Descripción: Añade producto al carrito en sesión; incrementa cantidad si ya existe.
    - Parámetros: `producto_id`, `cantidad` (opcional)
    - Retorno: Redirección con mensaje.
  - Método: `mostrar()`
    - Descripción: Muestra la vista `web.pedido` con contenido del carrito (sesión).
    - Parámetros: ninguno
    - Retorno: `View`.
  - Método: `sumar(Request $request)` / `restar(Request $request)`
    - Descripción: Incrementa o decrementa cantidad en carrito; elimina el ítem si cantidad queda en 0.
    - Parámetros: `producto_id`
    - Retorno: Redirección con mensaje.
  - Método: `eliminar($id)`
    - Descripción: Elimina ítem por `id` del carrito (sesión).
    - Parámetros: `$id` producto
    - Retorno: Redirección con mensaje.
  - Método: `vaciar()`
    - Descripción: Borra la sesión `carrito`.
    - Retorno: Redirección con mensaje.

- Archivo: [app/Http/Controllers/PedidoController.php](app/Http/Controllers/PedidoController.php#L1)
  - Método: `datosForm(Request $request)`
    - Descripción: Paso 1 del checkout: formulario de datos personales. Requiere carrito no vacío.
    - Parámetros: `Request`
    - Retorno: `View` `web.formulario_pedido`.
  - Método: `datosGuardar(PedidoDatosRequest $request)`
    - Descripción: Valida y guarda datos personales en sesión `checkout.datos`.
    - Parámetros: `PedidoDatosRequest`
    - Retorno: Redirección al paso de entrega.
  - Método: `entregaForm(Request $request)` / `entregaGuardar(PedidoEntregaRequest $request)`
    - Descripción: Paso 2 (dirección de entrega). Guarda en `checkout.entrega`.
  - Método: `pagoForm(Request $request)` / `pagoGuardar(PedidoPagoRequest $request)`
    - Descripción: Paso 3 (pago). `pagoGuardar` valida, almacena comprobante (archivo), crea `Pedido`, `PedidoDetalle` y `Factura` dentro de transacción; limpia sesión de checkout.
    - Parámetros: `PedidoPagoRequest` (posible archivo `comprobante_pago`)
    - Retorno: Redirección con resultado (éxito/error).
  - Método: `realizar(PedidoRealizarRequest $request)`
    - Descripción: Alternativa para completar pedido en una sola acción si incluye `metodo_pago` — crea pedido y factura similar a `pagoGuardar`.
  - Método: `misPedidos(Request $request)`
    - Descripción: Lista paginada de pedidos del usuario autenticado y resumen de métricas (totales, pendientes, etc.).
  - Método: `adminIndex()`
    - Descripción: Vista administrativa de pedidos (búsqueda filtrada y sets de productos destacados para el panel).

- Archivo: [app/Http/Controllers/CategoriaController.php](app/Http/Controllers/CategoriaController.php#L1)
  - Método: `index(Request $request)`
    - Descripción: Listado paginado de categorías (permite búsqueda por nombre). Requiere permiso `categoria-list`.
  - Método: `create()`, `store(CategoriaRequest $request)`, `edit($id)`, `update(CategoriaRequest $request, $id)`, `destroy($id)`
    - Descripción: CRUD completo de categorías con autorización por permisos (`create`, `edit`, `delete`).
  - Método: `show($id)`
    - Descripción: Versión pública que muestra productos de la categoría con búsqueda y ordenamiento; devuelve vista `web.categoria`.

- Archivo: [app/Http/Controllers/ProductoController.php](app/Http/Controllers/ProductoController.php#L1)
  - Métodos REST: `index`, `create`, `store(ProductoRequest)`, `edit($id)`, `update(ProductoRequest, $id)`, `destroy($id)`
    - Descripción: CRUD de productos. `store` y `update` manejan carga de imagen (`uploads/productos`), parseo de lista de canciones, y crean registros de `InventarioMovimiento` para entradas/ajustes.
    - Parámetros: `ProductoRequest` y campos como `codigo`, `nombre`, `precio`, `cantidad`, `categoria_id`, `catalogo_id`, `proveedor_id`, `artista_id`, `lista_canciones`, `imagen`.
    - Retorno: Redirección a índice con mensaje.
  - Método privado: `parseListaCanciones(?string $input): ?array`
    - Descripción: Convierte texto multilínea en array de canciones; retorno `null` si vacío.

- Archivo: [app/Http/Controllers/UserController.php](app/Http/Controllers/UserController.php#L1)
  - Métodos REST básicos: `index`, `create`, `store(UserRequest)`, `edit`, `update(UserRequest, $id)`, `destroy`.
    - Descripción: Admin CRUD para usuarios; usa `Spatie







































































































Indícame si deseas que exporte esto como `DOCUMENTACION_PROYECTO.md` o que amplíe con los métodos restantes (models, requests, providers, observers).- Añadir ejemplos de payloads para las solicitudes (JSON/form-data) y capturas de las vistas.- Generar un índice más expandido con todos los métodos de cada archivo (incluyendo modelos y relaciones) — esto tomará más tiempo.Si quieres, puedo:---- Requests de validación: `app/Http/Requests/` (revisar archivos por nombre para reglas detalladas).- Servicios: [app/Services/AdminAnalyticsService.php](app/Services/AdminAnalyticsService.php#L1)  - [app/Http/Controllers/UserController.php](app/Http/Controllers/UserController.php#L1)  - [app/Http/Controllers/ArtistaController.php](app/Http/Controllers/ArtistaController.php#L1)  - [app/Http/Controllers/FacturaController.php](app/Http/Controllers/FacturaController.php#L1)  - [app/Http/Controllers/CategoriaController.php](app/Http/Controllers/CategoriaController.php#L1)  - [app/Http/Controllers/ProductoController.php](app/Http/Controllers/ProductoController.php#L1)  - [app/Http/Controllers/PedidoController.php](app/Http/Controllers/PedidoController.php#L1)  - [app/Http/Controllers/CarritoController.php](app/Http/Controllers/CarritoController.php#L1)  - [app/Http/Controllers/WebController.php](app/Http/Controllers/WebController.php#L1)- Controladores principales:- Rutas: [routes/web.php](routes/web.php#L1)## 6. Archivos y referencias clave  2. Estadísticas por categoría disponibles en `EstadisticaController` con exportaciones PDF/Excel.  1. Usuario con rol admin accede a `/dashboard`, controlador closure invoca `AdminAnalyticsService::dashboardData()` y prepara métricas y registros.- Flujo: Panel administrativo / Dashboard  3. Usuario puede descargar PDF con `FacturaController::pdf($id)`.  2. `crearFacturaDesdePedido` revisa si ya existe factura; si no, la crea en transacción, calcula subtotal/impuestos y asigna `numero_factura`.  1. Usuario solicita `perfil/recibos-factura/{id}` que llama `FacturaController::generarDesdePedido`.- Flujo: Generación de factura desde pedido  5. Resultado: pedido y factura persistidos; notificación al usuario vía redirect+mensaje.  4. `pedido.pago` (`pagoForm`) valida pasos previos; `pagoGuardar` valida y almacena `checkout.pago` (puede subir `comprobante_pago`), dentro de transacción crea `Pedido`, `PedidoDetalle` y `Factura`, y limpia sesión.  3. `pedido.entrega` (`entregaForm`) valida `checkout.datos`; `entregaGuardar` guarda `checkout.entrega`.  2. `pedido.datos` (`datosForm`) valida existencia de carrito; `datosGuardar` guarda datos personales en `checkout.datos`.  1. Carrito en sesión (acciones desde `CarritoController`). Usuario avanza a `pedido.datos`.- Flujo: Checkout multi‑paso (usuario autenticado requerido por rutas protegidas)  6. `DELETE /productos/{id}` → `destroy()` elimina y borra imagen.  5. `PUT /productos/{id}` → `update()` actualiza datos, maneja imagen y crea movimiento de inventario si cambió cantidad.  4. `GET /productos/{id}/edit` → `edit()`.  3. `POST /productos` → `store(ProductoRequest)` valida, guarda imagen, crea `Producto` y registra `InventarioMovimiento` (entrada inicial).  2. `GET /productos/create` → `create()` muestra formulario.  1. `GET /productos` → `ProductoController::index` (lista paginada).- Flujo: CRUD de productos (admin)  3. Si `activo` false, se deniega el acceso y se cierra sesión.  2. `POST /login` llama `AuthController::login` que valida con `Auth::attempt`.  1. `GET /login` muestra formulario.- Flujo: Inicio de sesión  3. Usuario autenticado puede acceder a `perfil` y `cliente.dashboard`.  2. `POST /registro` invoca `RegisterController::registrar` que valida y crea `User`, asigna rol por defecto.  1. Ruta `GET /registro` muestra formulario (RegisterController::showRegistroForm).- Flujo: Registro de usuario## 5. Flujos del Sistema (paso a paso)- Observers y Providers para comportamientos transversales (cálculo de métricas, logging de actividad).- Servicios (`app/Services`) consumidos por controladores o por closures en rutas (p.ej. `AdminAnalyticsService::dashboardData`).- Rutas → Controladores → Requests (validación) → Modelos → Vistas.Relación entre componentes:- `storage/` : archivos y logs (no versionado normalmente).- `public/uploads/` : almacenamiento local de imágenes subidas (`productos`, `artistas`).- `resources/views/` : vistas Blade organizadas por módulos (`web/`, `producto/`, `categoria/`, `artista/`, `usuario/`, `pedido/`, `admin/`).- `routes/web.php` : definición de rutas públicas y protegidas; agrupa middleware `auth` y permisos.- `app/Observers/` : observers para eventos de modelo (AnalyticsObserver).- `app/Services/` : servicios orientados a lógica de negocio (AdminAnalyticsService).- `app/Http/Requests/` : validaciones por formulario (UserRequest, ProductoRequest, PedidoPagoRequest, etc.).- `app/Models/` : modelos Eloquent (Producto.php, Categoria.php, Pedido.php, Factura.php, Artista.php).- `app/Http/Controllers/` : controladores MVC (WebController, ProductoController, PedidoController, etc.).## 4. Estructura del Proyecto  - Modelos: `app/Models/*` (Producto, Categoria, Pedido, Factura, Artista, User, PedidoDetalle, InventarioMovimiento, ProductoResena, etc.) implementan relaciones Eloquent usadas por controladores y vistas.  - Observers y Providers: `app/Observers/AnalyticsObserver.php` observa guardar/eliminar para actualizar métricas.  - Requests form: `app/Http/Requests/*Request.php` (p. ej. `ProductoRequest`, `UserRequest`, `PedidoPagoRequest`) contienen reglas de validación y mensajes; usados en controladores.- Otros elementos técnicos importantes:    - Descripción: Servicio para cálculo de métricas y datasets usados en el dashboard administrativo.  - Métodos: `categories()`, `dashboardData()`, `indexSummaryStats()`, `categoriasVentasCards()`, `categoryData(string $categoria)`, `panelData()`- Archivo: [app/Services/AdminAnalyticsService.php](app/Services/AdminAnalyticsService.php#L1)    - Descripción: Administración y visualización de facturas; `pdf` genera PDF usando `barryvdh/laravel-dompdf`; `crearFacturaDesdePedido(Pedido $pedido)` crea o retorna factura existente a partir de un pedido (transacción DB).  - Métodos: `index`, `generarDesdePedido($pedidoId)`, `show($id)`, `pdf($id)`, `adminFacturasIndex(Request $request)`, `adminEdit($id)`- Archivo: [app/Http/Controllers/FacturaController.php](app/Http/Controllers/FacturaController.php#L1)    - Descripción: Endpoint AJAX para verificar unicidad de `identificador_unico` (opcional `ignore_id`).  - Método: `checkIdentifier(Request $request)`    - Descripción: CRUD de artistas; genera `slug` único, maneja carga de foto en `uploads/artistas`, y permite creación via AJAX (retorna JSON).  - Métodos REST: `index`, `create`, `store(ArtistaRequest)`, `edit`, `show`, `update`, `destroy`.- Archivo: [app/Http/Controllers/ArtistaController.php](app/Http/Controllers/ArtistaController.php#L1)    - Retorno: Redirección hacia la ruta intencionada o back con error.    - Parámetros: `LoginRequest`.    - Descripción: Intenta autenticación con `email`/`password`; bloquea si `activo` es false.  - Método: `login(LoginRequest $request)`- Archivo: [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php#L1)    - Descripción: Activa/desactiva usuario (`activo` flag) y persiste.  - Método: `toggleStatus(User $usuario)`ole` para asignar/ sincronizar roles y `Hash::make` para contraseñas.