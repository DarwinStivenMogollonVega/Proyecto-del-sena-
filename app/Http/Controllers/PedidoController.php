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
    public function index(Request $request)
    {
        return $this->misPedidos($request);
    }

    public function adminIndex(Request $request)
    {
        if (!auth()->user()->can('pedido-list')) {
            abort(403, 'No tienes permisos para ver todos los pedidos.');
        }

        $texto = $request->input('texto');
        $query = Pedido::with('user', 'detalles.producto')->orderBy('id', 'desc');

        if (!empty($texto)) {
            $query->whereHas('user', function ($q) use ($texto) {
                $q->where('name', 'like', "%{$texto}%");
            });
        }

        $registros = $query->paginate(10);

        return view('pedido.index', [
            'registros' => $registros,
            'texto' => $texto,
            'esAdmin' => true,
        ]);
    }

    public function misPedidos(Request $request)
    {
        $texto = $request->input('texto');
        $baseQuery = Pedido::where('user_id', auth()->id());

        $query = Pedido::with('user', 'detalles.producto')
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc');

        $query->with('factura');

        if (!empty($texto)) {
            $query->where(function ($q) use ($texto) {
                $q->where('estado', 'like', "%{$texto}%")
                    ->orWhere('id', 'like', "%{$texto}%");
            });
        }

        $registros = $query->paginate(10);

        $resumen = [
            'totalPedidos' => (clone $baseQuery)->count(),
            'gastoTotal' => (float) ((clone $baseQuery)->sum('total') ?? 0),
            'pendientes' => (clone $baseQuery)->where('estado', 'pendiente')->count(),
            'enviados' => (clone $baseQuery)->where('estado', 'enviado')->count(),
            'cancelados' => (clone $baseQuery)->whereIn('estado', ['cancelado', 'anulado'])->count(),
            'conFactura' => Factura::where('user_id', auth()->id())->count(),
        ];

        return view('web.mis_pedidos', [
            'registros' => $registros,
            'texto' => $texto,
            'resumen' => $resumen,
        ]);
    }

    public function formulario()
    {
        $carrito = collect(session()->get('carrito', []))
            ->filter(function ($item) {
                return (int) ($item['cantidad'] ?? 0) > 0;
            })
            ->all();

        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'No puedes acceder al formulario de pago sin articulos en el carrito.');
        }

        return view('web.formulario_pedido', compact('carrito'));
    }

    public function realizar(Request $request)
    {
        $carrito = session()->get('carrito', []);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'telefono' => ['required', 'string', 'max:30'],
            'direccion' => ['required', 'string', 'max:255'],
            'metodo_pago' => ['required', 'string', 'max:30'],
            'comprobante_pago' => ['required_if:metodo_pago,nequi', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'requiere_factura_electronica' => ['nullable', 'boolean'],
            'tipo_documento' => ['required_if:requiere_factura_electronica,1', 'nullable', Rule::in(['nit', 'cedula'])],
            'numero_documento' => ['required_if:requiere_factura_electronica,1', 'nullable', 'string', 'max:40'],
            'razon_social' => ['required_if:requiere_factura_electronica,1', 'nullable', 'string', 'max:140'],
            'correo_factura' => ['required_if:requiere_factura_electronica,1', 'nullable', 'email', 'max:120'],
        ]);

        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'No puedes acceder al formulario de pago sin articulos en el carrito.');
        }

        DB::beginTransaction();

        try {
            $rutaComprobante = null;
            if ($request->hasFile('comprobante_pago')) {
                $rutaComprobante = $request->file('comprobante_pago')->store('comprobantes', 'public');
            }

            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $requiereFactura = $request->boolean('requiere_factura_electronica');

            $pedido = Pedido::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'estado' => 'pendiente',
                'nombre' => $datos['nombre'],
                'email' => $datos['email'],
                'telefono' => $datos['telefono'],
                'direccion' => $datos['direccion'],
                'metodo_pago' => $datos['metodo_pago'],
                'comprobante_pago' => $rutaComprobante,
                'requiere_factura_electronica' => $requiereFactura,
                'tipo_documento' => $requiereFactura ? ($datos['tipo_documento'] ?? null) : null,
                'numero_documento' => $requiereFactura ? ($datos['numero_documento'] ?? null) : null,
                'razon_social' => $requiereFactura ? ($datos['razon_social'] ?? null) : null,
                'correo_factura' => $requiereFactura ? ($datos['correo_factura'] ?? null) : null,
            ]);

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
            }

            session()->forget('carrito');

            DB::commit();

            return redirect()
                ->route('web.index')
                ->with('success', 'Pedido confirmado con exito.')
                ->with('mensaje', 'Tu pedido #' . $pedido->id . ' fue guardado y ya aparece en la seccion Mis pedidos.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            $mensaje = app()->isLocal()
                ? 'No se pudo completar la compra: ' . $e->getMessage()
                : 'No se pudo completar la compra. Intenta nuevamente.';

            return redirect()->back()->withInput()->with('error', $mensaje);
        }
    }

    public function recibosFactura(Request $request)
    {
        $texto = trim((string) $request->input('texto'));

        $baseQuery = Pedido::where('user_id', auth()->id())
            ->where('requiere_factura_electronica', true);

        $query = Pedido::with('detalles.producto')
            ->where('user_id', auth()->id())
            ->where('requiere_factura_electronica', true)
            ->orderByDesc('id');

        if ($texto !== '') {
            $query->where(function ($q) use ($texto) {
                $q->where('id', 'like', "%{$texto}%")
                    ->orWhere('numero_documento', 'like', "%{$texto}%")
                    ->orWhere('razon_social', 'like', "%{$texto}%");
            });
        }

        $registros = $query->paginate(10);

        $resumen = [
            'totalRecibos' => (clone $baseQuery)->count(),
            'montoFacturado' => (float) ((clone $baseQuery)->sum('total') ?? 0),
        ];

        return view('web.recibos_factura', [
            'registros' => $registros,
            'texto' => $texto,
            'resumen' => $resumen,
        ]);
    }

    public function verReciboFactura($id)
    {
        $query = Pedido::with('detalles.producto')
            ->where('id', $id)
            ->where('requiere_factura_electronica', true);

        if (!auth()->user()->can('pedido-list')) {
            $query->where('user_id', auth()->id());
        }

        $pedido = $query->firstOrFail();

        return view('web.recibo_factura_detalle', compact('pedido'));
    }

    public function adminFacturasIndex(Request $request)
    {
        if (!auth()->user()->can('pedido-list')) {
            abort(403, 'No tienes permisos para gestionar facturas.');
        }

        $texto = trim((string) $request->input('texto'));

        $query = Pedido::with('user')
            ->where('requiere_factura_electronica', true)
            ->orderByDesc('id');

        if ($texto !== '') {
            $query->where(function ($q) use ($texto) {
                $q->where('id', 'like', "%{$texto}%")
                    ->orWhere('numero_documento', 'like', "%{$texto}%")
                    ->orWhere('razon_social', 'like', "%{$texto}%")
                    ->orWhere('correo_factura', 'like', "%{$texto}%")
                    ->orWhereHas('user', function ($u) use ($texto) {
                        $u->where('name', 'like', "%{$texto}%")
                            ->orWhere('email', 'like', "%{$texto}%");
                    });
            });
        }

        $registros = $query->paginate(12);

        return view('admin.facturas.index', compact('registros', 'texto'));
    }

    public function adminFacturasCreate()
    {
        if (!auth()->user()->can('pedido-list')) {
            abort(403, 'No tienes permisos para crear facturas.');
        }

        $usuarios = User::orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.facturas.create', compact('usuarios'));
    }

    public function adminFacturasStore(Request $request)
    {
        if (!auth()->user()->can('pedido-list')) {
            abort(403, 'No tienes permisos para crear facturas.');
        }

        $datos = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'nombre' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'telefono' => ['required', 'string', 'max:30'],
            'direccion' => ['required', 'string', 'max:255'],
            'metodo_pago' => ['required', 'string', 'max:30'],
            'total' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', Rule::in(['pendiente', 'enviado', 'entregado', 'cancelado', 'anulado'])],
            'tipo_documento' => ['required', Rule::in(['nit', 'cedula'])],
            'numero_documento' => ['required', 'string', 'max:40'],
            'razon_social' => ['required', 'string', 'max:140'],
            'correo_factura' => ['required', 'email', 'max:120'],
        ]);

        Pedido::create([
            'user_id' => $datos['user_id'],
            'total' => $datos['total'],
            'estado' => $datos['estado'],
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'],
            'direccion' => $datos['direccion'],
            'metodo_pago' => $datos['metodo_pago'],
            'requiere_factura_electronica' => true,
            'tipo_documento' => $datos['tipo_documento'],
            'numero_documento' => $datos['numero_documento'],
            'razon_social' => $datos['razon_social'],
            'correo_factura' => $datos['correo_factura'],
        ]);

        return redirect()->route('admin.facturas.index')->with('mensaje', 'Factura creada correctamente.');
    }

    public function adminFacturasEdit($id)
    {
        if (!auth()->user()->can('pedido-list')) {
            abort(403, 'No tienes permisos para editar facturas.');
        }

        $registro = Pedido::where('requiere_factura_electronica', true)->findOrFail($id);
        $usuarios = User::orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.facturas.edit', compact('registro', 'usuarios'));
    }

    public function adminFacturasUpdate(Request $request, $id)
    {
        if (!auth()->user()->can('pedido-list')) {
            abort(403, 'No tienes permisos para editar facturas.');
        }

        $registro = Pedido::where('requiere_factura_electronica', true)->findOrFail($id);

        $datos = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'nombre' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'telefono' => ['required', 'string', 'max:30'],
            'direccion' => ['required', 'string', 'max:255'],
            'metodo_pago' => ['required', 'string', 'max:30'],
            'total' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', Rule::in(['pendiente', 'enviado', 'entregado', 'cancelado', 'anulado'])],
            'tipo_documento' => ['required', Rule::in(['nit', 'cedula'])],
            'numero_documento' => ['required', 'string', 'max:40'],
            'razon_social' => ['required', 'string', 'max:140'],
            'correo_factura' => ['required', 'email', 'max:120'],
        ]);

        $registro->update([
            'user_id' => $datos['user_id'],
            'total' => $datos['total'],
            'estado' => $datos['estado'],
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'],
            'direccion' => $datos['direccion'],
            'metodo_pago' => $datos['metodo_pago'],
            'requiere_factura_electronica' => true,
            'tipo_documento' => $datos['tipo_documento'],
            'numero_documento' => $datos['numero_documento'],
            'razon_social' => $datos['razon_social'],
            'correo_factura' => $datos['correo_factura'],
        ]);

        return redirect()->route('admin.facturas.index')->with('mensaje', 'Factura actualizada correctamente.');
    }

    public function adminFacturasDestroy($id)
    {
        if (!auth()->user()->can('pedido-list')) {
            abort(403, 'No tienes permisos para eliminar facturas.');
        }

        $registro = Pedido::where('requiere_factura_electronica', true)->findOrFail($id);
        $registro->delete();

        return redirect()->route('admin.facturas.index')->with('mensaje', 'Factura eliminada correctamente.');
    }

    public function cambiarEstado(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $estadoNuevo = $request->input('estado');

        $estadosPermitidos = ['enviado', 'anulado', 'cancelado'];

        if (!in_array($estadoNuevo, $estadosPermitidos)) {
            abort(403, 'Estado no válido');
        }

        if (in_array($estadoNuevo, ['enviado', 'anulado'])) {
            if (!auth()->user()->can('pedido-anulate')) {
                abort(403, 'No tiene permiso para cambiar a "enviado" o "anulado"');
            }
        }

        if ($estadoNuevo === 'cancelado') {
            if (!auth()->user()->can('pedido-cancel')) {
                abort(403, 'No tiene permiso para cancelar pedidos');
            }
        }

        $pedido->estado = $estadoNuevo;
        $pedido->save();

        return redirect()->back()->with('mensaje', 'El estado del pedido fue actualizado a "' . ucfirst($estadoNuevo) . '"');
    }
}