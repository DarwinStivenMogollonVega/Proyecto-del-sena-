# ARQUITECTURA Y CLASIFICACIÓN DEL SISTEMA — TIENDA DE MÚSICA Y VINILOS
> Proyecto Laravel 11 · Bootstrap 5 + AdminLTE · Spatie Permissions · MariaDB  
> *Documento técnico de arquitectura full-stack — clasificación de vistas por módulos*

---

## 1. VISIÓN GENERAL DEL SISTEMA

Sistema de gestión e-commerce orientado a la venta de música física y digital (vinilos, CDs, formatos digitales). La plataforma opera en tres capas bien diferenciadas: un **panel administrativo** de gestión interna, un **área privada para clientes** registrados, y un **sitio web público** para visitantes. El control de acceso está implementado con Spatie Laravel Permission mediante roles (`admin`, `cliente`) y permisos granulares.

---

## 2. DIAGRAMA JERÁRQUICO DE MÓDULOS DEL SISTEMA

```
Sistema Tienda de Música
│
├── ══ CAPA 1: PANEL ADMINISTRATIVO ══
│   │
│   ├── [M-01] Panel de Control (Dashboard)
│   │
│   ├── [M-02] Seguridad y Control de Acceso
│   │   ├── Gestión de Usuarios
│   │   ├── Gestión de Roles y Permisos
│   │   └── Panel de Seguridad y Logs de Actividad
│   │
│   ├── [M-03] Gestión del Catálogo Musical
│   │   ├── Productos
│   │   ├── Artistas
│   │   ├── Categorías
│   │   └── Catálogos
│   │
│   ├── [M-04] Gestión Comercial
│   │   ├── Pedidos (administración)
│   │   └── Facturas
│   │
│   ├── [M-05] Administración de Clientes
│   │   ├── Listado de Clientes
│   │   └── Detalle / Historial de Cliente
│   │
│   └── [M-06] Gestión de Inventario
│       └── Movimientos de Stock y Alertas
│
├── ══ CAPA 2: ÁREA DEL CLIENTE ══
│   │
│   ├── [M-07] Gestión de Pedidos del Cliente
│   │   └── Mis Pedidos
│   │
│   ├── [M-08] Facturación del Cliente
│   │   ├── Recibos y comprobantes
│   │   └── Detalle de factura electrónica
│   │
│   └── [M-09] Perfil y Cuenta
│       └── Edición de perfil personal
│
└── ══ CAPA 3: SITIO WEB PÚBLICO ══
    │
    ├── [M-10] Catálogo Público
    │   ├── Listado general de productos
    │   ├── Productos por categoría
    │   └── Productos por catálogo
    │
    ├── [M-11] Ficha de Producto
    │   └── Detalle con reseñas de usuarios
    │
    ├── [M-12] Comercio (Carrito y Checkout)
    │   ├── Carrito de compras
    │   └── Formulario de pedido (checkout)
    │
    └── [M-13] Páginas Informativas
        └── Acerca de
```

---

## 3. CLASIFICACIÓN DETALLADA POR MÓDULOS

---

### ══════════════════════════════════
### CAPA 1 — PANEL ADMINISTRATIVO
### ══════════════════════════════════

---

#### [M-01] PANEL DE CONTROL — Dashboard

> **Descripción:** Vista central del panel administrativo. Consolida métricas clave del negocio, accesos rápidos a todos los módulos, tablas de actividad reciente y rankings de rendimiento comercial.

| Atributo | Valor |
|----------|-------|
| Ruta | `GET /dashboard` |
| Vista Blade | `resources/views/dashboard.blade.php` |
| Controlador | Closure en `routes/web.php` |
| Middleware | `auth`, `admin.activity` |
| Rol requerido | `admin` |

**Secciones funcionales de la vista:**

