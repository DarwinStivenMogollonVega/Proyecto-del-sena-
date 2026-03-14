<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Catalogo;
use App\Models\Proveedor;
use App\Models\Artista;
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

        $registros = Producto::with(['categoria', 'catalogo', 'proveedor', 'artista'])
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
        $catalogos  = Catalogo::all();
        $proveedores = Proveedor::orderBy('nombre')->get();
        $artistas = Artista::orderBy('nombre')->get();
        return view('producto.action', compact('categorias','catalogos', 'proveedores', 'artistas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request)
    {
        $this->authorize('producto-create'); 

        $registro = new Producto();
        $registro->codigo       = $request->input('codigo');
        $registro->nombre       = $request->input('nombre');
        $registro->precio       = $request->input('precio');
        $registro->cantidad       = $request->input('cantidad');
        $registro->categoria_id = $request->input('categoria_id');
        $registro->catalogo_id  = $request->input('catalogo_id'); // <- agregado
        $registro->proveedor_id = $request->input('proveedor_id');
        $registro->artista_id  = $request->input('artista_id');
        $registro->anio_lanzamiento  = $request->input('anio_lanzamiento');
        $registro->descripcion  = $request->input('descripcion');
        $registro->lista_canciones  = $this->parseListaCanciones($request->input('lista_canciones'));

        $sufijo = strtolower(Str::random(2));
        $image = $request->file('imagen');
        if (!is_null($image)){            
            $nombreImagen = $sufijo.'-'.$image->getClientOriginalName();
            $image->move('uploads/productos', $nombreImagen);
            $registro->imagen = $nombreImagen;
        }

        $registro->save();

        InventarioMovimiento::create([
            'producto_id' => $registro->id,
            'user_id' => auth()->id(),
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
        $catalogos  = Catalogo::all(); // <- agregado
        $proveedores = Proveedor::orderBy('nombre')->get();
        $artistas = Artista::orderBy('nombre')->get();
        $registro   = Producto::findOrFail($id);
        return view('producto.action', compact('registro','categorias','catalogos', 'proveedores', 'artistas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, $id)
    {
        $this->authorize('producto-edit'); 

        $registro = Producto::findOrFail($id);
        $registro->codigo       = $request->input('codigo');
        $registro->nombre       = $request->input('nombre');
        $registro->precio       = $request->input('precio');
        $registro->cantidad       = $request->input('cantidad');
        $registro->categoria_id = $request->input('categoria_id');
        $registro->catalogo_id  = $request->input('catalogo_id'); // <- agregado
        $registro->proveedor_id = $request->input('proveedor_id');
        $registro->artista_id  = $request->input('artista_id');
        $registro->anio_lanzamiento  = $request->input('anio_lanzamiento');
        $registro->descripcion  = $request->input('descripcion');
        $registro->lista_canciones  = $this->parseListaCanciones($request->input('lista_canciones'));

        $stockAnterior = (int) $registro->getOriginal('cantidad');
        $stockNuevo = (int) $request->input('cantidad');

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
                'producto_id' => $registro->id,
                'user_id' => auth()->id(),
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
}
