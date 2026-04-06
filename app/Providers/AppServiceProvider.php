<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use App\Models\Categoria;
use App\Models\Formato;
use App\Observers\AnalyticsObserver;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Proveedor;
use App\Models\Catalogo as CatalogoModel;
use App\Models\Artista;
use App\Models\InventarioMovimiento;
use App\Models\ProductoResena;
use App\Models\AdminActivityLog;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔹 Usa Bootstrap para la paginación
        Paginator::useBootstrap();

        // Disponibles solo en vistas web para evitar consultas innecesarias en admin.
        View::composer('web.*', function ($view) {
            $categorias = Cache::remember('shared.web.categorias', now()->addMinutes(30), function () {
                if (Schema::hasTable('categorias')) {
                    return Categoria::select('id', 'nombre')->orderBy('nombre')->get();
                }

                return collect();
            });

            $formatos = Cache::remember('shared.web.formatos', now()->addMinutes(30), function () {
                if (Schema::hasTable('formatos')) {
                    return Formato::select('formato_id', 'nombre')->orderBy('nombre')->get();
                }
                // fallback to legacy catalogos table
                return CatalogoModel::select('catalogo_id as formato_id', 'nombre')->orderBy('nombre')->get();
            });

            $artistas = Cache::remember('shared.web.artistas', now()->addMinutes(30), function () {
                if (Schema::hasTable('artistas')) {
                    return Artista::select('artista_id', 'nombre')->orderBy('nombre')->get();
                }

                return collect();
            });

            $view->with('categorias', $categorias);
            // Provide both names for compatibility while migrating frontend/views.
            $view->with('formatos', $formatos);
            $view->with('catalogos', $formatos);
            $view->with('artistas', $artistas);
        });

        // Registrar observer que emite actualizaciones de estadísticas en tiempo real
        $observer = AnalyticsObserver::class;

        Producto::observe($observer);
        Pedido::observe($observer);
        PedidoDetalle::observe($observer);
        Proveedor::observe($observer);
        CatalogoModel::observe($observer);
        Artista::observe($observer);
        InventarioMovimiento::observe($observer);
        ProductoResena::observe($observer);
        AdminActivityLog::observe($observer);
        User::observe($observer);
    }
}
