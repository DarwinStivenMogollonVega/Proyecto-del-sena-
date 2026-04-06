<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;

class ViewsSmokeTest extends TestCase
{
    /**
     * Recorrer rutas GET públicas y asegurar que devuelven un status < 400.
     * Se evitan rutas que requieren autenticación y rutas con parámetros.
     */
    public function test_public_get_routes_return_success()
    {
        $routes = collect(\Route::getRoutes())->filter(function ($route) {
            // Only GET/HEAD routes
            $methods = $route->methods();
            if (!in_array('GET', $methods) && !in_array('HEAD', $methods)) {
                return false;
            }

            $uri = $route->uri();

            // skip api routes and asset-ish and routes with params
            if (Str::startsWith($uri, 'api') || Str::contains($uri, '{')) {
                return false;
            }

            // Gather middleware and skip auth-protected routes
            $middleware = [];
            try {
                if (method_exists($route, 'gatherMiddleware')) {
                    $middleware = $route->gatherMiddleware();
                } elseif (isset($route->action['middleware'])) {
                    $middleware = (array) $route->action['middleware'];
                }
            } catch (\Throwable $e) {
                // ignore
            }

            foreach ($middleware as $m) {
                if (Str::contains($m, 'auth')) {
                    return false;
                }
            }

            return true;
        });

        $this->assertNotEmpty($routes, 'No se encontraron rutas públicas GET para probar.');

        foreach ($routes as $route) {
            $uri = '/' . ltrim($route->uri(), '/');
            // Some routes may be closures or need special env; wrap in try/catch
            try {
                $response = $this->get($uri);
                $status = $response->getStatusCode();
                $this->assertLessThan(400, $status, "Ruta $uri devolvió status $status");
            } catch (\Exception $e) {
                $this->fail("Error al solicitar $uri: " . $e->getMessage());
            }
        }
    }
}
