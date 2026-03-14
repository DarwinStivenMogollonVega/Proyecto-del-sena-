<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Categoria;
use App\Models\Catalogo;

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
                return Catalogo::select('id', 'nombre')->orderBy('nombre')->get();
            });

            $view->with('categorias', $categorias);
            $view->with('catalogos', $catalogos);
        });
    }
}