| # | Sección | Descripción |
|---|---------|-------------|
| 1 | Métricas estadísticas | 4 tarjetas KPI: Total Usuarios, Total Pedidos, Ingresos Totales, Total Productos |
| 2 | Top 5 Productos más vendidos | Tabla con imagen, nombre y unidades vendidas |
| 3 | Top 5 Clientes por gasto | Tabla con nombre, email y monto gastado |
| 4 | Últimos 10 Pedidos | Tabla con estado coloreado por semáforo |
| 5 | Últimas 8 Reseñas | Visualización de puntuación con estrellas y comentarios |
| 6 | Accesos rápidos a módulos | Tarjetas de navegación controladas por `@can` |

---

#### [M-02] SEGURIDAD Y CONTROL DE ACCESO

> **Descripción:** Módulo encargado de la gestión de identidad, autorización y auditoría del sistema. Centraliza la administración de usuarios del panel, la definición de roles y permisos, y el monitoreo de actividad administrativa.

---

##### [M-02-A] Gestión de Usuarios

| Atributo | Valor |
|----------|-------|
| Ruta base | `/usuarios` |
| Controlador | `App\Http\Controllers\UserController` |
| Form Request | `App\Http\Requests\UserRequest` |

| Vista | Ruta HTTP | Descripción |
|-------|-----------|-------------|
| `usuario/index.blade.php` | `GET /usuarios` | Listado paginado con búsqueda por nombre/email. Tabla: ID, Nombre, Email, Rol(es), Estado activo/inactivo |
| `usuario/action.blade.php` | `GET /usuarios/create` · `GET /usuarios/{id}/edit` | Formulario compartido crear/editar. Campos: Nombre, Email, Password (confirmado), Rol |
| `usuario/activate.blade.php` | Modal vía `PATCH /usuarios/{id}/toggle` | Modal de confirmación para activar/desactivar cuenta |
| `usuario/delete.blade.php` | Modal vía `DELETE /usuarios/{id}` | Modal de confirmación para eliminación permanente |

**Permisos Spatie requeridos:** `user-list`, `user-create`, `user-edit`, `user-delete`, `user-activate`

---

##### [M-02-B] Gestión de Roles y Permisos

| Atributo | Valor |
|----------|-------|
| Ruta base | `/roles` |
| Controlador | `App\Http\Controllers\RoleController` |

| Vista | Ruta HTTP | Descripción |
|-------|-----------|-------------|
| `role/index.blade.php` | `GET /roles` | Listado de roles con sus permisos en badges |
| `role/action.blade.php` | `GET /roles/create` · `GET /roles/{id}/edit` | Formulario de creación/edición con checkboxes de permisos agrupados |
| `role/delete.blade.php` | Modal vía `DELETE /roles/{id}` | Modal de confirmación para eliminar rol |

**Permisos Spatie requeridos:** `rol-list`, `rol-create`, `rol-edit`, `rol-delete`

---

##### [M-02-C] Panel de Seguridad y Logs de Actividad

| Atributo | Valor |
|----------|-------|
| Ruta | `GET /admin/seguridad` |
| Vista Blade | `resources/views/seguridad/index.blade.php` |
| Controlador | `App\Http\Controllers\SeguridadController@index` |

| Columna | Contenido |
|---------|-----------|
| Izquierda | Roles del sistema con sus permisos en badges; lista de usuarios con rol `admin` |
| Derecha | Logs de actividad administrativa paginados: método HTTP, nombre de ruta, URL, IP, user agent |

**Fuente de datos:** Tabla `admin_activity_logs` (registrada por middleware `admin.activity`)  
**Permisos requeridos:** `rol-list` o `user-list`

---

#### [M-03] GESTIÓN DEL CATÁLOGO MUSICAL

> **Descripción:** Módulo de administración del inventario informacional del negocio. Gestiona la entidad central (`Producto`) y sus entidades de clasificación y metadatos (`Artista`, `Categoria`, `Catalogo`). Implementa CRUD completo con soporte para imágenes, datos musicales específicos y relaciones entre entidades.

---

