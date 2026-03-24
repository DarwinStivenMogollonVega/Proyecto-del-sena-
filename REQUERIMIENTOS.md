# Requerimientos del Proyecto

Este proyecto está basado en Laravel y utiliza tecnologías modernas para el desarrollo web. A continuación se listan los requerimientos principales para instalar y ejecutar el proyecto correctamente.

## Requisitos del sistema
- **PHP**: ^8.2
- **Node.js**: Recomendado v18+ (para Vite y Tailwind)
- **Composer**: Última versión
- **NPM**: Última versión
- **Extensiones PHP**: openssl, pdo, mbstring, tokenizer, xml, ctype, json, bcmath, fileinfo
- **Base de datos**: MySQL, MariaDB, SQLite o compatible

## Dependencias de PHP (Composer)
- laravel/framework ^12.0
- barryvdh/laravel-dompdf ^3.1
- maatwebsite/excel ^3.1
- spatie/laravel-permission ^6.16
- laravel/tinker ^2.10.1

### Dependencias de desarrollo (Composer)
- fakerphp/faker ^1.23
- laravel/pail ^1.2.2
- laravel/pint ^1.13
- laravel/sail ^1.41
- mockery/mockery ^1.6
- nunomaduro/collision ^8.6
- phpunit/phpunit ^11.5.3

## Dependencias de Node.js (NPM)
- vite ^6.0.11
- tailwindcss ^4.0.0
- @tailwindcss/vite ^4.0.0
- axios ^1.7.4
- concurrently ^9.0.1
- laravel-vite-plugin ^1.2.0

## Instalación
1. Clona el repositorio y accede a la carpeta del proyecto.
2. Copia el archivo `.env.example` a `.env` y configura tus variables de entorno.
3. Instala las dependencias de PHP:
   ```bash
   composer install
   ```
4. Instala las dependencias de Node.js:
   ```bash
   npm install
   ```
5. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```
6. Ejecuta las migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```
7. Inicia el servidor de desarrollo y Vite:
   ```bash
   npm run dev
   php artisan serve
   ```

## Scripts útiles
- `npm run dev`: Compila los assets en modo desarrollo con Vite y Tailwind.
- `npm run build`: Compila los assets para producción.
- `composer dev`: Levanta servidor Laravel, escucha colas y ejecuta Vite en paralelo.

## Notas adicionales
- El proyecto utiliza Vite y TailwindCSS para el frontend.
- Incluye soporte para generación de PDFs y exportación a Excel.
- El sistema de permisos está basado en Spatie Laravel Permission.
- Para pruebas, usa PHPUnit (`vendor/bin/phpunit`).

---

Para más detalles, consulta la documentación oficial de Laravel y los archivos `composer.json` y `package.json` incluidos en el proyecto.
