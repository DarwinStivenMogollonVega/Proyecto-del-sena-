<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Formato;
use App\Models\Proveedor;
use App\Models\Artista;
use App\Models\Album;
use App\Models\InventarioMovimiento;
use App\Http\Requests\ProductoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('producto-list'); 
        $texto = $request->input('texto');

        $registros = Producto::with(['categoria', 'catalogo', 'formato', 'proveedor', 'artista'])
            ->where('nombre', 'like', "%{$texto}%")
            ->orWhere('codigo', 'like', "%{$texto}%")
            ->orderBy('id', 'desc')
            ->paginate(3);

        return view('producto.index', compact('registros','texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('producto-create'); 
        $categorias = Categoria::all();
        $formatos  = Formato::all();
        $proveedores = Proveedor::orderBy('nombre')->get();
        $artistas = Artista::orderBy('nombre')->get();
        $albums = Album::orderBy('nombre')->get();
        return view('producto.action', compact('categorias','formatos', 'proveedores', 'artistas', 'albums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request)
    {
        $this->authorize('producto-create'); 
        $validated = $request->validated();

        $registro = new Producto();
        $registro->codigo = $validated['codigo'];
        $registro->nombre = $validated['nombre'];
        $registro->precio = $validated['precio'];
        $registro->descuento = $validated['descuento'] ?? 0;
        $registro->cantidad = $validated['cantidad'];
        $registro->categoria_id = $validated['categoria_id'];
        // support both new `formato_id` and legacy `catalogo_id` from payload
        $registro->catalogo_id = $validated['catalogo_id'] ?? null;
        $registro->formato_id = $validated['formato_id'] ?? ($validated['catalogo_id'] ?? null);
        $registro->proveedor_id = $validated['proveedor_id'] ?? null;
        $registro->artista_id = $validated['artista_id'] ?? null;
        $registro->anio_lanzamiento = $validated['anio_lanzamiento'] ?? null;
        $registro->descripcion = $validated['descripcion'] ?? null;
        $registro->lista_canciones = $this->parseListaCanciones($validated['lista_canciones'] ?? null);
        $registro->album_id = $validated['album_id'] ?? null;

        $sufijo = strtolower(Str::random(2));
        $image = $request->file('imagen');
        if (!is_null($image)){            
            $nombreImagen = $sufijo.'-'.$image->getClientOriginalName();
            $image->move('uploads/productos', $nombreImagen);
            $registro->imagen = $nombreImagen;
        }

        $registro->save();

        InventarioMovimiento::create([
            'producto_id' => $registro->getKey(),
            'usuario_id' => auth()->id(),
            'tipo' => 'entrada',
            'cantidad' => (int) $registro->cantidad,
            'stock_anterior' => 0,
            'stock_nuevo' => (int) $registro->cantidad,
            'motivo' => 'Stock inicial al crear producto',
        ]);

        return redirect()->route('productos.index')->with('mensaje', 'Registro '.$registro->nombre. ' agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('producto-edit'); 
        $categorias = Categoria::all();
        $formatos  = Formato::all(); // <- agregado
        $proveedores = Proveedor::orderBy('nombre')->get();
        $artistas = Artista::orderBy('nombre')->get();
        $albums = Album::orderBy('nombre')->get();
        $registro   = Producto::findOrFail($id);
        return view('producto.action', compact('registro','categorias','formatos', 'proveedores', 'artistas', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, $id)
    {
        $this->authorize('producto-edit'); 
        $validated = $request->validated();

        $registro = Producto::findOrFail($id);
        $registro->codigo = $validated['codigo'];
        $registro->nombre = $validated['nombre'];
        $registro->precio = $validated['precio'];
        $registro->descuento = $validated['descuento'] ?? 0;
        $registro->cantidad = $validated['cantidad'];
        $registro->categoria_id = $validated['categoria_id'];
        // support both new `formato_id` and legacy `catalogo_id` from payload
        $registro->catalogo_id = $validated['catalogo_id'] ?? null;
        $registro->formato_id = $validated['formato_id'] ?? ($validated['catalogo_id'] ?? null);
        $registro->proveedor_id = $validated['proveedor_id'] ?? null;
        $registro->artista_id = $validated['artista_id'] ?? null;
        $registro->anio_lanzamiento = $validated['anio_lanzamiento'] ?? null;
        $registro->descripcion = $validated['descripcion'] ?? null;
        $registro->lista_canciones = $this->parseListaCanciones($validated['lista_canciones'] ?? null);
        $registro->album_id = $validated['album_id'] ?? null;

        $stockAnterior = (int) $registro->getOriginal('cantidad');
        $stockNuevo = (int) $validated['cantidad'];

        $sufijo = strtolower(Str::random(2));
        $image = $request->file('imagen');
        if (!is_null($image)){            
            $nombreImagen = $sufijo.'-'.$image->getClientOriginalName();
            $image->move('uploads/productos', $nombreImagen);

            $old_image = 'uploads/productos/'.$registro->imagen;
            if (file_exists($old_image)) {
                @unlink($old_image);
            }

            $registro->imagen = $nombreImagen;
        }

        $registro->save();

        if ($stockAnterior !== $stockNuevo) {
            InventarioMovimiento::create([
                'producto_id' => $registro->getKey(),
                'usuario_id' => auth()->id(),
                'tipo' => 'ajuste',
                'cantidad' => abs($stockNuevo - $stockAnterior),
                'stock_anterior' => $stockAnterior,
                'stock_nuevo' => $stockNuevo,
                'motivo' => 'Ajuste desde modulo de productos',
            ]);
        }

        return redirect()->route('productos.index')->with('mensaje', 'Registro '.$registro->nombre. ' actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('producto-delete');
        $registro = Producto::findOrFail($id);

        $old_image = 'uploads/productos/'.$registro->imagen;
        if (file_exists($old_image)) {
            @unlink($old_image);
        }

        $registro->delete();
        return redirect()->route('productos.index')->with('mensaje', $registro->nombre. ' eliminado correctamente.');
    }

    private function parseListaCanciones(?string $input): ?array
    {
        if (empty($input)) {
            return null;
        }

        $lineas = preg_split('/\r\n|\r|\n/', $input);
        $canciones = collect($lineas)
            ->map(fn ($item) => trim((string) $item))
            ->filter(fn ($item) => $item !== '')
            ->values()
            ->all();

        return empty($canciones) ? null : $canciones;
    }

    /**
     * Search products (AJAX) for real-time linking in admin modals
     */
    public function search(Request $request)
    {
        $q = $request->query('q', '');
        $productos = Producto::where('nombre', 'like', "%{$q}%")
            ->orderBy('nombre')
            ->limit(20)
            ->get(['id', 'nombre', 'categoria_id']);

        return response()->json($productos);
    }
}
