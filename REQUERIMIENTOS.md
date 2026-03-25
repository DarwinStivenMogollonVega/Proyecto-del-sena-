# Requerimientos del Proyecto

Este proyecto está basado en Laravel y utiliza tecnologías modernas para el desarrollo web. A continuación se listan los requerimientos principales para instalar y ejecutar el proyecto correctamente.

## Requisitos del sistema

# Requerimientos del Sistema

## Requerimientos Funcionales

**RF1. Navegación y Descubrimiento**
- El usuario puede navegar por categorías y catálogos para encontrar discos según estilo, colección o preferencia personal.
- El sistema permite búsqueda y ordenamiento de productos por precio.
- Sección de "Deseados" para guardar productos de interés.
- Visualización de productos destacados y novedades en la página de inicio.

**RF2. Proceso de Compra**
- El usuario puede agregar productos al carrito, modificar cantidades y eliminar productos antes de finalizar la compra.
- Flujo de compra guiado: agregar al carrito, completar datos de entrega, seleccionar método de pago y confirmar pedido.
- El usuario puede consultar el historial de sus compras y ver el estado de sus pedidos.

**RF3. Gestión de Usuario**
- Registro, inicio de sesión y edición de perfil de usuario.
- Gestión de datos personales y cambio de contraseña.
- Visualización y descarga de recibos de compra.

**RF4. Panel de Soporte y Ayuda**
- Sección de soporte con guía de uso para cada funcionalidad principal de la tienda.
- Explicación clara de cada sección: Inicio, Acerca, Deseados, Catálogo, Categorías, Carrito, Mis pedidos, Mi perfil.

**RF5. Administración (solo para usuarios autorizados)**
- Panel de control para gestión de productos, categorías, catálogos y pedidos.
- Sistema de permisos basado en roles.
- Gestión de clientes y análisis de actividad.
- Gestión de inventario y movimientos de stock.
- Visualización de logs de actividad administrativa.

**RF6. Facturación Electrónica**
- Soporte para facturación electrónica en pedidos y descarga de comprobantes.

**RF7. Reseñas de Productos**
- Los usuarios pueden dejar reseñas y calificaciones en productos adquiridos.

## Requerimientos No Funcionales

**RNF1. Usabilidad**
- Interfaz moderna, clara y responsiva, adaptada a dispositivos móviles y de escritorio.
- Experiencia de usuario optimizada: navegación intuitiva, retroalimentación visual en acciones importantes.
- Guía de uso accesible desde el menú principal.

**RNF2. Rendimiento**
- Carga rápida de páginas y recursos gracias a Vite y TailwindCSS.
- Optimización de imágenes y assets para mejorar tiempos de respuesta.

**RNF3. Seguridad**
- Autenticación y autorización de usuarios.
- Protección de datos personales y de transacciones.
- Uso de roles y permisos para restringir el acceso a funciones administrativas.

**RNF4. Mantenibilidad y Escalabilidad**
- Código estructurado en base a buenas prácticas de Laravel.
- Uso de migraciones y seeders para gestión de base de datos.
- Modularidad en componentes y vistas.

**RNF5. Compatibilidad**
- Soporte para los principales navegadores modernos.
- Funcionalidad garantizada en modo claro y oscuro.

**RNF6. Documentación y Soporte**
- Documentación de instalación y uso en REQUERIMIENTOS.md y README.md.
- Sección de soporte accesible para usuarios finales.

---

**Nota:** Estos requerimientos han sido extraídos y sintetizados a partir de los archivos de vistas, guías de usuario y documentación del proyecto. Para detalles técnicos, consulta los archivos `composer.json`, `package.json` y la documentación oficial de Laravel.
- El proyecto utiliza Vite y TailwindCSS para el frontend.
- Incluye soporte para generación de PDFs y exportación a Excel.
- El sistema de permisos está basado en Spatie Laravel Permission.
- Para pruebas, usa PHPUnit (`vendor/bin/phpunit`).

---

Para más detalles, consulta la documentación oficial de Laravel y los archivos `composer.json` y `package.json` incluidos en el proyecto.
