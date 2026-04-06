# Pruebas Selenium - Instrucciones

Pasos para ejecutar las pruebas Selenium creadas en `SeleniumGeneralTest.php`.

1) Instalar la dependencia PHP WebDriver (en el entorno del proyecto):

```bash
composer require --dev php-webdriver/webdriver
```

2) Levantar un servidor Selenium con Chrome. Ejemplo usando Docker:

```bash
# usa Docker Desktop o WSL; mapea el puerto 4444
docker run -d --rm -p 4444:4444 -v /dev/shm:/dev/shm --name selenium-chrome selenium/standalone-chrome:latest
```

En Windows, si no dispone de `/dev/shm`, Docker lo maneja internamente; use Docker Desktop.

3) Variables de entorno recomendadas (opcional):

```bash
export APP_URL=http://localhost
export SELENIUM_HOST=http://localhost:4444/wd/hub
```

4) Ejecutar las pruebas específicas (ruta relativa desde la raíz del proyecto):

```bash
./vendor/bin/phpunit tests/Browser/SeleniumGeneralTest.php
```

Notas:
- Las pruebas son generales y ligeras: comprueban que las páginas devuelven contenido y que hay enlaces.
- Ajuste las rutas dentro del archivo de prueba si su aplicación usa URIs diferentes (por ejemplo `/catalogo`).
- Para entornos CI, arranque un servicio Selenium (por ejemplo con docker-compose) y configure `SELENIUM_HOST`.
