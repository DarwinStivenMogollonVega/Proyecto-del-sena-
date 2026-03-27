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
            ->orderByDesc((new User())->getKeyName())
            ->paginate(12);

        return view('cliente_gestion.index', compact('registros', 'texto'));
    }

    public function show($id)
    {
        abort_unless(auth()->user()->can('user-list'), 403);

        $cliente = User::with('roles')->findOrFail($id);

        $pedidos = Pedido::where('usuario_id', $cliente->getKey())
            ->latest((new Pedido())->getKeyName())
            ->paginate(10);

        $stats = [
            'totalPedidos' => Pedido::where('usuario_id', $cliente->getKey())->count(),
            'gastoTotal' => (float) (Pedido::where('usuario_id', $cliente->getKey())->sum('total') ?? 0),
            'direccionesRegistradas' => Pedido::where('usuario_id', $cliente->getKey())->whereNotNull('direccion')->distinct('direccion')->count('direccion'),
            'ultimaCompra' => Pedido::where('usuario_id', $cliente->getKey())->latest((new Pedido())->getKeyName())->value('created_at'),
        ];

        return view('cliente_gestion.show', compact('cliente', 'pedidos', 'stats'));
    }
}
