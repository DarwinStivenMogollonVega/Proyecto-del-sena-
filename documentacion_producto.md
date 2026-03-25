# Documentación del Producto

## 1. Visión General del Sistema

DiscZone es una plataforma e-commerce para la venta de música física y digital (vinilos, CDs, formatos digitales). El sistema está construido sobre Laravel 11, utiliza Bootstrap 5 + AdminLTE para la interfaz, Spatie Permissions para control de acceso y MariaDB como base de datos. Opera en tres capas principales:

- **Panel administrativo**: gestión interna y administración de la tienda.
- **Área privada de clientes**: gestión de pedidos, perfil y facturación para usuarios autenticados.
- **Sitio web público**: exploración del catálogo y proceso de compra para visitantes.

El acceso está controlado por roles (`admin`, `cliente`) y permisos granulares.

## 2. Arquitectura y Módulos Principales

### Diagrama Jerárquico de Módulos

- Panel Administrativo
  - Dashboard
  - Seguridad y Control de Acceso (Usuarios, Roles, Logs)
  - Gestión del Catálogo Musical (Productos, Artistas, Categorías, Catálogos)
  - Gestión Comercial (Pedidos, Facturas)
  - Administración de Clientes
  - Gestión de Inventario
- Área del Cliente
  - Mis Pedidos
  - Facturación
  - Perfil y Cuenta
- Sitio Web Público
  - Catálogo Público
  - Ficha de Producto
  - Carrito y Checkout
  - Páginas Informativas (Acerca de)

### Matriz de Capas × Módulos

| Módulo                | Capa                | Rol/Acceso   | Permisos clave           |
|-----------------------|---------------------|--------------|-------------------------|
| Dashboard             | Panel Admin         | admin        | —                       |
| Usuarios              | Panel Admin         | admin        | user-*                  |
| Roles                 | Panel Admin         | admin        | rol-*                   |
| Seguridad / Logs      | Panel Admin         | admin        | rol-list, user-list     |
| Productos             | Panel Admin         | admin        | producto-*              |
| Artistas              | Panel Admin         | admin        | artista-*               |
| Categorías            | Panel Admin         | admin        | categoria-*             |
| Catálogos             | Panel Admin         | admin        | catalogo-*              |
| Pedidos admin         | Panel Admin         | admin        | pedido-list, pedido-anulate |
| Facturas              | Panel Admin         | admin        | pedido-list             |
| Clientes              | Panel Admin         | admin        | user-list               |
| Inventario            | Panel Admin         | admin        | inventario-list, inventario-edit |
| Mis Pedidos           | Área Cliente        | cliente      | pedido-view, pedido-cancel |
| Recibos / FE          | Área Cliente        | cliente      | pedido-view             |
| Perfil                | Área Cliente/Admin  | autenticado  | perfil                  |
| Catálogo público      | Web Pública         | visitante    | —                       |
| Ficha de producto     | Web Pública         | visitante    | —                       |
| Carrito / Checkout    | Web Pública         | visitante+auth | —                     |
| Páginas estáticas     | Web Pública         | visitante    | —                       |

## 3. Descripción de Módulos y Componentes

### [M-01] Panel de Control — Dashboard
- Consolida métricas clave, accesos rápidos, actividad reciente y rankings.
- Ruta: `GET /dashboard`
- Vista: `resources/views/dashboard.blade.php`
- Controlador: Closure en `routes/web.php`
- Middleware: `auth`, `admin.activity`
- Rol: `admin`

### [M-02] Seguridad y Control de Acceso
- Gestión de identidad, roles, permisos y auditoría.
- Submódulos: Usuarios, Roles y Permisos, Logs de Actividad.
- Permisos: `user-*`, `rol-*`

#### Usuarios
- CRUD de usuarios, activación/desactivación, asignación de roles.
- Controlador: `App\Http\Controllers\UserController`
- Form Request: `App\Http\Requests\UserRequest`

#### Roles y Permisos
- CRUD de roles, asignación de permisos.
- Controlador: `App\Http\Controllers\RoleController`

#### Logs de Actividad
- Registro de acciones administrativas.
- Controlador: `App\Http\Controllers\SeguridadController`

### [M-03] Gestión del Catálogo Musical
- Administración de productos, artistas, categorías y catálogos.
- CRUD completo, soporte para imágenes y metadatos musicales.

#### Productos
- Controlador: `App\Http\Controllers\ProductoController`
- Form Request: `App\Http\Requests\ProductoRequest`
- Vista: `producto/index.blade.php`
- Permisos: `producto-*`

#### Artistas
- Controlador: `App\Http\Controllers\ArtistaController`
- Vista: `artista/index.blade.php`
- Permisos: `artista-*`

#### Categorías
- Controlador: `App\Http\Controllers\CategoriaController`
- Form Request: `App\Http\Requests\CategoriaRequest`
- Vista: `categoria/index.blade.php`
- Permisos: `categoria-*`

#### Catálogos
- Controlador: `App\Http\Controllers\CatalogoController`
- Form Request: `App\Http\Requests\CatalogoRequest`
- Vista: `catalogo/index.blade.php`
- Permisos: `catalogo-*`

### [M-04] Gestión Comercial
- Administración de pedidos y facturas, soporte para facturación electrónica.
- Controlador: `App\Http\Controllers\PedidoController`, `App\Http\Controllers\FacturaController`
- Vistas: `pedido/index.blade.php`, `factura/index.blade.php`
- Permisos: `pedido-*`