##### [M-03-A] Productos

| Atributo | Valor |
|----------|-------|
| Ruta base | `/productos` |
| Controlador | `App\Http\Controllers\ProductoController` |
| Form Request | `App\Http\Requests\ProductoRequest` |

| Vista | Ruta HTTP | Descripción |
|-------|-----------|-------------|
| `producto/index.blade.php` | `GET /productos` | Listado paginado con búsqueda. Tabla: ID, Código, Nombre, Precio, Cantidad, Artista, Género, Año, Formato, Categoría, Catálogo, Imagen thumbnail |
| `producto/action.blade.php` | `GET /productos/create` · `GET /productos/{id}/edit` | Formulario completo: código, nombre, precio, stock, categoría, catálogo, artista, género musical, año lanzamiento, formato (cd/vinilo/digital), descripción, lista de canciones (JSON), imagen (upload) |
| `producto/delete.blade.php` | Modal vía `DELETE /productos/{id}` | Modal de confirmación para eliminación |

**Permisos Spatie requeridos:** `producto-list`, `producto-create`, `producto-edit`, `producto-delete`

---

##### [M-03-B] Artistas

| Atributo | Valor |
|----------|-------|
| Ruta base | `/artistas` |
| Controlador | `App\Http\Controllers\ArtistaController` |

| Vista | Ruta HTTP | Descripción |
|-------|-----------|-------------|
| `artista/index.blade.php` | `GET /artistas` | Listado: ID, Nombre, Slug, Foto thumbnail, Biografía truncada |
| `artista/action.blade.php` | `GET /artistas/create` · `GET /artistas/{id}/edit` | Formulario: Nombre, Slug (auto-generado o manual), Foto (upload), Biografía |

**Permisos Spatie requeridos:** `artista-list`, `artista-create`, `artista-edit`, `artista-delete`  
*(Fallback: se verifica también `producto-list/create/edit/delete`)*

---

##### [M-03-C] Categorías

| Atributo | Valor |
|----------|-------|
| Ruta base | `/categoria` |
| Controlador | `App\Http\Controllers\CategoriaController` |
| Form Request | `App\Http\Requests\CategoriaRequest` |

| Vista | Ruta HTTP | Descripción |
|-------|-----------|-------------|
| `categoria/index.blade.php` | `GET /categoria` | Listado: Nombre, Descripción, Acciones |
| `categoria/action.blade.php` | `GET /categoria/create` · `GET /categoria/{id}/edit` | Formulario: Nombre (max:100), Descripción |
| `categoria/delete.blade.php` | Modal vía `DELETE /categoria/{id}` | Confirmación de eliminación |

> **Nota:** `CategoriaController@show` también sirve la vista pública `/categoria-web/{id}` (ver Capa 3).

**Permisos Spatie requeridos:** `categoria-list`, `categoria-create`, `categoria-edit`, `categoria-delete`

---

##### [M-03-D] Catálogos

| Atributo | Valor |
|----------|-------|
| Ruta base | `/catalogo` |
| Controlador | `App\Http\Controllers\CatalogoController` |
| Form Request | `App\Http\Requests\CatalogoRequest` |

| Vista | Ruta HTTP | Descripción |
|-------|-----------|-------------|
| `catalogo/index.blade.php` | `GET /catalogo` | Listado: Nombre, Descripción, Acciones |
| `catalogo/action.blade.php` | `GET /catalogo/create` · `GET /catalogo/{id}/edit` | Formulario: Nombre (max:150), Descripción |

> **Nota:** `CatalogoController@show` también sirve la vista pública `/catalogo-web/{id}` (ver Capa 3).

**Permisos Spatie requeridos:** `catalogo-list`, `catalogo-create`, `catalogo-edit`, `catalogo-delete`

---

#### [M-04] GESTIÓN COMERCIAL

