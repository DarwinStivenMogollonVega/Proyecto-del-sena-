<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Requests\CategoriaRequest;
use App\Models\Producto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoriaController extends Controller
{
    use AuthorizesRequests;

    /**
     * Muestra una lista de categorías.
     */
    public function index(Request $request)
    {
        $this->authorize('categoria-list'); 

        $texto = $request->input('texto');
        $registros = Categoria::where('nombre', 'like', "%{$texto}%")
            ->orderBy('id', 'desc')
            ->paginate(3);

        $productos = Producto::orderBy('nombre')->get();

        return view('categoria.index', compact('registros', 'texto', 'productos'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create()
    {
        $this->authorize('categoria-create'); 
        return view('categoria.action');
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     */
    public function store(CategoriaRequest $request)
    {
        $this->authorize('categoria-create'); 
        $validated = $request->validated();

        $registro = new Categoria();
        $registro->nombre = $validated['name'];
        $registro->descripcion = $validated['description'] ?? null;
        $registro->save();
          
        return redirect()->route('categoria.index')
            ->with('mensaje', 'Registro ' . $registro->nombre . ' agregado correctamente');
    }

    /**
     * Muestra el formulario para editar una categoría existente.
     */
    public function edit($id)
    {
        $this->authorize('categoria-edit');

        $registro = Categoria::findOrFail($id);
        return view('categoria.action', compact('registro'));
    }

    /**
     * Actualiza una categoría existente.
     */
    public function update(CategoriaRequest $request, $id)
    {
        $this->authorize('categoria-edit');
        $validated = $request->validated();

        $registro = Categoria::findOrFail($id);
        $registro->nombre = $validated['name'];
        $registro->descripcion = $validated['description'] ?? null;
        $registro->save();

        return redirect()->route('categoria.index')
            ->with('mensaje', 'Registro ' . $registro->nombre . ' actualizado correctamente');
    }

    /**
     * Elimina una categoría.
     */
    public function destroy($id)
    {
        $this->authorize('categoria-delete');

        $registro = Categoria::findOrFail($id);
        $registro->delete();

        return redirect()->route('categoria.index')
            ->with('mensaje', 'Registro ' . $registro->nombre . ' eliminado correctamente');
    }

    /**
     * Muestra los productos asociados a una categoría específica.
     */
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);

        $productosQuery = $categoria->productos()->with(['categoria', 'catalogo']);

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

        $productos = $productosQuery
            ->orderBy('id', 'desc')
            ->paginate(9)
            ->appends(request()->query());

        return view('web.categoria', compact('categoria', 'productos'));
    }

    /**
     * Vincular productos a una categoría (recibe array de product_ids)
     */
    public function vincularProductos(Request $request, Categoria $categoria)
    {
        $this->authorize('categoria-edit');

        $data = $request->validate([
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer', 'exists:productos,id'],
        ]);

        $selected = $data['product_ids'] ?? [];

        if (!empty($selected)) {
            Producto::whereIn('id', $selected)->update(['categoria_id' => $categoria->getKey()]);
        }

        Producto::where('categoria_id', $categoria->getKey())
            ->whereNotIn('id', $selected ?: [0])
            ->update(['categoria_id' => null]);

        return redirect()->route('categoria.index')->with('success', 'Productos vinculados a la categoría');
    }

    /**
     * Adjuntar un solo producto a la categoría (AJAX)
     */
    public function attachProducto(Request $request, Categoria $categoria)
    {
        $this->authorize('categoria-edit');

        $data = $request->validate([
            'product_id' => ['required','integer','exists:productos,id']
        ]);

        $producto = Producto::findOrFail($data['product_id']);
        $producto->categoria_id = $categoria->getKey();
        $producto->save();

        return response()->json(['success' => true, 'producto' => $producto]);
    }

    /**
     * Desvincular (quitar) un producto de la categoría (AJAX)
     */
    public function detachProducto(Categoria $categoria, Producto $producto)
    {
        $this->authorize('categoria-edit');

        if ($producto->categoria_id == $categoria->getKey()) {
            $producto->categoria_id = null;
            $producto->save();
        }

        return response()->json(['success' => true]);
    }
}
