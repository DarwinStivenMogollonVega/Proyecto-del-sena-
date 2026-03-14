<?php

namespace App\Http\Middleware;

use App\Models\AdminActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminActivityLogger
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $routeName = (string) ($request->route()?->getName() ?? '');

        if (auth()->check() && $this->shouldLog($request, $routeName)) {
            AdminActivityLog::create([
                'user_id' => auth()->id(),
                'method' => $request->method(),
                'route_name' => $routeName,
                'url' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
            ]);
        }

        return $response;
    }

    private function shouldLog(Request $request, string $routeName): bool
    {
        if (str_starts_with($request->path(), 'admin')) {
            return true;
        }

        if ($routeName === '') {
            return false;
        }

        $prefixes = [
            'dashboard',
            'estadisticas.',
            'usuarios.',
            'roles.',
            'productos.',
            'proveedores.',
            'categoria.',
            'catalogo.',
            'artistas.',
            'inventario.',
            'pedidos.cambiar.estado',
        ];

        foreach ($prefixes as $prefix) {
            if ($routeName === $prefix || str_starts_with($routeName, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
