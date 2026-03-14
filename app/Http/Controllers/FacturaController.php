<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function index(Request $request)
    {
        $texto = trim((string) $request->input('texto'));

        $query = Factura::with('pedido')
            ->where('user_id', auth()->id())
            ->orderByDesc('id');

        if ($texto !== '') {
            $query->where(function ($q) use ($texto) {
                $q->where('numero_factura', 'like', "%{$texto}%")
                    ->orWhere('cliente_nombre', 'like', "%{$texto}%")
                    ->orWhere('cliente_identificacion', 'like', "%{$texto}%")
                    ->orWhereHas('pedido', function ($p) use ($texto) {
                        $p->where('id', 'like', "%{$texto}%");
                    });
            });
        }

        $registros = $query->paginate(10);

        $baseQuery = Factura::where('user_id', auth()->id());
        $resumen = [
            'totalRecibos' => (clone $baseQuery)->count(),
            'montoFacturado' => (float) ((clone $baseQuery)->sum('total') ?? 0),
        ];

        return view('web.recibos_factura', compact('registros', 'texto', 'resumen'));
    }

    public function generarDesdePedido($pedidoId)
    {
        $pedido = Pedido::with(['detalles.producto', 'user'])
            ->where('id', $pedidoId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $factura = $this->crearFacturaDesdePedido($pedido);

        return redirect()->route('perfil.facturas.show', $factura->id);
    }

    public function show($id)
    {
        $factura = Factura::with(['pedido.detalles.producto', 'pedido.user'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('web.recibo_factura_detalle', compact('factura'));
    }

    public function pdf($id)
    {
        $factura = Factura::with(['pedido.detalles.producto', 'pedido.user'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('web.factura_pdf', compact('factura'))->setPaper('a4');

        return $pdf->download('factura-' . $factura->numero_factura . '.pdf');
    }

    private function crearFacturaDesdePedido(Pedido $pedido): Factura
    {
        $existente = Factura::where('pedido_id', $pedido->id)->first();

        if ($existente) {
            return $existente->fresh(['pedido.detalles.producto', 'pedido.user']);
        }

        return DB::transaction(function () use ($pedido) {
            $subtotal = (float) $pedido->detalles->sum(function ($detalle) {
                return ((float) $detalle->precio) * ((int) $detalle->cantidad);
            });

            if ($subtotal <= 0) {
                $subtotal = (float) $pedido->total;
            }

            // Si no se maneja impuesto separado, se conserva el total del pedido y el impuesto es la diferencia.
            $total = (float) $pedido->total;
            $impuestos = max(0, $total - $subtotal);

            $identificacion = trim((string) (($pedido->tipo_documento ? strtoupper($pedido->tipo_documento) . ' ' : '') . ($pedido->numero_documento ?? '')));
            if ($identificacion === '') {
                $identificacion = null;
            }

            $factura = Factura::create([
                'pedido_id' => $pedido->id,
                'user_id' => $pedido->user_id,
                'numero_factura' => null,
                'fecha_emision' => now(),
                'estado_pedido' => (string) $pedido->estado,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'cliente_nombre' => (string) ($pedido->nombre ?: $pedido->user?->name ?: 'Cliente'),
                'cliente_email' => (string) ($pedido->email ?: $pedido->user?->email ?: ''),
                'cliente_direccion' => $pedido->direccion,
                'cliente_identificacion' => $identificacion,
            ]);

            $factura->numero_factura = 'FAC-' . now()->format('Ymd') . '-' . str_pad((string) $factura->id, 6, '0', STR_PAD_LEFT);
            $factura->save();

            return $factura->fresh(['pedido.detalles.producto', 'pedido.user']);
        });
    }
}
