<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo;
use App\Models\Formato;
use App\Http\Requests\CatalogoRequest;
use App\Models\Producto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Schema;

class CatalogoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Muestra una lista de catálogos.
     */
    public function index(Request $request)
    {
        $this->authorize('formato-list');

        $texto = $request->input('texto');
        // Use the model primary key name in case the table uses a different PK
        $pk = (Schema::hasTable('formatos') ? (new Formato())->getKeyName() : (new Catalogo())->getKeyName());
        $registros = (Schema::hasTable('formatos') ? Formato::where('nombre', 'like', "%{$texto}%") : Catalogo::where('nombre', 'like', "%{$texto}%"))
            ->orderBy($pk, 'desc')
            ->paginate(3);

        $productos = Producto::orderBy('nombre')->get();

        return view('catalogo.index', compact('registros', 'texto', 'productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo catálogo.
     */
    public function create()
    {
        $this->authorize('formato-create');
        return view('catalogo.action');
    }

    /**
     * Guarda un nuevo catálogo en la base de datos.
     */
    public function store(CatalogoRequest $request)
    {
        $this->authorize('formato-create');
        $validated = $request->validated();

        $registro = new Formato();
        $registro->nombre = $validated['nombre'];
        $registro->descripcion = $validated['descripcion'] ?? null;
        $registro->save();

        return redirect()->route('formato.index')
            ->with('mensaje', 'Registro "' . $registro->nombre . '" agregado correctamente.');
    }

    /**
     * Muestra el formulario para editar un catálogo existente.
     */
    public function edit($id)
    {
        $this->authorize('formato-edit');

        $registro = Formato::findOrFail($id);
        return view('catalogo.action', compact('registro'));
    }

    /**
     * Actualiza un catálogo existente.
     */
    public function update(CatalogoRequest $request, $id)
    {
        $this->authorize('formato-edit');
        $validated = $request->validated();

        $registro = Formato::findOrFail($id);
        $registro->nombre = $validated['nombre'];
        $registro->descripcion = $validated['descripcion'] ?? null;
        $registro->save();

        return redirect()->route('formato.index')
            ->with('mensaje', 'Registro "' . $registro->nombre . '" actualizado correctamente.');
    }

    /**
     * Elimina un catálogo.
     */
    public function destroy($id)
    {
        $this->authorize('formato-delete');

        $registro = Formato::findOrFail($id);
        $registro->delete();

        return redirect()->route('formato.index')
            ->with('mensaje', 'Registro "' . $registro->nombre . '" eliminado correctamente.');
    }

    /**
     * Muestra los productos asociados a un catálogo específico.
     */
    public function show($id)
    {
        $catalogo = Formato::findOrFail($id);

        $productosQuery = $catalogo->productos()->with(['categoria', 'formato']);

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

        return view('web.formato', ['formato' => $catalogo, 'productos' => $productos]);
    }

    /**
     * Vincular productos a un catálogo (recibe array de product_ids)
     */
    public function vincularProductos(Request $request, Catalogo $catalogo)
    {
        $this->authorize('formato-edit');

        $data = $request->validate([
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['integer', 'exists:productos,id'],
        ]);

        $selected = $data['product_ids'] ?? [];

        if (!empty($selected)) {
            Producto::whereIn('id', $selected)->update(['catalogo_id' => $catalogo->catalogo_id]);
        }

        Producto::where('catalogo_id', $catalogo->catalogo_id)
            ->whereNotIn('id', $selected ?: [0])
            ->update(['catalogo_id' => null]);

        return redirect()->route('formato.index')->with('success', 'Productos vinculados al formato');
    }
}