> **Descripción:** Módulo de operaciones comerciales del negocio. Centraliza la administración de pedidos entrantes y la gestión del ciclo de vida de facturas. Incluye soporte para facturación electrónica, cambio de estados de pedido y carga de comprobantes de pago.

---

##### [M-04-A] Pedidos (Administración)

| Atributo | Valor |
|----------|-------|
| Ruta | `GET /admin/pedidos` |
| Vista Blade | `resources/views/pedido/index.blade.php` |
| Controlador | `App\Http\Controllers\PedidoController@adminIndex` |

**Funcionalidades de la vista:**
- Tabla principal: ID, Fecha, Usuario, Badge FE (factura electrónica), Total, Estado (badge semáforo), botón Detalles
- Panel colapsable por fila: ítems del pedido con imagen, nombre, cantidad, precio unitario
- Bloque de datos de facturación electrónica (si `requiere_factura_electronica = true`)
- Modal de cambio de estado vía `PATCH /pedidos/{id}/estado`

**Estados del ciclo de vida del pedido:**

| Estado | Semántica |
|--------|-----------|
| `pendiente` | Pedido recibido, sin procesar |
| `procesando` | En preparación / verificación de pago |
| `enviado` | Despachado al cliente |
| `entregado` | Confirmado como recibido |
| `cancelado` | Cancelado por el cliente |
| `anulado` | Anulado por el administrador |

**Permisos requeridos:** `pedido-list`, `pedido-anulate`

| Vista auxiliar | Ruta HTTP | Descripción |
|----------------|-----------|-------------|
| `pedido/state.blade.php` | Modal vía `PATCH /pedidos/{id}/estado` | Modal para cambiar el estado del pedido |

---

##### [M-04-B] Facturas

| Atributo | Valor |
|----------|-------|
| Ruta base | `/admin/facturas` |
| Controlador | `App\Http\Controllers\PedidoController` |

| Método | Ruta HTTP | Acción del Controlador | Descripción |
|--------|-----------|------------------------|-------------|
| GET | `/admin/facturas` | `adminFacturasIndex` | Listado de facturas |
| GET | `/admin/facturas/crear` | `adminFacturasCreate` | Formulario de nueva factura |
| POST | `/admin/facturas` | `adminFacturasStore` | Guardar nueva factura |
| GET | `/admin/facturas/{id}/editar` | `adminFacturasEdit` | Formulario de edición |
| PUT | `/admin/facturas/{id}` | `adminFacturasUpdate` | Actualizar factura |
| DELETE | `/admin/facturas/{id}` | `adminFacturasDestroy` | Eliminar factura |

**Campos de facturación electrónica en modelo `Pedido`:** `requiere_factura_electronica`, `tipo_documento`, `numero_documento`, `razon_social`, `correo_factura`

---

#### [M-05] ADMINISTRACIÓN DE CLIENTES

> **Descripción:** Módulo de gestión y análisis de la base de clientes registrados con rol `cliente`. Permite al administrador inspeccionar estado de cuenta, historial de compras y métricas individuales sin interferir con la gestión de usuarios del sistema.

| Atributo | Valor |
|----------|-------|
| Ruta base | `/admin/clientes` |
| Controlador | `App\Http\Controllers\ClienteGestionController` |
| Permisos | `user-list` |

| Vista | Ruta HTTP | Descripción |
|-------|-----------|-------------|
| `cliente_gestion/index.blade.php` | `GET /admin/clientes` | Tabla de clientes: ID, Nombre, Email, Estado (activo/inactivo), Total de Compras, Acciones |
| `cliente_gestion/show.blade.php` | `GET /admin/clientes/{id}` | Detalle individual: información de cuenta, historial completo de pedidos, estadísticas de gasto total |

---

#### [M-06] GESTIÓN DE INVENTARIO

> **Descripción:** Módulo de control de stock físico del almacén. Registra los movimientos de inventario (entradas, salidas, ajustes manuales), mantiene una traza auditable de cada operación y genera alertas automáticas ante niveles críticos de stock.

