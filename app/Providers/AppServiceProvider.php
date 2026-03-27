<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Categoria;
use App\Models\Catalogo;
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
                return Categoria::select('id', 'nombre')->orderBy('nombre')->get();
            });

            $catalogos = Cache::remember('shared.web.catalogos', now()->addMinutes(30), function () {
                // `catalogos` table uses `catalogo_id` as primary key; select the real PK
                return Catalogo::select('catalogo_id', 'nombre')->orderBy('nombre')->get();
            });

            $view->with('categorias', $categorias);
            $view->with('catalogos', $catalogos);
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
