# DOCUMENTACIÓN DEL PROYECTO

## 1. INFORMACIÓN GENERAL
- **Nombre del proyecto:** Proyecto-del-sena (copia local)
- **Versión actual:** No especificada en composer.json (usar semántica: 1.0.0)
- **Fecha de inicio:** 2025-03-22 (fecha de migración detectada)
- **Estado del proyecto:** En desarrollo
- **Repositorio de GitHub (URL):** [Completar]
- **Licencia:** MIT
- **Descripción corta:** Tienda en línea basada en Laravel para gestión de catálogo, pedidos y facturación.
- **Descripción larga:** Aplicación web monolítica construida con Laravel 12 y Vite que permite administrar productos, categorías, inventario, proveedores, pedidos y facturación. Incluye panel administrativo con roles y permisos, un catálogo público, carrito de compras y generación de facturas en PDF.
- **Usuarios objetivo:** Administradores del sitio, vendedores/gestores de inventario y clientes finales (usuarios registrados)
- **Página web o demo:** [Completar]
## 2. TECNOLOGÍAS USADAS
- **Lenguaje(s) de programación:** PHP (^8.2), JavaScript, CSS
- **Framework(s) principal(es):** Laravel (v12), Vite
- **Base de datos:** Soporta SQLite por defecto y MySQL/MariaDB/Postgres (configurable via `.env`)
- **ORM o query builder:** Eloquent (Laravel)
- **Autenticación:** Sesiones (Laravel auth, controladores de autenticación personalizados)
- **Frontend:** Blade templates, Vite, Tailwind CSS (dependencias en `package.json`)
- **Backend:** Laravel (PHP)
- **Servicios en la nube:** [Completar]
- **Otras librerías o dependencias importantes:** barryvdh/laravel-dompdf, fakerphp/faker, phpunit/phpunit, spatie/laravel-permission, maatwebsite/excel
- **Herramientas de testing:** PHPUnit (`php artisan test`, `vendor/bin/phpunit`)
- **CI/CD:** No hay pipeline explícito en el repo (ningún workflow detectable)
- **Servicios en la nube:** [Completar]
## 3. ARQUITECTURA
- **Tipo de arquitectura:** MVC (Modelo-Vista-Controlador), Monolítica
- **Diagrama de arquitectura:** [Describir o pegar link]
- **Comunicación interna:** HTTP (controladores y vistas; posibles endpoints API internas)
- **¿Tiene caché?:** Soporta Redis (configuración en `config/database.php`), pero no se detecta configuración obligatoria en el repositorio; configurable vía `.env`.
- **¿Tiene cola de mensajes?:** La aplicación puede usar colas de Laravel (dev script invoca `php artisan queue:listen`), por tanto está preparada para colas; configuración concreta depende de `.env`.
- **¿Tiene CDN o almacenamiento de archivos?:** Usa almacenamiento local y carpeta `public/uploads` para archivos cargados; puede configurarse S3/u otros en `config/filesystems.php`.
## 3. ARQUITECTURA
- **Comunicación interna:** HTTP (REST)
- **¿Tiene caché?:** [Completar]
- **¿Tiene cola de mensajes?:** [Completar]
- **¿Tiene CDN o almacenamiento de archivos?:** [Completar]

---

 - **Requisitos previos:** PHP 8.2+, Composer, Node.js (compatible con Vite), SQLite or MySQL
## 4. ESTRUCTURA DE CARPETAS