| Atributo | Valor |
|----------|-------|
| Ruta base | `/admin/inventario` |
| Vista Blade | `resources/views/inventario/index.blade.php` |
| Controlador | `App\Http\Controllers\InventarioController` |
| Permisos | `inventario-list`, `inventario-edit` |

**Layout de dos columnas:**

| Columna | Contenido |
|---------|-----------|
| Izquierda | Listado de productos con stock actual + formulario inline de movimiento (tipo: entrada/salida/ajuste, cantidad, motivo opcional) |
| Derecha | Panel de alertas: productos con stock ≤ 5 unidades (umbral crítico) |

**Endpoint de movimiento:** `POST /admin/inventario/{id}/movimiento`

**Trazabilidad:** Cada movimiento registra en `inventario_movimientos`: `tipo`, `cantidad`, `stock_anterior`, `stock_nuevo`, `motivo`, `user_id`, `timestamps`.

---

### ══════════════════════════════════
### CAPA 2 — ÁREA DEL CLIENTE
### ══════════════════════════════════

> **Descripción:** Capa de acceso restringido para usuarios autenticados con rol `cliente`. Permite gestionar sus transacciones, acceder a sus comprobantes y mantener su información personal.

---

#### [M-07] GESTIÓN DE PEDIDOS DEL CLIENTE

| Vista | Ruta HTTP | Controlador | Descripción |
|-------|-----------|-------------|-------------|
| `web/mis_pedidos.blade.php` | `GET /perfil/pedidos` | `PedidoController@misPedidos` | Listado personal de pedidos del cliente autenticado. Incluye opción de cancelar pedidos en estado `pendiente` |

**Permisos requeridos:** `pedido-view`, `pedido-cancel`

---

#### [M-08] FACTURACIÓN DEL CLIENTE

| Vista | Ruta HTTP | Controlador | Descripción |
|-------|-----------|-------------|-------------|
| `web/recibos_factura.blade.php` | `GET /perfil/recibos-factura` | `PedidoController@recibosFactura` | Listado de recibos y facturas electrónicas asociados al cliente autenticado |
| `web/recibo_factura_detalle.blade.php` | `GET /perfil/recibos-factura/{id}` | `PedidoController@verReciboFactura` | Detalle completo de un recibo/factura: datos del pedido, ítems, información de facturación electrónica |

---

#### [M-09] PERFIL Y CUENTA

| Vista | Ruta HTTP | Controlador | Descripción |
|-------|-----------|-------------|-------------|
| `autenticacion/perfil.blade.php` | `GET /perfil` | `PerfilController@edit` | Formulario de edición del perfil personal: nombre, email, contraseña |

**Permiso requerido:** `perfil`  
**Método de actualización:** `PUT /perfil` → `PerfilController@update`

---

#### AUTENTICACIÓN (COMPARTIDA — ADMIN + CLIENTE)

| Vista | Ruta | Descripción |
|-------|------|-------------|
| `autenticacion/login.blade.php` | `GET /login` · `POST /login` | Formulario de inicio de sesión |
| `autenticacion/registro.blade.php` | `GET /registro` · `POST /registro` | Registro de nuevos clientes |
| `autenticacion/email.blade.php` | `GET /password/reset` · `POST /password/email` | Solicitud de restablecimiento de contraseña |
| `autenticacion/reset.blade.php` | `GET /password/reset/{token}` · `POST /password/reset` | Formulario de nueva contraseña con token |

---

### ══════════════════════════════════
### CAPA 3 — SITIO WEB PÚBLICO
### ══════════════════════════════════

> **Descripción:** Capa de acceso sin autenticación. Es la interfaz comercial visible para visitantes: exploración del catálogo, detalle de productos con reseñas y flujo de compra (carrito + checkout). Usa el layout `web/app.blade.php` diferenciado del panel administrativo.

**Layout:** `resources/views/web/app.blade.php`  
**Controladores:** `WebController`, `CarritoController`

---

