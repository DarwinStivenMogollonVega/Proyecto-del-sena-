<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;

class ClienteGestionController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('user-list'), 403);

        $texto = trim((string) $request->input('texto'));

        $registros = User::query()
            ->whereHas('roles', fn ($q) => $q->where('name', 'cliente'))
            ->when($texto !== '', function ($q) use ($texto) {
                $q->where('name', 'like', "%{$texto}%")
                    ->orWhere('email', 'like', "%{$texto}%");
            })
            ->withCount('pedidos')
            ->orderByDesc('id')
            ->paginate(12);

        return view('cliente_gestion.index', compact('registros', 'texto'));
    }

    public function show($id)
    {
        abort_unless(auth()->user()->can('user-list'), 403);

        $cliente = User::with('roles')->findOrFail($id);

        $pedidos = Pedido::where('user_id', $cliente->id)
            ->latest('id')
            ->paginate(10);

        $stats = [
            'totalPedidos' => Pedido::where('user_id', $cliente->id)->count(),
            'gastoTotal' => (float) (Pedido::where('user_id', $cliente->id)->sum('total') ?? 0),
            'direccionesRegistradas' => Pedido::where('user_id', $cliente->id)->whereNotNull('direccion')->distinct('direccion')->count('direccion'),
            'ultimaCompra' => Pedido::where('user_id', $cliente->id)->latest('id')->value('created_at'),
        ];

        return view('cliente_gestion.show', compact('cliente', 'pedidos', 'stats'));
    }
}
