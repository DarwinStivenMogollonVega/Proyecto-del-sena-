<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogo;
use App\Http\Requests\CatalogoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CatalogoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Muestra una lista de catálogos.
     */
    public function index(Request $request)
    {
        $this->authorize('catalogo-list');

        $texto = $request->input('texto');
        // Use the model primary key name in case the table uses a different PK (catalogo_id)
        $pk = (new Catalogo())->getKeyName();
        $registros = Catalogo::where('nombre', 'like', "%{$texto}%")
            ->orderBy($pk, 'desc')
            ->paginate(3);

        return view('catalogo.index', compact('registros', 'texto'));
    }

    /**
     * Muestra el formulario para crear un nuevo catálogo.
     */
    public function create()
    {
        $this->authorize('catalogo-create');
        return view('catalogo.action');
    }

    /**
     * Guarda un nuevo catálogo en la base de datos.
     */
    public function store(CatalogoRequest $request)
    {
        $this->authorize('catalogo-create');
        $validated = $request->validated();

        $registro = new Catalogo();
        $registro->nombre = $validated['nombre'];
        $registro->descripcion = $validated['descripcion'] ?? null;
        $registro->save();

        return redirect()->route('catalogo.index')
            ->with('mensaje', 'Registro "' . $registro->nombre . '" agregado correctamente.');
    }

    /**
     * Muestra el formulario para editar un catálogo existente.
     */
    public function edit($id)
    {
        $this->authorize('catalogo-edit');

        $registro = Catalogo::findOrFail($id);
        return view('catalogo.action', compact('registro'));
    }

    /**
     * Actualiza un catálogo existente.
     */
    public function update(CatalogoRequest $request, $id)
    {
        $this->authorize('catalogo-edit');
        $validated = $request->validated();

        $registro = Catalogo::findOrFail($id);
        $registro->nombre = $validated['nombre'];
        $registro->descripcion = $validated['descripcion'] ?? null;
        $registro->save();

        return redirect()->route('catalogo.index')
            ->with('mensaje', 'Registro "' . $registro->nombre . '" actualizado correctamente.');
    }

    /**
     * Elimina un catálogo.
     */
    public function destroy($id)
    {
        $this->authorize('catalogo-delete');

        $registro = Catalogo::findOrFail($id);
        $registro->delete();

        return redirect()->route('catalogo.index')
            ->with('mensaje', 'Registro "' . $registro->nombre . '" eliminado correctamente.');
    }

    /**
     * Muestra los productos asociados a un catálogo específico.
     */
    public function show($id)
    {
        $catalogo = Catalogo::findOrFail($id);

        $productosQuery = $catalogo->productos()->with(['categoria', 'catalogo']);

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

        return view('web.catalogo', compact('catalogo', 'productos'));
    }
}
