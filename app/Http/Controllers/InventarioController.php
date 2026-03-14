<?php

namespace App\Http\Controllers;

use App\Models\InventarioMovimiento;
use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('inventario-list') || auth()->user()->can('producto-list'), 403);

        $texto = trim((string) $request->input('texto'));

        $productos = Producto::with('artista')
            ->when($texto !== '', function ($q) use ($texto) {
                $q->where('nombre', 'like', "%{$texto}%")
                    ->orWhere('codigo', 'like', "%{$texto}%");
            })
            ->orderBy('cantidad')
            ->paginate(12);

        $movimientos = InventarioMovimiento::with(['producto', 'user'])
            ->latest('id')
            ->limit(15)
            ->get();

        $alertas = Producto::where('cantidad', '<=', 5)->orderBy('cantidad')->limit(8)->get();

        return view('inventario.index', compact('productos', 'movimientos', 'alertas', 'texto'));
    }

    public function moverStock(Request $request, $id)
    {
        abort_unless(auth()->user()->can('inventario-edit') || auth()->user()->can('producto-edit'), 403);

        $producto = Producto::findOrFail($id);

        $datos = $request->validate([
            'tipo' => ['required', 'in:entrada,salida,ajuste'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'motivo' => ['nullable', 'string', 'max:180'],
        ]);

        $anterior = (int) $producto->cantidad;
        $cantidad = (int) $datos['cantidad'];
        $nuevo = $anterior;

        if ($datos['tipo'] === 'entrada') {
            $nuevo = $anterior + $cantidad;
        } elseif ($datos['tipo'] === 'salida') {
            if ($cantidad > $anterior) {
                return redirect()->back()->with('mensaje', 'No puedes registrar una salida mayor al stock actual.');
            }
            $nuevo = $anterior - $cantidad;
        } elseif ($datos['tipo'] === 'ajuste') {
            $nuevo = $cantidad;
            $cantidad = abs($nuevo - $anterior);
        }

        $producto->cantidad = $nuevo;
        $producto->save();

        InventarioMovimiento::create([
            'producto_id' => $producto->id,
            'user_id' => auth()->id(),
            'tipo' => $datos['tipo'],
            'cantidad' => $cantidad,
            'stock_anterior' => $anterior,
            'stock_nuevo' => $nuevo,
            'motivo' => $datos['motivo'] ?? null,
        ]);

        return redirect()->route('inventario.index')->with('mensaje', 'Movimiento de inventario registrado.');
    }
}