### [M-05] Administración de Clientes
- Gestión y análisis de clientes con rol `cliente`.
- Controlador: `App\Http\Controllers\ClienteGestionController`
- Vista: `cliente_gestion/index.blade.php`
- Permisos: `user-list`

### [M-06] Gestión de Inventario
- Control de stock, movimientos y alertas de bajo inventario.
- Controlador: `App\Http\Controllers\InventarioController`
- Vista: `inventario/index.blade.php`
- Permisos: `inventario-list`, `inventario-edit`

### [M-07] Gestión de Pedidos del Cliente
- Listado y cancelación de pedidos personales.
- Controlador: `PedidoController@misPedidos`
- Vista: `web/mis_pedidos.blade.php`
- Permisos: `pedido-view`, `pedido-cancel`

### [M-08] Facturación del Cliente
- Visualización y descarga de recibos y facturas electrónicas.
- Controlador: `PedidoController@recibosFactura`
- Vista: `web/recibos_factura.blade.php`

### [M-09] Perfil y Cuenta
- Edición de perfil personal.
- Controlador: `PerfilController@edit`
- Vista: `autenticacion/perfil.blade.php`
- Permiso: `perfil`

### [M-10] Catálogo Público
- Listado general de productos, filtros por categoría y catálogo.
- Controlador: `WebController`, `CategoriaController`, `CatalogoController`
- Vistas: `web/index.blade.php`, `web/categoria.blade.php`, `web/catalogo.blade.php`

### [M-11] Ficha de Producto
- Detalle completo del producto, reseñas de usuarios.
- Controlador: `WebController@show`
- Vista: detalle inline

### [M-12] Comercio — Carrito y Checkout
- Carrito de compras, formulario de pedido, carga de comprobante y facturación electrónica.
- Controlador: `CarritoController`, `PedidoController@formulario`
- Vistas: `web/pedido.blade.php`, `web/formulario_pedido.blade.php`

### [M-13] Páginas Informativas
- Página "Acerca de" y otras estáticas.
- Vista: `web/acerca.blade.php`

## 4. Modelos y Base de Datos

| Tabla             | Modelo           | Campos destacados                                                                 |
|-------------------|------------------|----------------------------------------------------------------------------------|
| users             | User             | name, email, password, activo                                                    |
| productos         | Producto         | codigo, nombre, precio, cantidad, artista_id, categoria_id, catalogo_id, formato_producto, lista_canciones (JSON) |
| pedidos           | Pedido           | user_id, total, estado, metodo_pago, comprobante_pago, requiere_factura_electronica, datos tributarios |
| pedido_detalles   | PedidoDetalle    | pedido_id, producto_id, cantidad, precio                                         |
| categorias        | Categoria        | nombre, descripcion                                                              |
| catalogos         | Catalogo         | nombre, descripcion                                                              |
| facturas          | Factura          | numero_factura, user_id, pedido_id, datos tributarios                            |
| inventario_movimientos | InventarioMovimiento | tipo, cantidad, stock_anterior, stock_nuevo, motivo, user_id, timestamps |
| producto_resenas  | ProductoResena   | producto_id, user_id, calificacion, comentario, timestamps                       |
| admin_activity_logs | AdminActivityLog | user_id, accion, detalles, timestamps                                            |

## 5. Rutas y Controladores

- Las rutas están organizadas en `routes/web.php` y `routes/console.php`.
- Se utilizan controladores RESTful para cada entidad principal.
- Ejemplo de rutas:
  - `/productos` → `ProductoController`
  - `/usuarios` → `UserController`
  - `/carrito` → `CarritoController`
  - `/perfil` → `PerfilController`

## 6. Middlewares y Seguridad

- `auth`: protege rutas privadas, redirige a `/login` si no autenticado.
- `admin.activity`: registra logs de actividad administrativa.
- CSRF: protección estándar de Laravel en formularios.

## 7. Formularios y Validaciones

- Se usan Form Requests para validación centralizada.
- Ejemplo: `ProductoRequest` valida unicidad de código, tipo de formato, imagen requerida, etc.

## 8. Vistas y Frontend

- Vistas Blade organizadas por módulo.
- Uso de Bootstrap 5, AdminLTE y TailwindCSS para estilos.
- Modo oscuro/claro persistente (localStorage, data-theme en `<html>`).

## 9. Ejemplo de Interacción

**Flujo de compra:**
1. Usuario navega el catálogo público.
2. Agrega productos al carrito.
3. Completa el formulario de pedido y adjunta comprobante de pago.
4. El pedido se registra y puede ser gestionado por el admin.
5. El usuario puede consultar el estado y descargar recibos.

## 10. Convenciones y Buenas Prácticas

- Migraciones: siempre ejecutar `php artisan migrate --seed`.
- Archivos subidos: en `public/uploads/`.
- Validaciones: siempre con Form Requests.
- Permisos en vistas: directivas Spatie (`@can`, `@canany`, `@role`).
- Modularidad y separación de capas.

---

**Nota:** Para detalles línea por línea de cada archivo, consulte la documentación interna de cada controlador, modelo y vista. Si requiere un análisis detallado de un archivo específico, indíquelo para generar la explicación correspondiente.