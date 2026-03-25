# Requerimientos del Sistema (Extraídos desde el código)

## 1. Descripción General

DiscZone es una tienda digital que permite a los usuarios descubrir, comprar y dar seguimiento a discos de música en formato físico y digital. El sistema ofrece navegación por catálogo, carrito de compras, gestión de pedidos, perfil de usuario y panel administrativo para gestión interna.

---

## 2. Requerimientos Funcionales

### Descubrimiento y Navegación

**RF1:** El usuario debe poder explorar productos por categorías y catálogos.  
_Evidencia:_  
- routes/web.php: rutas `/categoria-web/{id}` y `/catalogo-web/{id}`  
- CatalogoController.php, CategoriaController.php: métodos `index`, `show`  
- views/web/acerca.blade.php: sección de descubrimiento musical

**RF2:** El usuario debe poder buscar y ordenar productos por nombre o código.  
_Evidencia:_  
- ProductoController.php: método `index` (filtro por nombre/código)

**RF3:** El usuario debe poder ver detalles completos de cada producto, incluyendo imágenes y descripciones.  
_Evidencia:_  
- WebController.php: método `show`  
- views/web/pedido.blade.php, views/web/acerca.blade.php

### Carrito y Proceso de Compra

**RF4:** El usuario debe poder agregar productos al carrito, modificar cantidades y eliminar productos antes de comprar.  
_Evidencia:_  
- CarritoController.php: métodos `agregar`, `sumar`, `restar`, `eliminar`, `vaciar`  
- views/web/pedido.blade.php

**RF5:** El usuario debe poder completar un formulario de compra con sus datos y confirmar el pedido.  
_Evidencia:_  
- PedidoController.php: métodos `datosForm`, `realizar`  
- views/web/formulario_pedido.blade.php

**RF6:** El usuario debe poder consultar el estado y el historial de sus pedidos.  
_Evidencia:_  
- PedidoController.php: métodos relacionados con pedidos del usuario  
- views/web/mis_pedidos.blade.php (no leído, pero referenciado en la documentación)

### Gestión de Usuario

**RF7:** El usuario debe poder registrarse, iniciar sesión y editar su perfil.  
_Evidencia:_  
- UserController.php: métodos `create`, `store`, `edit`, `update`  
- views/autenticacion/login.blade.php, views/autenticacion/registro.blade.php

**RF8:** El usuario debe poder ver y descargar recibos de compra.  
_Evidencia:_  
- PedidoController.php: métodos relacionados con facturación  
- views/web/recibos_factura.blade.php (referenciado)

### Funcionalidades Administrativas

**RF9:** El administrador debe poder gestionar productos, categorías, catálogos, artistas y usuarios (CRUD).  
_Evidencia:_  
- ProductoController.php, CategoriaController.php, CatalogoController.php, UserController.php: métodos CRUD  
- routes/web.php: rutas protegidas por middleware `auth`, `admin.activity`

**RF10:** El administrador debe poder gestionar pedidos y facturas, incluyendo facturación electrónica.  
_Evidencia:_  
- PedidoController.php, FacturaController.php: métodos de gestión  
- views/pedido/index.blade.php, views/factura/index.blade.php (referenciadas)

**RF11:** El administrador debe poder ver logs de actividad y gestionar roles y permisos.  
_Evidencia:_  
- SeguridadController.php, RoleController.php  
- routes/web.php: rutas de roles y logs

---

## 3. Requerimientos No Funcionales

**RNF1:** El sistema debe ser usable y responsivo en dispositivos móviles y escritorio.  
_Evidencia:_  
- views/web/acerca.blade.php: sección de adaptabilidad visual  
- Uso de Bootstrap, TailwindCSS

**RNF2:** El sistema debe proteger los datos mediante autenticación y autorización por roles/permisos.  
_Evidencia:_  
- Middleware `auth`, `admin.activity` en routes/web.php  
- Spatie Permissions en controladores

**RNF3:** El sistema debe permitir la gestión eficiente de grandes volúmenes de productos y pedidos (escalabilidad básica).  
_Evidencia:_  
- Uso de paginación en controladores (ej: ProductoController.php, CatalogoController.php)

**RNF4:** El sistema debe ofrecer retroalimentación visual y mensajes claros en las acciones del usuario.  
_Evidencia:_  
- views/web/pedido.blade.php, views/web/formulario_pedido.blade.php: mensajes de éxito/error

**RNF5:** El sistema debe mantener la integridad de los datos en operaciones de carrito y pedidos.  
_Evidencia:_  
- CarritoController.php: validaciones y control de cantidades

---

## 4. Evidencia en el Código

| Requerimiento | Archivo(s) / Ubicación |
|---------------|-----------------------|
| RF1, RF2, RF3 | routes/web.php, ProductoController.php, CatalogoController.php, CategoriaController.php, views/web/acerca.blade.php |
| RF4, RF5      | CarritoController.php, PedidoController.php, views/web/pedido.blade.php, views/web/formulario_pedido.blade.php |
| RF6           | PedidoController.php, views/web/mis_pedidos.blade.php |
| RF7           | UserController.php, views/autenticacion/login.blade.php, views/autenticacion/registro.blade.php |
| RF8           | PedidoController.php, views/web/recibos_factura.blade.php |
| RF9, RF10     | ProductoController.php, CategoriaController.php, CatalogoController.php, UserController.php, PedidoController.php, FacturaController.php, routes/web.php |
| RF11          | SeguridadController.php, RoleController.php, routes/web.php |
| RNF1          | views/web/acerca.blade.php, uso de Bootstrap/TailwindCSS |
| RNF2          | routes/web.php (middleware), controladores (Spatie Permissions) |
| RNF3          | Controladores (uso de paginación) |
| RNF4          | views/web/pedido.blade.php, views/web/formulario_pedido.blade.php |
| RNF5          | CarritoController.php |

---

## 5. Gaps y Recomendaciones

- **Gap 1:** No se evidencia un sistema de notificaciones (email/SMS) para confirmación de pedidos o cambios de estado.  
  _Recomendación:_ Implementar notificaciones automáticas para mejorar la experiencia del cliente.

- **Gap 2:** No se observa gestión avanzada de stock (alertas de bajo inventario para el cliente).  
  _Recomendación:_ Mostrar alertas de disponibilidad baja en la vista de producto.

- **Gap 3:** No se evidencia un historial detallado de acciones del usuario final (solo logs administrativos).  
  _Recomendación:_ Permitir al usuario ver un historial completo de sus acciones y descargas.

- **Gap 4:** No se observa integración con métodos de pago en línea (solo formulario de datos).  
  _Recomendación:_ Integrar pasarelas de pago para automatizar el proceso.

- **Gap 5:** No se evidencia gestión de devoluciones o cancelaciones por parte del cliente.  
  _Recomendación:_ Agregar flujo de cancelación/devolución desde el perfil del usuario.

---

_Todos los requerimientos aquí listados están respaldados por evidencia directa en el código fuente y las vistas. Las recomendaciones se basan en prácticas comunes de e-commerce y en la perspectiva del cliente._
