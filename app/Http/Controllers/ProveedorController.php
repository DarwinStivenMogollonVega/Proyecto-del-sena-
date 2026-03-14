<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('proveedor-list');

        $texto = trim((string) $request->input('texto'));

        $query = Proveedor::withCount('productos')->orderByDesc('id');

        if ($texto !== '') {
            $query->where(function ($q) use ($texto) {
                $q->where('nombre', 'like', "%{$texto}%")
                    ->orWhere('contacto', 'like', "%{$texto}%")
                    ->orWhere('email', 'like', "%{$texto}%")
                    ->orWhere('telefono', 'like', "%{$texto}%");
            });
        }

        $registros = $query->paginate(8);

        $resumen = [
            'total' => Proveedor::count(),
            'activos' => Proveedor::where('activo', true)->count(),
            'conProductos' => Proveedor::has('productos')->count(),
        ];

        return view('proveedor.index', compact('registros', 'texto', 'resumen'));
    }

    public function create()
    {
        $this->authorize('proveedor-create');

        return view('proveedor.action');
    }

    public function store(Request $request)
    {
        $this->authorize('proveedor-create');

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'contacto' => ['nullable', 'string', 'max:120'],
            'telefono' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:120'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $datos['activo'] = $request->boolean('activo', true);

        $registro = Proveedor::create($datos);

        return redirect()->route('proveedores.index')
            ->with('mensaje', 'Proveedor ' . $registro->nombre . ' agregado correctamente.');
    }

    public function edit(string $id)
    {
        $this->authorize('proveedor-edit');

        $registro = Proveedor::findOrFail($id);

        return view('proveedor.action', compact('registro'));
    }

    public function update(Request $request, string $id)
    {
        $this->authorize('proveedor-edit');

        $registro = Proveedor::findOrFail($id);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'contacto' => ['nullable', 'string', 'max:120'],
            'telefono' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:120'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $datos['activo'] = $request->boolean('activo');

        $registro->update($datos);

        return redirect()->route('proveedores.index')
            ->with('mensaje', 'Proveedor ' . $registro->nombre . ' actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $this->authorize('proveedor-delete');

        $registro = Proveedor::findOrFail($id);

        if ($registro->productos()->exists()) {
            return redirect()->route('proveedores.index')
                ->with('error', 'No se puede eliminar un proveedor que tiene productos asociados.');
        }

        $nombre = $registro->nombre;
        $registro->delete();

        return redirect()->route('proveedores.index')
            ->with('mensaje', 'Proveedor ' . $nombre . ' eliminado correctamente.');
    }
}
