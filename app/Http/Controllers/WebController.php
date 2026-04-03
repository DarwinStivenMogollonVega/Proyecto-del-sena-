<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\ProductoResena;
use App\Models\Categoria;
use App\Models\Formato;
use App\Models\Artista;

class WebController extends Controller
{
    public function index(Request $request){
        $searchTerm = $request->has('search') && $request->search ? $request->search : null;

        $masMasVendidos = Producto::with(['categoria', 'catalogo', 'artista'])
            ->when($searchTerm, fn($q) => $q->where('nombre', 'like', '%' . $searchTerm . '%'))
            ->withCount('resenas')
            ->withAvg('resenas', 'puntuacion')
            ->orderBy('resenas_count', 'desc')
            ->limit(6)
            ->get();

        $mejorValorados = Producto::with(['categoria', 'catalogo', 'artista'])
            ->withCount('resenas')
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

        $ofertasEspeciales = Producto::with(['categoria', 'catalogo', 'artista'])
            ->when($searchTerm, fn($q) => $q->where('nombre', 'like', '%' . $searchTerm . '%'))
            ->withCount('resenas')
            ->withAvg('resenas', 'puntuacion')
            ->orderBy('precio', 'asc')
            ->limit(6)
            ->get();

        $disponiblesAhora = Producto::with(['categoria', 'catalogo', 'artista'])
            ->when($searchTerm, fn($q) => $q->where('nombre', 'like', '%' . $searchTerm . '%'))
            ->withCount('resenas')
            ->withAvg('resenas', 'puntuacion')
            ->where('cantidad', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->limit(6)
            ->get();

        $query = Producto::with(['categoria', 'catalogo', 'artista'])
            ->withCount('resenas')
            ->withAvg('resenas', 'puntuacion');
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

        $metricasProductos = Producto::selectRaw('COUNT(*) as total_productos, SUM(CASE WHEN cantidad > 0 THEN 1 ELSE 0 END) as disponibles')->first();

        $metricas = [
            'totalProductos' => (int) ($metricasProductos->total_productos ?? 0),
            'totalCategorias' => Categoria::count(),
            'totalCatalogos' => Formato::count(),
            'disponibles' => (int) ($metricasProductos->disponibles ?? 0),
        ];

        // Nuevos conjuntos para carruseles adicionales
        $nuevosLanzamientos = Producto::with(['categoria', 'catalogo', 'artista'])
            ->whereNotNull('created_at')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $economicos = Producto::with(['categoria', 'catalogo', 'artista'])
            ->orderBy('precio', 'asc')
            ->limit(8)
            ->get();

        return view('web.index', compact(
            'masMasVendidos',
            'mejorValorados',
            'ofertasEspeciales',
            'disponiblesAhora',
            'productos',
            'metricas',
            'nuevosLanzamientos',
            'economicos'
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

        $promedio = (float) ($producto->resenas->avg('puntuacion') ?? 0);
        $totalResenas = (int) $producto->resenas->count();
        $miResena = auth()->check()
            ? $producto->resenas->firstWhere('usuario_id', auth()->id())
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

        ProductoResena::updateOrCreate([
                'producto_id' => $producto->getKey(),
                'usuario_id' => auth()->id(),
            ],
            [
                'puntuacion' => $datos['puntuacion'],
                'comentario' => $datos['comentario'] ?? null,
            ]
        );

        return redirect()
            ->route('web.show', $producto->getKey())
            ->with('mensaje', 'Gracias, tu calificacion fue registrada.');
    }

    /**
     * Página pública: listado completo de productos
     */
    public function productos(Request $request)
    {
        $search = $request->has('search') && $request->search ? $request->search : null;

        $query = Producto::with(['categoria', 'catalogo', 'artista'])
            ->withCount('resenas')
            ->withAvg('resenas', 'puntuacion');

        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
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
                    $query->orderBy('id', 'desc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $productos = $query->paginate(40)->appends(request()->query());

        $metricasProductos = Producto::selectRaw('COUNT(*) as total_productos, SUM(CASE WHEN cantidad > 0 THEN 1 ELSE 0 END) as disponibles')->first();

        $metricas = [
            'totalProductos' => (int) ($metricasProductos->total_productos ?? 0),
            'totalCategorias' => Categoria::count(),
            'totalCatalogos' => Formato::count(),
            'disponibles' => (int) ($metricasProductos->disponibles ?? 0),
        ];

        return view('web.productos', compact('productos', 'metricas'));
    }

    /**
     * Muestra los productos de un artista (vista pública)
     */
    public function artistaShow($id)
    {
        $artista = Artista::findOrFail($id);

        $productosQuery = $artista->productos()->with(['categoria', 'catalogo', 'artista']);

        if ($search = request('search')) {
            $productosQuery->where('nombre', 'like', '%' . $search . '%');
        }

        if ($sort = request('sort')) {
            if ($sort === 'priceAsc') {
                $productosQuery->orderBy('precio', 'asc');
            } elseif ($sort === 'priceDesc') {
                $productosQuery->orderBy('precio', 'desc');
            }
        }

        $productos = $productosQuery->orderBy('id', 'desc')->paginate(9)->appends(request()->query());

        return view('web.artista', compact('artista', 'productos'));
            ;
    }
}
