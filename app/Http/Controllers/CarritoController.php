<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function agregar(Request $request){
        $producto = Producto::findOrFail($request->producto_id);
        $cantidad = $request->cantidad ?? 1;

        $carrito = session()->get('carrito', []);
        if (isset($carrito[$producto->getKey()])) {
            // Ya existe en el carrito, solo aumenta la cantidad
            $carrito[$producto->getKey()]['cantidad'] += $cantidad;
        } else {
            // No existe, lo agregamos
            $carrito[$producto->getKey()] = [
                'codigo' => $producto->codigo,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'descuento' => $producto->descuento ?? 0,
                'imagen' => $producto->imagen,
                'cantidad' => $cantidad,
            ];
        }
        session()->put('carrito', $carrito);
        // Si la petición espera JSON (AJAX), devolvemos el total de items
        $items = collect($carrito)->sum(fn($it) => (int) ($it['cantidad'] ?? 0));
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['items' => $items]);
        }

        return redirect()->back()->with('mensaje', 'Producto agregado al carrito');
    }

    public function mostrar(){
        $carrito =session('carrito', []);
        return view('web.pedido', compact('carrito'));
    }

    public function sumar(Request $request){
        $productoId = $request->producto_id;

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$productoId])) {
            $carrito[$productoId]['cantidad'] += 1;
            session()->put('carrito', $carrito);
        }

        return redirect()->back()->with('mensaje', 'Cantidad actualizada en el carrito');
    }

    public function restar(Request $request){
        $productoId = $request->producto_id;

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$productoId])) {
            if ($carrito[$productoId]['cantidad'] > 1) {
                // Resta 1 si la cantidad es mayor a 1
                $carrito[$productoId]['cantidad'] -= 1;
            } 
            else{
                // Si es 1, lo quitamos del carrito
                unset($carrito[$productoId]);
            }
            session()->put('carrito', $carrito);
        }

        return redirect()->back()->with('mensaje', 'Cantidad actualizada en el carrito');
    }
    public function eliminar($id){
        $carrito = session()->get('carrito');
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }
        return redirect()->back()->with('success', 'Producto eliminado');
    }
    public function vaciar(){
        session()->forget('carrito');
        return redirect()->back()->with('success', 'Carrito vaciado');
    }
}
