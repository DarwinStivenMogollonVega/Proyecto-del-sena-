# Presentación técnica: Plataforma e‑commerce (Proyecto)

## Nota inicial
Este contenido está basado en la documentación y el código fuente del proyecto disponible en el repositorio. No he podido leer automáticamente el archivo adjunto `Documentacion_Discotienda.docx`; si quieres que integre su contenido textualmente, por favor súbelo al workspace o copia/pega los puntos clave.

---

## 1. Título y objetivo de la exposición

**Título:** Arquitectura y funcionamiento de la plataforma e‑commerce

**Objetivo:** explicar qué hace el sistema, cómo está construido y las decisiones técnicas clave que permiten su operación, mantenimiento y escalabilidad.

---

## 2. Agenda (2‑3 minutos por sección)

1. Contexto y propósito del sistema
2. Usabilidades / funcionalidades de negocio
3. Arquitectura general y capas
4. Métodos y flujos principales (técnico)
5. Metodologías, patrones y buenas prácticas aplicadas
6. Riesgos, limitaciones y recomendaciones
7. Preguntas y próximos pasos

---

## 3. Contexto y propósito (30–60s)

- Plataforma e‑commerce para gestión y venta de productos (música, catálogos, artistas).
- Usuarios: administradores (gestión), clientes (compra) y actores intermedios (proveedores, artistas).
- Propósito: permitir catálogo público, carrito, proceso de compra multi‑paso, administración de inventario, pedidos y facturación, con métricas para el negocio.

---

## 4. Usabilidades (funcionalidades, lenguaje de negocio)

- Registro y autenticación de usuarios; edición de perfil.
- Búsqueda y filtrado de catálogo; vista de producto con reseñas y calificaciones.
- Wishlist (lista de deseados) en sesión.
- Carrito de compras: agregar, actualizar cantidades, eliminar, vaciar.
- Checkout multi‑paso: datos personales → entrega → pago → creación de pedido y factura.
- Gestión administrativa: CRUD (usuarios, roles, productos, categorías, catálogos, artistas, proveedores).
- Control de inventario: movimientos (entradas, ajustes).
- Facturación: generar facturas desde pedidos y exportar PDF.
- Dashboard analítico: KPIs, métricas por categoría, exportes a PDF/Excel.

---

## 5. Arquitectura general y estructura del código (1‑2 min)

- Stack: Laravel (PHP) — arquitectura MVC.
- Capas principales:
  - Rutas: `routes/web.php` (públicas y protegidas).
  - Controladores: acciones HTTP (`app/Http/Controllers`).
  - Requests: validaciones (`app/Http/Requests`).
  - Modelos: Eloquent ORM (`app/Models`).
  - Vistas: Blade (`resources/views`).
  - Servicios: lógica de negocio compleja fuera de controladores (`app/Services`).
- Observers y eventos para tareas reactivas (`app/Observers`).

---

## 6. Métodos y flujos principales (técnico, 3–5 min)

A continuación se describen los flujos críticos y los métodos que los implementan.

### 6.1 Login
- Punto de entrada: `POST /login` → `AuthController::login(LoginRequest)`
- Validación: `LoginRequest` verifica existencia de correo y formato de contraseña.
- Lógica: `Auth::attempt` + comprobación de `activo` en `User`.
- Resultado: redirección a la ruta intencionada o mensaje de error.

### 6.2 Registro
- `RegisterController::registrar` procesa `POST /registro`.
- Crea `User`, asigna rol por defecto; validaciones centralizadas en `RegisterController`/`RegisterRequest` (según implementación).

### 6.3 CRUD productos (admin)
- Rutas REST: `Route::resource('productos', ProductoController::class)`
- Validación: `ProductoRequest` (reglas para `codigo`, `precio`, `cantidad`, relaciones y subida de imagen).
- `store` / `update`: manejo de imagen en `uploads/productos`, `parseListaCanciones()` y registro de `InventarioMovimiento` en creación/ajuste.
- `destroy`: borra imagen y registro de producto.

### 6.4 Checkout multi‑paso
- Estado temporal en sesión: `checkout.datos`, `checkout.entrega`, `checkout.pago`.
- Controladores y validaciones: `PedidoController::datosForm/datosGuardar`, `entregaForm/entregaGuardar`, `pagoForm/pagoGuardar` con Requests dedicados (`PedidoDatosRequest`, `PedidoEntregaRequest`, `PedidoPagoRequest`).
- `pagoGuardar` (punto crítico): valida, guarda comprobante si existe, y en transacción DB crea: `Pedido`, `PedidoDetalle` por cada item, y `Factura`. Al éxito, limpia sesión.

### 6.5 Facturación y PDF
- `FacturaController::crearFacturaDesdePedido` (transaccional): calcula subtotal, impuestos, crea `Factura` y asigna `numero_factura`.
- `pdf($id)`: genera PDF con `barryvdh/laravel-dompdf`.

### 6.6 Dashboard y métricas
- Servicio: `AdminAnalyticsService` — agrupa lógica para calcular KPIs, tablas y tarjetas por categoría/proveedor.
- Uso de `Cache::remember` para resultados pesados; `AnalyticsObserver` emite `StatisticsUpdated` al guardar/eliminar modelos.

---

## 7. Metodologías, patrones y buenas prácticas (2–3 min)

