# Métodos exhaustivos: Models, Requests, Providers y Observers

Nota: este archivo contiene un listado exhaustivo de los métodos públicos encontrados en los modelos, Requests, providers y observers del proyecto.

## Modelos

- Archivo: [app/Models/User.php](app/Models/User.php#L1)
  - `entradas()`
    - Descripción: relación `hasMany` con `Entrada`.
    - Parámetros: ninguno
    - Retorno: `HasMany`.
  - `getIdAttribute()`
    - Descripción: devuelve el valor de la PK (`usuario_id`) para compatibilidad con código que usa `id`.
    - Retorno: `int|null`.
  - `pedidos()`
    - Descripción: relación `hasMany` con `Pedido` (clave `usuario_id`).
  - `facturas()`
    - Descripción: relación `hasMany` con `Factura` (clave `usuario_id`).
  - `inventarioMovimientos()`
    - Descripción: relación `hasMany` con `InventarioMovimiento`.
  - `adminActivityLogs()`
    - Descripción: relación `hasMany` con `AdminActivityLog`.

- Archivo: [app/Models/Proveedor.php](app/Models/Proveedor.php#L1)
  - `productos()` — `hasMany(Producto::class, 'proveedor_id')`.
  - `getIdAttribute()` — devuelve PK `proveedor_id`.

- Archivo: [app/Models/ProductoResena.php](app/Models/ProductoResena.php#L1)
  - `producto()` — `belongsTo(Producto::class, 'producto_id')`.
  - `usuario()` — `belongsTo(User::class, 'usuario_id')`.
  - `user()` — alias que llama a `usuario()` (compatibilidad con vistas/servicios).
  - `getIdAttribute()` — devuelve la PK `resena_producto_id`.

- Archivo: [app/Models/Producto.php](app/Models/Producto.php#L1)
  - `categoria()` — `belongsTo(Categoria::class)`.
  - `catalogo()` — `belongsTo(Catalogo::class)`.
  - `artista()` — `belongsTo(Artista::class, 'artista_id', 'artista_id')`.
  - `proveedor()` — `belongsTo(Proveedor::class)`.
  - `resenas()` — `hasMany(ProductoResena::class)`.

- Archivo: [app/Models/PedidoDetalle.php](app/Models/PedidoDetalle.php#L1)
  - `pedido()` — `belongsTo(Pedido::class)`.
  - `producto()` — `belongsTo(Producto::class)`.

- Archivo: [app/Models/Pedido.php](app/Models/Pedido.php#L1)
  - `detalles()` — `hasMany(PedidoDetalle::class)`.
  - `user()` — `belongsTo(User::class, 'usuario_id')`.
  - `factura()` — `hasOne(Factura::class)`.

- Archivo: [app/Models/InventarioMovimiento.php](app/Models/InventarioMovimiento.php#L1)
  - `producto()` — `belongsTo(Producto::class, 'producto_id')`.
  - `user()` — `belongsTo(User::class, 'usuario_id')`.
  - `getIdAttribute()` — devuelve `movimiento_inventario_id`.

- Archivo: [app/Models/Factura.php](app/Models/Factura.php#L1)
  - `pedido()` — `belongsTo(Pedido::class)`.
  - `user()` — `belongsTo(User::class, 'usuario_id')`.
  - `getIdAttribute()` — devuelve `factura_id`.

- Archivo: [app/Models/Categoria.php](app/Models/Categoria.php#L1)
  - `productos()` — `hasMany(Producto::class)`.

- Archivo: [app/Models/Catalogo.php](app/Models/Catalogo.php#L1)
  - `productos()` — `hasMany(Producto::class, 'catalogo_id', 'catalogo_id')`.
  - `getIdAttribute()` — devuelve `catalogo_id`.

- Archivo: [app/Models/Artista.php](app/Models/Artista.php#L1)
  - `productos()` — `hasMany(Producto::class, 'artista_id', 'artista_id')`.
  - `getIdAttribute()` — devuelve `artista_id`.

- Archivo: [app/Models/AdminActivityLog.php](app/Models/AdminActivityLog.php#L1)
  - `user()` — `belongsTo(User::class, 'usuario_id', 'usuario_id')`.
  - `getIdAttribute()` — devuelve `registro_actividad_admin_id`.

## Requests (validaciones)

Cada Request implementa fundamentalmente tres métodos: `authorize()`, `rules()` y opcionalmente `messages()`.

- Archivo: [app/Http/Requests/UserRequest.php](app/Http/Requests/UserRequest.php#L1)
  - `authorize(): bool` — devuelve `true`.
  - `rules(): array` — reglas de validación para creación y edición de usuario (unicidad en `usuarios` usando `usuario_id`, `fecha_nacimiento`, `avatar`, y diferencias POST/PUT en `password`).
  - `messages()` — mensajes personalizados.

- Archivo: [app/Http/Requests/ProductoRequest.php](app/Http/Requests/ProductoRequest.php#L1)
  - `authorize(): bool`.
  - `rules(): array` — reglas para `codigo`, `nombre`, `precio`, `cantidad`, relaciones y `imagen` con condición POST/PUT.
  - `messages(): array` — mensajes personalizados.

- Archivo: [app/Http/Requests/PedidoRealizarRequest.php](app/Http/Requests/PedidoRealizarRequest.php#L1)
  - `authorize()`, `rules()` (validación condicional si se envía `metodo_pago`), `messages()`.

- Archivo: [app/Http/Requests/PedidoPagoRequest.php](app/Http/Requests/PedidoPagoRequest.php#L1)
  - `authorize()`, `rules()` (incluye `comprobante_pago` imagen y validaciones condicionales para factura electrónica), `messages()`.

- Archivo: [app/Http/Requests/PedidoEntregaRequest.php](app/Http/Requests/PedidoEntregaRequest.php#L1)
  - `authorize()`, `rules()` (dirección requerida), `messages()`.

- Archivo: [app/Http/Requests/PedidoDatosRequest.php](app/Http/Requests/PedidoDatosRequest.php#L1)
  - `authorize()`, `rules()` (nombre, email, telefono), `messages()`.

- Archivo: [app/Http/Requests/LoginRequest.php](app/Http/Requests/LoginRequest.php#L1)
  - `authorize()`, `rules()` (`email` existe en tabla `usuarios`), `messages()`.

- Archivo: [app/Http/Requests/CategoriaRequest.php](app/Http/Requests/CategoriaRequest.php#L1)
  - `authorize()`, `rules()` (`name`, `description`), `messages()`.

- Archivo: [app/Http/Requests/CatalogoRequest.php](app/Http/Requests/CatalogoRequest.php#L1)
  - `authorize()`, `rules()` (`nombre`, `descripcion`), `messages()`.

- Archivo: [app/Http/Requests/ArtistaRequest.php](app/Http/Requests/ArtistaRequest.php#L1)
  - `authorize()`, `rules()` (regla `unique` para `identificador_unico` que ignora el registro actual en updates), `messages` implícito.

## Providers y Observers

- Archivo: [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php#L1)
  - `register(): void` — método del service provider (vacío en esta app).
  - `boot(): void` — configura paginación Bootstrap, registra View composer para `web.*` (cache de `categorias` y `catalogos`) y registra `AnalyticsObserver` sobre múltiples modelos.

- Archivo: [app/Observers/AnalyticsObserver.php](app/Observers/AnalyticsObserver.php#L1)
  - `__construct()` — instancia `AdminAnalyticsService`.
  - `saved($model): void` — callback de Eloquent al guardar; dispara `broadcast()`.
  - `deleted($model): void` — callback al eliminar; dispara `broadcast()`.
  - `broadcast(): void` (protegido) — construye payload con métricas desde `AdminAnalyticsService::panelData()` y emite evento `StatisticsUpdated`.

---

Si quieres, puedo:
- añadir relaciones inversas y atributos calculados en cada modelo,
- documentar los métodos públicos en `app/Services` (p. ej. `AdminAnalyticsService`),
- generar ejemplos de request payloads (`form-data`/JSON) para los endpoints principales.