```
/
  artisan
  composer.json
  package.json
  phpunit.xml
  README.md
  app/
    Exports/
    Http/
      Controllers/
      Middleware/
      Requests/
    Models/
    Providers/
  database/
    factories/
    migrations/
    seeders/
  lang/
  public/
    index.php
    assets/
    css/
    js/
    uploads/
## 6. BASE DE DATOS
- **Motor de base de datos:** Por defecto `sqlite` (según `config/database.php`), compatible con `mysql`, `mariadb`, `pgsql`, `sqlsrv` configurable vía `.env`
- **Nombre de la base de datos:** Por defecto `database/database.sqlite` cuando se usa sqlite; para MySQL `DB_DATABASE` por `.env` (ej. `laravel`)
- **Tablas principales:**
  - users: usuarios del sistema
  - productos: catálogo de productos
  - pedidos: pedidos realizados
  - pedido_detalles: detalles de cada pedido
  - categorias: categorías de productos
  - facturas: facturación
  - inventario_movimientos: movimientos de inventario
  - proveedores: proveedores registrados
  - producto_resenas: reseñas de productos
  - admin_activity_log: registro de actividades administrativas
  - [Agregar otras según migraciones]
- **¿Hay migraciones? ¿Cómo se corren?:** Sí, con `php artisan migrate --seed`
- **¿Hay seeders o datos de prueba? ¿Cómo se cargan?:** Sí, con `php artisan db:seed` o `php artisan migrate --seed`
- **Diagrama entidad-relación:** [Describir o pegar link]
    views/
## 7. ENDPOINTS DE LA API
La mayoría de las rutas se definen en `routes/web.php` e incluyen rutas públicas (página principal, catálogo, producto, carrito) y rutas protegidas para la administración (`usuarios`, `productos`, `categoria`, `catalogo`, `artistas`, `pedidos`, `facturas`, etc.).

Ejemplos principales:
- `GET /` -> `WebController@index` (página principal)
- `GET /producto/{id}` -> `WebController@show` (detalle de producto)
- Carrito: `/carrito`, `/carrito/agregar`, `/carrito/eliminar` etc.
- Rutas protegidas (middleware `auth`): recursos `productos`, `usuarios`, `categoria`, `catalogo`, `artistas`, `proveedores`, flujos de pedido y facturación.

Para lista completa ver `routes/web.php`.
    console.php
  selenium-tests/
  storage/
  tests/
  vendor/

---

## 5. INSTALACIÓN Y CONFIGURACIÓN
## 8. FUNCIONALIDADES PRINCIPALES
- **Gestión de productos:** CRUD completo de productos (nombre, precio, categoría, imagen, artista). Acceso: administradores.
- **Catálogo público y búsqueda:** Visualización de productos por categoría y catálogos, vista pública para clientes.
- **Carrito de compras:** Añadir/quitar/actualizar ítems en sesión, proceso de checkout multi-paso (datos, entrega, pago).
- **Gestión de pedidos:** Flujo multi-paso para crear pedidos; panel admin para cambiar estado, ver y exportar pedidos.
- **Facturación / Recibos:** Generación de facturas en PDF y descarga (integración con DomPDF), gestión desde panel administrativo.
- **Inventario:** Movimientos de stock y ajustes desde panel administrativo.
- **Usuarios y roles:** Gestión de usuarios, roles y permisos (Spatie Permission).

Flujos resumidos (ejemplo — pedido):
1. Usuario añade productos al carrito.
2. Completa datos y dirección en `/pedido/datos` y `/pedido/entrega`.
3. Confirma pago en `/pedido/pago` y procesa `POST /pedido/realizar`.
4. Administrador gestiona estados desde panel `/admin/pedidos`.
- **Pasos para clonar e instalar:**
  3. Ejecutar `npm install`
  4. Copiar `.env.example` a `.env` y configurar variables
  5. Ejecutar `php artisan key:generate`
## 9. ROLES Y PERMISOS
- **¿El sistema tiene roles de usuario?:** Sí (implementado con `spatie/laravel-permission`)
- **Lista de roles (ejemplo):**
  - Admin: Acceso total al sistema
  - Usuario: Acceso a funcionalidades de compra y consulta
  - Invitado: Acceso limitado (solo visualización pública)
  6. Ejecutar migraciones y seeders: `php artisan migrate --seed`
## 11. TESTING
- **¿Tiene tests?:** Sí (hay estructura `tests/`)
- **Tipos de tests:** Unitarios y de integración (según estructura)
- **Comando para correr los tests:** `php artisan test` o `vendor/bin/phpunit`
- **Cobertura de tests:** [Completar]
- **¿Tiene tests automáticos en CI/CD?:** No detectado en el repo
  - DB_CONNECTION= (tipo de base de datos)
## 13. INTEGRACIONES EXTERNAS
- **DomPDF:** para generación de PDF (facturas)
- **Maatwebsite/Excel:** exportación a Excel (estadísticas, informes)
- **Spatie Permission:** gestión de roles y permisos
- **FakerPHP:** datos de prueba en seeders
  - DB_USERNAME= (usuario)
## 14. SEGURIDAD
- **¿Cómo se manejan las contraseñas?:** Hashing seguro usando el mecanismo por defecto de Laravel (bcrypt/argon según configuración)
- **¿Cómo funciona la autenticación?:** Autenticación basada en sesiones con controladores personalizados (`AuthController`, `RegisterController`, `ResetPasswordController`).
- **¿Hay rate limiting?:** No se detecta configuración explícita en rutas; puede añadirse usando middleware `throttle`.
- **¿Hay validación de inputs?:** Sí, mediante Form Requests en `app/Http/Requests` y validaciones en controladores.
- **¿Hay protección contra CORS, XSS, CSRF?:** Laravel incluye CSRF y protección XSS en Blade; CORS es configurable.
- **¿Los datos sensibles están encriptados?:** Variables sensibles deben residir en `.env`; no se detecta uso adicional de cifrado por defecto salvo el cifrado de Laravel para datos encriptados.
- **Cómo correr con Docker (si aplica):** [Completar]

---

## 6. BASE DE DATOS
- **Motor de base de datos:** [MySQL, PostgreSQL, etc.]
- **Nombre de la base de datos:** [Completar]
- **Tablas principales:**
  - users: usuarios del sistema
  - productos: catálogo de productos
  - pedidos: pedidos realizados
  - pedido_detalles: detalles de cada pedido
  - categorias: categorías de productos
  - facturas: facturación
  - inventario_movimientos: movimientos de inventario
  - proveedores: proveedores registrados
  - producto_resenas: reseñas de productos
  - admin_activity_log: registro de actividades administrativas
  - [Agregar otras según migraciones]
- **¿Hay migraciones? ¿Cómo se corren?:** Sí, con `php artisan migrate --seed`
- **¿Hay seeders o datos de prueba? ¿Cómo se cargan?:** Sí, con `php artisan db:seed` o `php artisan migrate --seed`
- **Diagrama entidad-relación:** [Describir o pegar link]

---

## 7. ENDPOINTS DE LA API
[Completar con los endpoints definidos en routes/web.php y/o api.php]

---

## 8. FUNCIONALIDADES PRINCIPALES
- **Funcionalidad 1:**
  - Nombre: Gestión de productos
  - Descripción: Permite crear, editar, eliminar y listar productos
  - ¿Quién puede usarla?: Administradores
  - Flujo paso a paso: [Completar]
- **Funcionalidad 2:**
  - Nombre: Gestión de pedidos
  - Descripción: Permite a los usuarios realizar pedidos y a los administradores gestionarlos
  - ¿Quién puede usarla?: Usuarios y administradores
  - Flujo paso a paso: [Completar]
- [Agregar más funcionalidades según el sistema]

---

## 9. ROLES Y PERMISOS
- **¿El sistema tiene roles de usuario?:** Sí
- **Lista de roles:**
  - Admin: Acceso total al sistema
  - Usuario: Acceso a funcionalidades de compra y consulta
  - Invitado: Acceso limitado (por ejemplo, solo visualización)

---

## 10. FLUJOS IMPORTANTES
- **Flujo de registro / login:** [Describir]
- **Flujo de gestión de productos:** [Describir]
- **Flujo de pago:** [Describir si aplica]
- **Flujo de recuperación de contraseña:** [Describir si aplica]
- **Otros flujos importantes:** [Completar]

---

## 11. TESTING
- **¿Tiene tests?:** Sí
- **Tipos de tests:** Unitarios, integración
- **Comando para correr los tests:** `php artisan test` o `vendor/bin/phpunit`
- **Cobertura de tests:** [Completar]
- **¿Tiene tests automáticos en CI/CD?:** [Completar]

---

## 12. DEPLOYMENT / DESPLIEGUE
- **¿Dónde está desplegado?:** [Completar]
- **Pasos para hacer deploy:**
  1. [Completar]
  2. [Completar]
  3. [Completar]
- **Variables de entorno en producción:** [Listar]
- **¿Usa Docker en producción? ¿Cómo?:** [Completar]
- **¿Tiene dominio propio?:** [Completar]
- **¿Hay entornos separados?:** [dev, staging, prod]
## 12. DEPLOYMENT / DESPLIEGUE
- **¿Dónde está desplegado?:** [Completar]
- **Pasos para hacer deploy (resumen genérico):**
  1. Configurar servidor (Ubuntu, Nginx/Apache) o plataforma PaaS (Heroku, Forge, DigitalOcean App Platform).
  2. Clonar repo en el servidor o usar CI para desplegar artefactos.
  3. Instalar dependencias: `composer install --no-dev --optimize-autoloader`, `npm ci` y `npm run build`.
  4. Configurar `.env` con variables de producción y ejecutar `php artisan key:generate` si es necesario.
  5. Ejecutar migraciones en producción: `php artisan migrate --force` y cargar seeders si es necesario.
  6. Configurar tareas programadas y colas (supervisor/systemd) si se utilizan.
- **Variables de entorno en producción:** `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY`, `DB_*`, `MAIL_*`, `FILESYSTEM_DISK`, `QUEUE_CONNECTION`, `REDIS_*`, etc.
- **¿Usa Docker en producción? ¿Cómo?:** No hay configuración Docker detectada en el repo; puede añadirse con un `Dockerfile` y `docker-compose` según necesidades.
- **¿Tiene dominio propio?:** [Completar]
- **¿Hay entornos separados?:** Puede tener entornos `local`, `staging`, `production` configurables vía `.env`.

---

## 13. INTEGRACIONES EXTERNAS
- Servicio 1: [Completar]
- Servicio 2: [Completar]
- Servicio 3: [Completar]

---

## 14. SEGURIDAD
- **¿Cómo se manejan las contraseñas?:** Hashing seguro (bcrypt por defecto en Laravel)
- **¿Cómo funciona la autenticación?:** [Completar]
- **¿Hay rate limiting?:** [Completar]
- **¿Hay validación de inputs?:** Sí, mediante Requests y validaciones de Laravel
- **¿Hay protección contra CORS, XSS, CSRF?:** Sí, protección CSRF y XSS por Laravel, CORS configurable
- **¿Los datos sensibles están encriptados?:** [Completar]

---

## 15. GUÍA DE CONTRIBUCIÓN
- **¿Acepta contribuciones externas?:** [Sí / No]
- **¿Cómo reportar un bug?:** [Completar]
- **¿Cómo proponer una nueva funcionalidad?:** [Completar]
- **Convención de nombres de ramas:** [main, develop, feature/xxx]
- **Convención de commits:** [Conventional Commits, etc.]
- **¿Se requiere hacer PR? ¿Quién aprueba?:** [Completar]
## 15. GUÍA DE CONTRIBUCIÓN
- **¿Acepta contribuciones externas?:** [Completar]
- **¿Cómo reportar un bug?:** Abrir un issue en el repositorio con pasos para reproducir, logs y entorno.
- **¿Cómo proponer una nueva funcionalidad?:** Crear un issue de tipo `feature` con descripción y casos de uso; seguir luego con un branch `feature/descripcion` y un PR.
- **Convención de nombres de ramas:** `main`, `develop`, `feature/xxx`, `fix/xxx`
- **Convención de commits:** Recomendado usar Conventional Commits (feat, fix, chore, docs, etc.)
- **¿Se requiere hacer PR? ¿Quién aprueba?:** Sí, hacer PR; aprobaciones por responsables del proyecto (no especificado).

---

## 16. HISTORIAL Y VERSIONES
- **Versión actual:** [Completar]
- **Cambios más importantes de versiones anteriores:** [Completar]
- **Próximas funcionalidades planeadas (roadmap):** [Completar]

---

## 17. EQUIPO
- **Autor / Autores principales:** [Completar]
- **Organización o empresa:** [Completar]
- **Contacto o email de soporte:** [Completar]
- **Links relevantes:** [Completar]
## 17. EQUIPO
- **Autor / Autores principales:** [Completar]
- **Organización o empresa:** [Completar]
- **Contacto o email de soporte:** [Completar]
- **Links relevantes:** [Completar]

---

## 18. CAPTURAS DE PANTALLA O DIAGRAMAS
[Describir o pegar links a imágenes, diagramas, etc.]

---

## 19. PREGUNTAS FRECUENTES (FAQ)
- Pregunta 1: / Respuesta:
- Pregunta 2: / Respuesta:

---

## 20. NOTAS ADICIONALES
[Agregar cualquier otra información relevante]
