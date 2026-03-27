<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Factura;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    /**
     * Maneja el submit del formulario de datos y redirige al paso de entrega.
     */
    public function realizar(\App\Http\Requests\PedidoRealizarRequest $request)
    {
        // Si el formulario incluye el método de pago, procesamos el pedido
        if ($request->filled('metodo_pago')) {
            $validated = $request->validated();

            $carrito = session()->get('carrito', []);
            if (empty($carrito)) {
                return redirect()->route('carrito.mostrar')->with('error', 'No puedes realizar un pedido sin artículos en el carrito.');
            }

            // Procesar el pedido (similar a pagoGuardar)
            DB::beginTransaction();
            try {
                $total = 0;
                foreach ($carrito as $item) {
                    $total += $item['precio'] * $item['cantidad'];
                }

                $requiereFactura = $request->boolean('requiere_factura_electronica', false);

                $comprobantePath = null;
                if ($request->hasFile('comprobante_pago')) {
                    try {
                        $comprobantePath = Storage::disk('public')->putFile('comprobantes', $request->file('comprobante_pago'));
                    } catch (\Throwable $e) {
                        Log::warning('No se pudo guardar comprobante en realizar: ' . $e->getMessage());
                        $comprobantePath = null;
                    }
                }

                $pedido = Pedido::create([
                    'usuario_id' => auth()->id(),
                    'total' => $total,
                    'estado' => 'pendiente',
                    'nombre' => $validated['nombre'],
                    'email' => $validated['email'],
                    'telefono' => $validated['telefono'],
                    'direccion' => $validated['direccion'],
                    'metodo_pago' => $validated['metodo_pago'],
                    'comprobante_pago' => $comprobantePath,
                    'requiere_factura_electronica' => $requiereFactura,
                    'tipo_documento' => $requiereFactura ? $request->input('tipo_documento') : null,
                    'numero_documento' => $requiereFactura ? $request->input('numero_documento') : null,
                    'razon_social' => $requiereFactura ? $request->input('razon_social') : null,
                    'correo_factura' => $requiereFactura ? $request->input('correo_factura') : null,
                ]);

                $subtotal = 0;
                foreach ($carrito as $productoId => $item) {
                    $productoExiste = Producto::whereKey($productoId)->exists();
                    if (!$productoExiste) {
                        throw new \RuntimeException('Uno de los productos del carrito ya no existe.');
                    }
                    PedidoDetalle::create([
                        'pedido_id' => $pedido->getKey(),
                        'producto_id' => $productoId,
                        'cantidad' => $item['cantidad'],
                        'precio' => $item['precio'],
                    ]);
                    $subtotal += $item['precio'] * $item['cantidad'];
                }

                $impuestos = round($subtotal * 0.19, 2);
                $totalFactura = $subtotal + $impuestos;

                $ultimoNumero = Factura::max('id') ?? 0;
                $numeroFactura = 'F' . str_pad($ultimoNumero + 1, 6, '0', STR_PAD_LEFT);

                Factura::create([
                    'pedido_id' => $pedido->getKey(),
                    'usuario_id' => $pedido->usuario_id,
                    'numero_factura' => $numeroFactura,
                    'fecha_emision' => now(),
                    'estado_pedido' => $pedido->estado,
                    'subtotal' => $subtotal,
                    'impuestos' => $impuestos,
                    'total' => $totalFactura,
                    // Use column names matching the migration: nombre_cliente, correo_cliente, direccion_cliente, identificacion_cliente
                    'nombre_cliente' => $pedido->nombre,
                    'correo_cliente' => $pedido->email,
                    'direccion_cliente' => $pedido->direccion,
                    'identificacion_cliente' => $pedido->numero_documento ?? $pedido->email,
                ]);

                session()->forget(['carrito', 'checkout.datos', 'checkout.entrega', 'checkout.pago']);
                DB::commit();
                return redirect()->route('pedido.entrega')->with('success', 'Pedido confirmado con éxito.')->with('mensaje', 'Tu pedido #' . $pedido->getKey() . ' fue guardado y ya aparece en la sección Mis pedidos.');
            } catch (\Throwable $e) {
                DB::rollBack();
                report($e);
                $mensaje = app()->isLocal() ? 'No se pudo completar la compra: ' . $e->getMessage() : 'No se pudo completar la compra. Intenta nuevamente.';
                return redirect()->back()->withInput()->with('error', $mensaje);
            }
        }

        // Flujo multi-step: redirigir al paso de entrega
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

    public function datosGuardar(\App\Http\Requests\PedidoDatosRequest $request)
    {
        $validated = $request->validated();
        session(['checkout.datos' => $validated]);
        return redirect()->route('pedido.entrega');
    }

    // Paso 2: Formulario de entrega
    public function entregaForm(Request $request)
    {
        $carrito = collect(session()->get('carrito', []))
            ->filter(fn($item) => (int) ($item['cantidad'] ?? 0) > 0)
            ->all();

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

    public function entregaGuardar(\App\Http\Requests\PedidoEntregaRequest $request)
    {
        $validated = $request->validated();
        session(['checkout.entrega' => $validated]);
        return redirect()->route('pedido.pago');
    }

    // Paso 3: Formulario de pago
    public function pagoForm(Request $request)
    {
        $carrito = collect(session()->get('carrito', []))
            ->filter(fn($item) => (int) ($item['cantidad'] ?? 0) > 0)
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

    public function pagoGuardar(\App\Http\Requests\PedidoPagoRequest $request)
    {
        $validated = $request->validated();

        $rutaComprobante = null;
        if ($request->hasFile('comprobante_pago')) {
            try {
                $rutaComprobante = Storage::disk('public')->putFile('comprobantes', $request->file('comprobante_pago'));
            } catch (\Throwable $e) {
                Log::warning('No se pudo guardar comprobante en pagoGuardar: ' . $e->getMessage());
                $rutaComprobante = null;
            }
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
                'usuario_id' => auth()->id(),
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
            foreach ($carrito as $productoId => $item) {
                $productoExiste = Producto::whereKey($productoId)->exists();
                if (!$productoExiste) {
                    throw new \RuntimeException('Uno de los productos del carrito ya no existe.');
                }
                PedidoDetalle::create([
                    'pedido_id' => $pedido->getKey(),
                    'producto_id' => $productoId,
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                ]);
                $subtotal += $item['precio'] * $item['cantidad'];
            }

            $impuestos = round($subtotal * 0.19, 2);
            $totalFactura = $subtotal + $impuestos;

            $ultimoNumero = Factura::max('id') ?? 0;
            $numeroFactura = 'F' . str_pad($ultimoNumero + 1, 6, '0', STR_PAD_LEFT);

            Factura::create([
                'pedido_id' => $pedido->getKey(),
                'usuario_id' => $pedido->usuario_id,
                'numero_factura' => $numeroFactura,
                'fecha_emision' => now(),
                'estado_pedido' => $pedido->estado,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'total' => $totalFactura,
                'nombre_cliente' => $pedido->nombre,
                'correo_cliente' => $pedido->email,
                'direccion_cliente' => $pedido->direccion,
                'identificacion_cliente' => $pedido->numero_documento ?? $pedido->email,
            ]);

            session()->forget(['carrito', 'checkout.datos', 'checkout.entrega', 'checkout.pago']);
            DB::commit();
            return redirect()->route('perfil.pedidos')->with('success', 'Pedido confirmado con éxito.')->with('mensaje', 'Tu pedido #' . $pedido->getKey() . ' fue guardado y ya aparece en la sección Mis pedidos.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            $mensaje = app()->isLocal() ? 'No se pudo completar la compra: ' . $e->getMessage() : 'No se pudo completar la compra. Intenta nuevamente.';
            return redirect()->back()->withInput()->with('error', $mensaje);
        }
    }

    /**
     * Listado de pedidos del usuario autenticado (Mis pedidos).
     */
    public function misPedidos(Request $request)
    {
        $userId = auth()->id();
        $texto = $request->input('texto', '');

        $query = Pedido::with(['detalles.producto', 'factura'])
            ->where('usuario_id', $userId);

        if (!empty($texto)) {
            $query->where(function ($q) use ($texto) {
                $q->where('nombre', 'like', "%{$texto}%")
                  ->orWhere('email', 'like', "%{$texto}%")
                  ->orWhere('estado', 'like', "%{$texto}%");
            });
        }

        $registros = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        $totalPedidos = Pedido::where('usuario_id', $userId)->count();
        $gastoTotal = (float) (Pedido::where('usuario_id', $userId)->sum('total') ?? 0);
        $pendientes = Pedido::where('usuario_id', $userId)->where('estado', 'pendiente')->count();
        $enviados = Pedido::where('usuario_id', $userId)->where('estado', 'enviado')->count();
        $cancelados = Pedido::where('usuario_id', $userId)->whereIn('estado', ['cancelado', 'anulado'])->count();
        $conFactura = Pedido::where('usuario_id', $userId)->whereHas('factura')->count();

        $resumen = [
            'totalPedidos' => $totalPedidos,
            'gastoTotal' => $gastoTotal,
            'pendientes' => $pendientes,
            'enviados' => $enviados,
            'cancelados' => $cancelados,
            'conFactura' => $conFactura,
        ];

        return view('web.mis_pedidos', compact('registros', 'resumen', 'texto'));
    }

    /**
     * Cambia el estado de un pedido (ruta PATCH /pedidos/{id}/estado)
     */
    public function cambiarEstado(Request $request, $id)
    {
        Log::info('cambiarEstado called', ['id' => $id, 'input' => $request->all(), 'user_id' => optional(auth()->user())->getKey()]);
        $validated = $request->validate([
            'estado' => ['required', Rule::in(['pendiente', 'enviado', 'anulado', 'cancelado'])],
        ]);

        Log::info('cambiarEstado validated', ['validated' => $validated]);

        $pedido = Pedido::findOrFail($id);

        $user = auth()->user();
        if (!$user || (! $user->can('pedido-cancel') && ! $user->can('pedido-anulate'))) {
            return redirect()->back()->with('error', 'No autorizado para cambiar el estado del pedido.');
        }

        $old = $pedido->estado;
        $pedido->estado = $validated['estado'];
        $saved = $pedido->save();
        Log::info('cambiarEstado save result', ['old' => $old, 'new' => $pedido->estado, 'saved' => $saved, 'pedido_id' => $pedido->getKey()]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado. (' . $old . ' → ' . $pedido->estado . ')');
    }

}