#### [M-10] CATÁLOGO PÚBLICO

| Vista | Ruta HTTP | Controlador | Descripción |
|-------|-----------|-------------|-------------|
| `web/index.blade.php` | `GET /` | `WebController@index` | Página principal: listado general de productos con filtros de búsqueda |
| `web/categoria.blade.php` | `GET /categoria-web/{id}` | `CategoriaController@show` | Listado de productos filtrado por categoría seleccionada |
| `web/catalogo.blade.php` | `GET /catalogo-web/{id}` | `CatalogoController@show` | Listado de productos filtrado por catálogo seleccionado |

---

#### [M-11] FICHA DE PRODUCTO

| Vista | Ruta HTTP | Controlador | Descripción |
|-------|-----------|-------------|-------------|
| *(detalle inline)* | `GET /producto/{id}` | `WebController@show` | Detalle completo del producto: información musical, artista, categoría, puntuación media, listado de reseñas |

**Reseñas:** `POST /producto/{id}/resena` → `WebController@guardarResena` *(requiere `auth`)*

---

#### [M-12] COMERCIO — CARRITO Y CHECKOUT

| Vista | Ruta HTTP | Controlador | Descripción |
|-------|-----------|-------------|-------------|
| `web/pedido.blade.php` | `GET /carrito` | `CarritoController@mostrar` | Carrito de compras con ítems, cantidades, subtotales y botones sumar/restar/eliminar |
| `web/formulario_pedido.blade.php` | `GET /pedido/formulario` | `PedidoController@formulario` | Checkout: nombre, email, teléfono, dirección, método de pago, comprobante de pago (upload), opción de factura electrónica con campos tributarios |

**Operaciones del carrito:**

| Acción | Ruta |
|--------|------|
| Agregar producto | `POST /carrito/agregar` |
| Sumar unidad | `GET /carrito/sumar?id={id}` |
| Restar unidad | `GET /carrito/restar?id={id}` |
| Eliminar ítem | `GET /carrito/eliminar/{id}` |
| Vaciar carrito | `GET /carrito/vaciar` |
| Confirmar pedido | `POST /pedido/realizar` |

---

#### [M-13] PÁGINAS INFORMATIVAS

| Vista | Ruta HTTP | Controlador | Descripción |
|-------|-----------|-------------|-------------|
| `web/acerca.blade.php` | `GET /acerca` | Closure en `web.php` | Página estática informativa "Acerca de" |

---

## 4. MATRIZ DE CAPAS × MÓDULOS

| Módulo | Capa | Rol / Acceso | Permisos clave |
|--------|------|--------------|----------------|
| [M-01] Dashboard | Panel Admin | `admin` | — (rol) |
| [M-02-A] Usuarios | Panel Admin | `admin` | `user-*` |
| [M-02-B] Roles | Panel Admin | `admin` | `rol-*` |
| [M-02-C] Seguridad / Logs | Panel Admin | `admin` | `rol-list` o `user-list` |
| [M-03-A] Productos | Panel Admin | `admin` | `producto-*` |
| [M-03-B] Artistas | Panel Admin | `admin` | `artista-*` |
| [M-03-C] Categorías | Panel Admin | `admin` | `categoria-*` |
| [M-03-D] Catálogos | Panel Admin | `admin` | `catalogo-*` |
| [M-04-A] Pedidos admin | Panel Admin | `admin` | `pedido-list`, `pedido-anulate` |
| [M-04-B] Facturas | Panel Admin | `admin` | `pedido-list` |
| [M-05] Clientes | Panel Admin | `admin` | `user-list` |
| [M-06] Inventario | Panel Admin | `admin` | `inventario-list`, `inventario-edit` |
| [M-07] Mis Pedidos | Área Cliente | `cliente` | `pedido-view`, `pedido-cancel` |
| [M-08] Recibos / FE | Área Cliente | `cliente` | `pedido-view` |
| [M-09] Perfil | Área Cliente + Admin | autenticado | `perfil` |
| [M-10] Catálogo público | Web Pública | visitante | — |
| [M-11] Ficha de producto | Web Pública | visitante | — |
| [M-12] Carrito / Checkout | Web Pública | visitante + auth | — |
| [M-13] Páginas estáticas | Web Pública | visitante | — |