- MVC: separación clara entre presentación, lógica de aplicación y acceso a datos.
- Service Layer: `AdminAnalyticsService` elimina lógica pesada de controladores.
- Observers/Eventing: desacopla actualización de métricas y notificaciones.
- Form Requests: centralizan validación (evitan duplicación y mantienen controladores limpios).
- Transacciones DB en procesos críticos (pedido + factura) para mantener integridad.
- Caching en capas analíticas para rendimiento.
- Permisos y roles (Spatie) para control de acceso.
- Manejo de archivos: restricciones en Requests (tipo, tamaño) para seguridad.

¿Por qué estas prácticas?
- Incrementan mantenibilidad, testabilidad y seguridad; reducen duplicación; permiten escalar componentes analíticos sin impactar endpoints de usuario.

---

## 8. Riesgos y recomendaciones (1–2 min)

- Riesgo: invalidación de cache cuando se actualizan datos (revisar claves y flush cuando sea necesario).
- Riesgo: validación y sanitización de archivos subidos; revisar permisos de filesystem y virus scanning en producción.
- Recomendaciones:
  - Añadir tests automatizados (unitarios e integrados) para checkout y facturación.
  - Añadir monitoreo/alertas en transacciones fallidas.
  - Revisar límites y políticas de paginación y exportes para datasets grandes.

---

## 9. Cierre y preguntas (30–60s)

- Recapitulación: sistema preparado para comercio online con módulos administrativos y analíticos; buenas prácticas aplicadas en arquitectura y seguridad; puntos a reforzar: testing, cache invalidation y hardening de subida de archivos.
- Próximos pasos sugeridos: pruebas end‑to‑end del checkout, cobertura automatizada, y plan de despliegue con backups y monitoreo.

---

## Apéndice (soporte para la exposición)

- Si quieres, genero diapositivas (markdown → reveal.js) con estas secciones.
- También puedo generar notas del orador por diapositiva y ejemplos de payloads para demos en vivo.

---

## Sección específica por páginas / vistas (detalle para la demo)

1) Página Principal (Home)
  - Qué muestra: secciones "Más vendidos", "Mejor valorados", "Ofertas especiales" y "Disponibles ahora".
  - Fuente de datos: `Producto::withCount('resenas')->withAvg('resenas','puntuacion')` y paginación para listado general.
  - Punto de demostración: búsqueda por texto y ordenamiento (`priceAsc`, `priceDesc`).

2) Página de Producto (Detalle)
  - Qué muestra: información del producto, imagen, lista de canciones (si aplica), reseñas con promedio y posibilidad de agregar/editar reseña (usuarios autenticados).
  - Métodos clave: `WebController::show($id)` y `WebController::guardarResena(Request,$id)`.
  - Punto de demostración: añadir una reseña y mostrar actualización del promedio.

3) Página de Categoría
  - Qué muestra: productos filtrados por categoría con búsqueda y ordenamiento, paginación de 9 ítems.
  - Método: `CategoriaController::show($id)`.
  - Punto de demostración: filtrar por precio y mostrar paginación.

4) Carrito y Checkout (flujo completo)
  - Carrito: operaciones `agregar`, `sumar`, `restar`, `eliminar`, `vaciar` en sesión (`CarritoController`).
  - Checkout multi‑paso: `datos` → `entrega` → `pago` (Requests dedicados y validaciones). Punto crítico: `PedidoController::pagoGuardar` crea `Pedido`, `PedidoDetalle` y `Factura` en transacción.
  - Punto de demostración: agregar 2 productos, completar pasos y mostrar PDF de factura.

5) Panel Admin (CRUD y Dashboard)
  - CRUD: `ProductoController`, `CategoriaController`, `ArtistaController`, `UserController` con permisos (Spatie) y `AuthorizesRequests`.
  - Dashboard: `AdminAnalyticsService::dashboardData()` muestra KPIs; `categoriasVentasCards()` produce tarjetas por categoría; observer `AnalyticsObserver` emite eventos.
  - Punto de demostración: crear un producto, ajustar stock y mostrar movimiento en `InventarioMovimiento`.

6) Facturación y Exportes
  - Generación: `FacturaController::crearFacturaDesdePedido(Pedido)` y `pdf($id)` para descargar PDF con `barryvdh/laravel-dompdf`.
  - Exportes: estadísticas pueden exportarse a PDF/Excel (rutas en `EstadisticaController`).

## Notas del orador (por sección)

- Inicio (Contexto): 30s — explicar objetivo del sistema y usuarios.
- Usabilidades: 60s — listar funcionalidades clave en lenguaje de negocio.
- Arquitectura: 60s — explicar MVC, Services y Observers, y por qué se eligieron.
- Demo técnica (páginas específicas): 4–6 min — seguir el orden Home → Producto → Carrito → Checkout → Admin.
- Metodologías y buenas prácticas: 60s — enfatizar transacciones, Requests, cache y separación de responsabilidades.
- Riesgos y recomendaciones: 30s — testing, cache invalidation, seguridad de uploads.
- Cierre: 30s — próximos pasos propuestos.

## Duración sugerida: 12–15 minutos (explicación + demo mínimo)

---

Archivo guardado: `EXPOSICION_PROYECTO.md` (en la raíz del proyecto).

Si quieres, puedo:
- Generar slides (reveal.js) a partir de estas secciones.
- Preparar notas del orador en formato por-diapositiva.
- Exportar este MD a PDF listo para imprimir.


