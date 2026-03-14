<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\ProductoResena;
use App\Models\Categoria;
use App\Models\Catalogo;

class WebController extends Controller
{
    public function index(Request $request){
        $searchTerm = $request->has('search') && $request->search ? $request->search : null;

        $masMasVendidos = Producto::with(['categoria', 'catalogo', 'resenas'])
            ->when($searchTerm, fn($q) => $q->where('nombre', 'like', '%' . $searchTerm . '%'))
            ->withCount('resenas')
            ->orderBy('resenas_count', 'desc')
            ->limit(6)
            ->get();

        $mejorValorados = Producto::with(['categoria', 'catalogo', 'resenas'])
            ->withAvg('resenas', 'puntuacion')
            ->when($searchTerm, fn($q) => $q->where('nombre', 'like', '%' . $searchTerm . '%'))
            ->orderByDesc('resenas_avg_puntuacion')
            ->limit(6)
            ->get()
            ->map(function ($producto) {
                $producto->promedio_calificacion = (float) ($producto->resenas_avg_puntuacion ?? 0);
                return $producto;
            })
            ->filter(fn($p) => $p->promedio_calificacion > 0)
            ->values();

        $ofertasEspeciales = Producto::with(['categoria', 'catalogo', 'resenas'])
            ->when($searchTerm, fn($q) => $q->where('nombre', 'like', '%' . $searchTerm . '%'))
            ->orderBy('precio', 'asc')
            ->limit(6)
            ->get();

        $disponiblesAhora = Producto::with(['categoria', 'catalogo', 'resenas'])
            ->when($searchTerm, fn($q) => $q->where('nombre', 'like', '%' . $searchTerm . '%'))
            ->where('cantidad', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->limit(6)
            ->get();

        $query = Producto::with(['categoria', 'catalogo']);
        if ($searchTerm) {
            $query->where('nombre', 'like', '%' . $searchTerm . '%');
        }
        if ($request->has('sort') && $request->sort) {
            switch ($request->sort) {
                case 'priceAsc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'priceDesc':
                    $query->orderBy('precio', 'desc');
                    break;
                default:
                    $query->orderBy('nombre', 'asc');
                    break;
            }
        }
        $productos = $query->paginate(10);

        $metricas = [
            'totalProductos' => Producto::count(),
            'totalCategorias' => Categoria::count(),
            'totalCatalogos' => Catalogo::count(),
            'disponibles' => Producto::where('cantidad', '>', 0)->count(),
        ];

        return view('web.index', compact(
            'masMasVendidos',
            'mejorValorados',
            'ofertasEspeciales',
            'disponiblesAhora',
            'productos',
            'metricas'
        ));

    }

    public function show($id){
        $producto = Producto::with([
            'categoria',
            'catalogo',
            'resenas' => function ($query) {
                $query->with('user')->latest();
            },
        ])->findOrFail($id);

        $promedio = (float) $producto->resenas()->avg('puntuacion');
        $totalResenas = $producto->resenas()->count();
        $miResena = auth()->check()
            ? $producto->resenas->firstWhere('user_id', auth()->id())
            : null;

        return view('web.item', compact('producto', 'promedio', 'totalResenas', 'miResena'));
    }

    public function guardarResena(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $datos = $request->validate([
            'puntuacion' => ['required', 'integer', 'between:1,5'],
            'comentario' => ['nullable', 'string', 'max:600'],
        ]);

        ProductoResena::updateOrCreate(
            [
                'producto_id' => $producto->id,
                'user_id' => auth()->id(),
            ],
            [
                'puntuacion' => $datos['puntuacion'],
                'comentario' => $datos['comentario'] ?? null,
            ]
        );

        return redirect()
            ->route('web.show', $producto->id)
            ->with('mensaje', 'Gracias, tu calificacion fue registrada.');
    }
}