---

## 5. ESTRUCTURA DEL MENÚ LATERAL (SIDEBAR)

```
Sidebar (plantilla/menu.blade.php)
│
├── Dashboard                         [id: mnuDashboard]
│
└── Secciones del Panel               [id: mnuPanelSecciones]  ← grupo padre
    ├── Clientes                      [id: mnuClientes]          @can user-list
    ├── Gestión Pedidos               [id: mnuPedidos]           @role admin
    │   └── (o) Mis Pedidos                                       @role cliente
    ├── Facturas                      [id: mnuFacturas]          @role admin
    │   └── (o) Recibos FE           [id: mnuRecibosFactura]    @role cliente
    ├── Seguridad ▾                   [id: mnuSeguridad]         @canany [user-list, rol-list]
    │   ├── Usuarios                  [id: itemUsuario]          @can user-list
    │   └── Roles                     [id: itemRole]             @can rol-list
    ├── Productos                     [id: itemProducto]         @can producto-list
    ├── Catálogo                      [id: itemCatalogo]         @can catalogo-list
    ├── Artistas                      [id: itemArtista]          @can artista-list
    ├── Inventario                    [id: itemInventario]       @can inventario-list
    ├── Categorías                    [id: itemCategoria]        @can categoria-list
    └── Seguridad Sistema             [id: mnuSeguridadPanel]    @canany [rol-list, user-list]
```

**Activación automática del grupo padre:** script `DOMContentLoaded` en `menu.blade.php` abre `mnuPanelSecciones` si algún hijo tiene clase `active`.

**Patrón JS en cada vista individual:**
```javascript
document.getElementById('mnuPanelSecciones').classList.add('menu-open');
document.getElementById('itemProducto').classList.add('active'); // ← ID según módulo
```

---

## 6. MODELOS Y BASE DE DATOS

### Relaciones entre entidades

```
User ─────────────┬──< Pedido >──< PedidoDetalle >── Producto ──< ProductoResena >── User
                  ├──< InventarioMovimiento                │
                  └──< AdminActivityLog          ┌─────────┼──────────┐
                                                 │         │          │
                                              Artista  Categoria  Catalogo
```

### Tablas principales

| Tabla | Modelo | Campos destacados |
|-------|--------|-------------------|
| `users` | `User` | `name`, `email`, `password`, `activo` |
| `productos` | `Producto` | `codigo`, `nombre`, `precio`, `cantidad`, `artista_id`, `categoria_id`, `catalogo_id`, `formato_producto`, `lista_canciones` (JSON) |
| `pedidos` | `Pedido` | `user_id`, `total`, `estado`, `metodo_pago`, `comprobante_pago`, `requiere_factura_electronica`, datos tributarios |
| `pedido_detalles` | `PedidoDetalle` | `pedido_id`, `producto_id`, `cantidad`, `precio` |
| `categorias` | `Categoria` | `nombre`, `descripcion` |
| `catalogos` | `Catalogo` | `nombre`, `descripcion` |
| `artistas` | `Artista` | `nombre`, `slug`, `foto`, `biografia` |
| `producto_resenas` | `ProductoResena` | `producto_id`, `user_id`, `puntuacion` (1-5), `comentario` |
| `inventario_movimientos` | `InventarioMovimiento` | `producto_id`, `user_id`, `tipo` (entrada/salida/ajuste), `stock_anterior`, `stock_nuevo`, `motivo` |
| `admin_activity_logs` | `AdminActivityLog` | `user_id`, `method`, `route_name`, `url`, `ip_address`, `user_agent` |

### Tablas Spatie Permission
`roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`

