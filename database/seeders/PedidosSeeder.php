<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use Faker\Factory as Faker;

class PedidosSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_CO');

        // Obtener clientes (usuarios con rol 'cliente') o fallback a todos excepto admin
        try {
            $clientes = User::role('cliente')->get();
        } catch (\Throwable $e) {
            $clientes = User::where('email', '<>', 'admin@tienda.test')->get();
        }

        if ($clientes->isEmpty()) {
            return;
        }

        $productos = Producto::all();
        if ($productos->isEmpty()) {
            return;
        }

        // Configurables: rangos y probabilidades via .env
        $minPedidos = max(1, intval(env('PEDIDOS_MIN', 10)));
        $maxPedidos = max($minPedidos, intval(env('PEDIDOS_MAX', 30)));
        $totalPedidos = rand($minPedidos, $maxPedidos);

        $estadoWeights = json_decode(env('PEDIDO_ESTADO_WEIGHTS', json_encode([
            'pendiente' => 50,
            'pagado' => 35,
            'enviado' => 10,
            'cancelado' => 5,
        ])), true);

        $pickEstado = function (array $weights) {
            $total = array_sum($weights);
            $r = rand(1, (int) $total);
            $acc = 0;
            foreach ($weights as $k => $w) {
                $acc += $w;
                if ($r <= $acc) return $k;
            }
            return array_key_first($weights);
        };

        DB::transaction(function () use ($faker, $clientes, $productos, $totalPedidos, $estadoWeights, $pickEstado) {
            for ($i = 0; $i < $totalPedidos; $i++) {
                $cliente = $clientes->random();

                $estado = $pickEstado($estadoWeights);

                $pedido = Pedido::create([
                    'usuario_id' => $cliente->getIdAttribute() ?? $cliente->{$cliente->getKeyName()} ?? $cliente->id,
                    'total' => 0,
                    'estado' => $estado,
                    'nombre' => $cliente->name,
                    'email' => $cliente->email,
                    'telefono' => $cliente->telefono ?? $faker->phoneNumber,
                    'direccion' => $cliente->direccion ?? $faker->address,
                    'metodo_pago' => $faker->randomElement(['transferencia', 'efectivo', 'tarjeta']),
                    'comprobante_pago' => null,
                    'requiere_factura_electronica' => $faker->boolean(60),
                    // Documento para facturación (puede venir del usuario o generarse aquí)
                    'tipo_documento' => $faker->randomElement(['cedula', 'nit', 'pasaporte']),
                    'numero_documento' => $faker->numerify($faker->randomElement(['#########', '##########', '###########'])),
                ]);

                // Elegir entre 1 y 5 productos distintos
                $numItems = rand(1, 5);
                $selected = $productos->random($numItems);

                $subtotal = 0.0;
                foreach ($selected as $prod) {
                    $cantidad = rand(1, 3);
                    $precio = (float) $prod->precio;
                    $lineTotal = round($precio * $cantidad, 2);

                    PedidoDetalle::create([
                        'pedido_id' => $pedido->id ?? $pedido->getKey(),
                        'producto_id' => $prod->getKey(),
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                    ]);

                    $subtotal += $lineTotal;
                }

                // Actualizar total
                $pedido->total = round($subtotal, 2);
                $pedido->save();
            }
        });
    }
}
