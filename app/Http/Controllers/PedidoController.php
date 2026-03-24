<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Factura;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    /**
     * Maneja el submit del formulario de datos y redirige al paso de entrega.
     */
    public function realizar(Request $request)
    {
        // Aquí puedes validar y guardar los datos si es necesario
        // Por ahora solo redirige al siguiente paso del checkout
        return redirect()->route('pedido.entrega');
    }
    // Paso 1: Formulario de datos personales
    public function datosForm(Request $request)
    {
        $carrito = collect(session()->get('carrito', []))
            ->filter(function ($item) {
                return (int) ($item['cantidad'] ?? 0) > 0;
            })
            ->all();

        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'No puedes acceder al formulario de datos sin artículos en el carrito.');
        }
        $datos = session('checkout.datos', []);
        return view('web.formulario_pedido', compact('carrito', 'datos'));
    }

    /**
     * Muestra la lista de pedidos para el panel de administración.
     */
    public function adminIndex()
    {
        $query = \App\Models\Pedido::query();
        if (request()->filled('buscar')) {
            $buscar = request('buscar');
            $query->where(function($q) use ($buscar) {
                $q->whereHas('user', function($u) use ($buscar) {
                    $u->where('name', 'like', "%$buscar%")
                      ->orWhere('email', 'like', "%$buscar%") ;
                })
                ->orWhere('email', 'like', "%$buscar%")
                ->orWhere('estado', 'like', "%$buscar%")
                ->orWhere('nombre', 'like', "%$buscar%") ;
            });
        }
        $pedidos = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        // Calcular métricas igual que en el index
        $metricas = [
            'totalProductos' => \App\Models\Producto::count(),
            'disponibles' => \App\Models\Producto::where('cantidad', '>', 0)->count(),
            'totalCategorias' => \App\Models\Categoria::count(),
            'totalCatalogos' => \App\Models\Catalogo::count(),
        ];
        // Puedes agregar más variables si la vista las requiere
        // Lógica de destacados igual que en el index público
        // No existe la columna 'ventas', así que ordenamos por 'created_at' (los más recientes)
        $masMasVendidos = \App\Models\Producto::with(['artista', 'categoria', 'catalogo'])
            ->withAvg('resenas', 'puntuacion')
            ->withCount('resenas')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $mejorValorados = \App\Models\Producto::with(['artista', 'categoria', 'catalogo'])
            ->withAvg('resenas', 'puntuacion')
            ->withCount('resenas')
            ->orderByDesc('resenas_avg_puntuacion')
            ->take(10)
            ->get();

        $ofertasEspeciales = \App\Models\Producto::with(['artista', 'categoria', 'catalogo'])
            ->withAvg('resenas', 'puntuacion')
            ->withCount('resenas')
            ->where('descuento', '>', 0)
            ->orderByDesc('descuento')
            ->take(10)
            ->get();

        $disponiblesAhora = \App\Models\Producto::with(['artista', 'categoria', 'catalogo'])
            ->withAvg('resenas', 'puntuacion')
            ->withCount('resenas')
            ->where('cantidad', '>', 0)
            ->orderByDesc('cantidad')
            ->take(10)
            ->get();

        $productos = \App\Models\Producto::paginate(20);
        $texto = request('texto', '');
        return view('pedido.index', compact(
            'pedidos', 'metricas',
            'masMasVendidos', 'mejorValorados', 'ofertasEspeciales', 'disponiblesAhora', 'productos', 'texto'
        ));
    }

    public function datosGuardar(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'telefono' => ['required', 'string', 'max:30'],
        ]);
        session(['checkout.datos' => $validated]);
        return redirect()->route('pedido.entrega');
    }

    // Paso 2: Formulario de entrega
    public function entregaForm(Request $request)
    {
        $carrito = collect(session()->get('carrito', []))
            ->filter(function ($item) {
                return (int) ($item['cantidad'] ?? 0) > 0;
            })
            ->all();

        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'No puedes acceder al formulario de entrega sin artículos en el carrito.');
        }

        $datos = session('checkout.datos', []);

                if (empty($carrito)) {
                    return redirect()->route('carrito.mostrar')->with('error', 'No puedes acceder al formulario de entrega sin artículos en el carrito.');
                }

                $datos = session('checkout.datos', []);
                if (empty($datos)) {
                    return redirect()->route('pedido.datos');
                }

                $entrega = session('checkout.entrega', []);
                return view('web.entrega_pedido', compact('carrito', 'datos', 'entrega'));
            }

            public function entregaGuardar(Request $request)
            {
                $validated = $request->validate([
                    'direccion' => ['required', 'string', 'max:255'],
                ]);
                session(['checkout.entrega' => $validated]);
                return redirect()->route('pedido.pago');
            }

            // Paso 3: Formulario de pago
            public function pagoForm(Request $request)
            {
                $carrito = collect(session()->get('carrito', []))
                    ->filter(function ($item) {
                        return (int) ($item['cantidad'] ?? 0) > 0;
                    })
                    ->all();

                if (empty($carrito)) {
                    return redirect()->route('carrito.mostrar')->with('error', 'No puedes acceder al formulario de pago sin artículos en el carrito.');
                }

                $datos = session('checkout.datos', []);
                $entrega = session('checkout.entrega', []);
                if (empty($datos) || empty($entrega)) {
                    return redirect()->route('pedido.datos');
                }

                $pago = session('checkout.pago', []);
                return view('web.pago_pedido', compact('carrito', 'datos', 'entrega', 'pago'));
            }

            public function pagoGuardar(Request $request)
            {
                $validated = $request->validate([
                    'metodo_pago' => ['required', 'string', 'max:30'],
                    'comprobante_pago' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                    'requiere_factura_electronica' => ['nullable', 'boolean'],
                    'tipo_documento' => ['required_if:requiere_factura_electronica,1', 'nullable', Rule::in(['nit', 'cedula'])],
                    'numero_documento' => ['required_if:requiere_factura_electronica,1', 'nullable', 'string', 'max:40'],
                    'razon_social' => ['required_if:requiere_factura_electronica,1', 'nullable', 'string', 'max:140'],
                    'correo_factura' => ['required_if:requiere_factura_electronica,1', 'nullable', 'email', 'max:120'],
                ]);

                $rutaComprobante = null;
                if ($request->hasFile('comprobante_pago')) {
                    $rutaComprobante = $request->file('comprobante_pago')->store('comprobantes', 'public');
                }
                $validated['comprobante_pago'] = $rutaComprobante;
                session(['checkout.pago' => $validated]);

                // Procesar el pedido completo
                $carrito = session()->get('carrito', []);
                $datos = session('checkout.datos', []);
                $entrega = session('checkout.entrega', []);
                $pago = session('checkout.pago', []);

                if (empty($carrito) || empty($datos) || empty($entrega) || empty($pago)) {
                    return redirect()->route('pedido.datos')->with('error', 'Faltan datos para completar el pedido.');
                }

                DB::beginTransaction();
                try {
                    $total = 0;
                    foreach ($carrito as $item) {
                        $total += $item['precio'] * $item['cantidad'];
                    }

                    $requiereFactura = $pago['requiere_factura_electronica'] ?? false;

                    $pedido = Pedido::create([
                        'user_id' => auth()->id(),
                        'total' => $total,
                        'estado' => 'pendiente',
                        'nombre' => $datos['nombre'],
                        'email' => $datos['email'],
                        'telefono' => $datos['telefono'],
                        'direccion' => $entrega['direccion'],
                        'metodo_pago' => $pago['metodo_pago'],
                        'comprobante_pago' => $pago['comprobante_pago'] ?? null,
                        'requiere_factura_electronica' => $requiereFactura,
                        'tipo_documento' => $requiereFactura ? ($pago['tipo_documento'] ?? null) : null,
                        'numero_documento' => $requiereFactura ? ($pago['numero_documento'] ?? null) : null,
                        'razon_social' => $requiereFactura ? ($pago['razon_social'] ?? null) : null,
                        'correo_factura' => $requiereFactura ? ($pago['correo_factura'] ?? null) : null,
                    ]);

                    $subtotal = 0;
                    $impuestos = 0;
                    foreach ($carrito as $productoId => $item) {
                        $productoExiste = Producto::whereKey($productoId)->exists();
                        if (!$productoExiste) {
                            throw new \RuntimeException('Uno de los productos del carrito ya no existe.');
                        }
                        PedidoDetalle::create([
                            'pedido_id' => $pedido->id,
                            'producto_id' => $productoId,
                            'cantidad' => $item['cantidad'],
                            'precio' => $item['precio'],
                        ]);
                        $subtotal += $item['precio'] * $item['cantidad'];
                        // Si tienes lógica de impuestos por producto, cámbiala aquí
                    }
                    // Suponiendo impuestos fijos del 19% (ajusta según tu lógica real)
                    $impuestos = round($subtotal * 0.19, 2);
                    $totalFactura = $subtotal + $impuestos;

                    // Generar número de factura (puedes mejorar la lógica)
                    $ultimoNumero = Factura::max('id') ?? 0;
                    $numeroFactura = 'F' . str_pad($ultimoNumero + 1, 6, '0', STR_PAD_LEFT);

                    Factura::create([
                        'pedido_id' => $pedido->id,
                        'user_id' => $pedido->user_id,
                        'numero_factura' => $numeroFactura,
                        'fecha_emision' => now(),
                        'estado_pedido' => $pedido->estado,
                        'subtotal' => $subtotal,
                        'impuestos' => $impuestos,
                        'total' => $totalFactura,
                        'cliente_nombre' => $pedido->nombre,
                        'cliente_email' => $pedido->email,
                        'cliente_direccion' => $pedido->direccion,
                        'cliente_identificacion' => $pedido->numero_documento ?? $pedido->email,
                    ]);

                    // Limpiar sesión de checkout y carrito
                    session()->forget(['carrito', 'checkout.datos', 'checkout.entrega', 'checkout.pago']);

                    DB::commit();
                    return redirect()->route('web.index')->with('success', 'Pedido confirmado con éxito.')->with('mensaje', 'Tu pedido #' . $pedido->id . ' fue guardado y ya aparece en la sección Mis pedidos.');
                } catch (\Throwable $e) {
                    DB::rollBack();
                    report($e);
                    $mensaje = app()->isLocal() ? 'No se pudo completar la compra: ' . $e->getMessage() : 'No se pudo completar la compra. Intenta nuevamente.';
                    return redirect()->back()->withInput()->with('error', $mensaje);
                }
            }
        }