---

## 7. ROLES Y PERMISOS

### Rol: `admin` (24 permisos)
```
user-list    · user-create    · user-edit    · user-delete    · user-activate
rol-list     · rol-create     · rol-edit     · rol-delete
producto-list · producto-create · producto-edit · producto-delete
artista-list · artista-create · artista-edit · artista-delete
inventario-list · inventario-edit
pedido-list  · pedido-anulate
categoria-list · categoria-create · categoria-edit · categoria-delete
catalogo-list  · catalogo-create  · catalogo-edit  · catalogo-delete
```

### Rol: `cliente` (3 permisos)
```
pedido-view · pedido-cancel · perfil
```

### Usuarios seed por defecto
| Email | Password | Rol |
|-------|----------|-----|
| `admin@prueba.com` | `admin123456` | `admin` |
| `cliente@prueba.com` | `cliente123456` | `cliente` |

---

## 8. FORM REQUESTS

| Request | Aplica a | Reglas clave |
|---------|----------|--------------|
| `UserRequest` | Usuarios | `email` unique excepto propio, `password` min:8 confirmado, requerido solo en POST |
| `ProductoRequest` | Productos | `codigo` unique, `precio`/`cantidad` numeric, `formato_producto` in:[cd,vinilo,digital], `imagen` requerida en create |
| `CategoriaRequest` | Categorías | `name` max:100 |
| `CatalogoRequest` | Catálogos | `nombre` max:150 |

---

## 9. MIDDLEWARE

| Middleware | Alcance | Función |
|------------|---------|---------|
| `auth` | Rutas protegidas | Redirige a `/login` si el usuario no está autenticado |
| `admin.activity` | Panel administrativo | Registra cada petición en `admin_activity_logs` con método HTTP, ruta, URL, IP y user agent |
| CSRF | Formularios POST/PUT/DELETE | Protección estándar Laravel contra CSRF |

---

## 10. CONVENCIONES DEL PROYECTO

| Convención | Detalle |
|------------|---------|
| Migraciones | Siempre ejecutar `php artisan migrate --seed` |
| Archivos subidos | Almacenados en `public/uploads/` (acceso directo sin `storage:link`) |
| Modo oscuro/claro | Toggle en header, persiste en `localStorage`, aplica `data-theme` en `<html>` |
| Dark mode CSS | No usar selectores globales como `html[data-theme='dark'] span`; siempre escopeados a contenedores |
| Validaciones | Usar Form Requests; no validar manualmente en controladores |
| Permisos en vistas | Directivas Spatie: `@can`, `@canany`, `@role` |
| IDs de menú | Documentados en Sección 5 de este documento |

---

## 11. COMANDOS DE REFERENCIA

```bash
# Migraciones y seeders (estándar del proyecto)
php artisan migrate --seed

# Limpiar caché de permisos Spatie
php artisan permission:cache-reset

# Ver listado completo de rutas
php artisan route:list

# Limpiar cachés de configuración y vistas
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 12. ESTADO ACTUAL DEL PROYECTO

| Módulo | Estado |
|--------|--------|
| CRUD Usuarios + Roles | ✅ Completado |
| CRUD Productos + Artistas + Categorías + Catálogos | ✅ Completado |
| Gestión de Pedidos (admin + cliente) con FE | ✅ Completado |
| Inventario con movimientos y alertas de bajo stock | ✅ Completado |
| Panel de Seguridad con logs de actividad | ✅ Completado |
| Gestión de Clientes (vista admin) | ✅ Completado |
| Carrito de compras y checkout con comprobante | ✅ Completado |
| Reseñas de productos | ✅ Completado |
| Modo oscuro/claro persistente | ✅ Completado |
| Sidebar con agrupación única "Secciones del Panel" | ✅ Completado |
| Dashboard con KPIs, rankings y accesos rápidos | ✅ Completado |
| Sistema de roles y permisos granular (Spatie) | ✅ Completado |
