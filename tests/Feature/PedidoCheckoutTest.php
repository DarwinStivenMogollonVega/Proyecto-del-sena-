<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_guarda_pedido_y_detalles_y_redirige_al_index(): void
    {
        $user = User::factory()->create();

        $producto = Producto::create([
            'codigo' => 'SKU-1001',
            'nombre' => 'Disco de prueba',
            'precio' => 123123.00,
            'cantidad' => 10,
            'descripcion' => 'Producto para prueba de checkout',
        ]);

        $carrito = [
            $producto->id => [
                'codigo' => $producto->codigo,
                'nombre' => $producto->nombre,
                'precio' => (float) $producto->precio,
                'imagen' => null,
                'cantidad' => 2,
            ],
        ];

        $response = $this->actingAs($user)
            ->withSession(['carrito' => $carrito])
            ->post(route('pedido.realizar'), [
                'nombre' => 'Cliente Test',
                'email' => 'cliente@test.com',
                'telefono' => '3001234567',
                'direccion' => 'Calle 123 #45-67',
                'metodo_pago' => 'efectivo',
            ]);

        $response->assertRedirect(route('web.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pedidos', [
            'usuario_id' => $user->id,
            'nombre' => 'Cliente Test',
            'email' => 'cliente@test.com',
            'telefono' => '3001234567',
            'direccion' => 'Calle 123 #45-67',
            'metodo_pago' => 'efectivo',
            'estado' => 'pendiente',
            'total' => 246246.00,
        ]);

        $this->assertDatabaseHas('pedido_detalles', [
            'producto_id' => $producto->id,
            'cantidad' => 2,
            'precio' => 123123.00,
        ]);

        $response->assertSessionMissing('carrito');
    }

    public function test_checkout_guarda_datos_de_factura_electronica_cuando_se_solicita(): void
    {
        $user = User::factory()->create();

        $producto = Producto::create([
            'codigo' => 'SKU-1002',
            'nombre' => 'Disco FE',
            'precio' => 50000.00,
            'cantidad' => 8,
            'descripcion' => 'Producto para prueba de factura electronica',
        ]);

        $carrito = [
            $producto->id => [
                'codigo' => $producto->codigo,
                'nombre' => $producto->nombre,
                'precio' => (float) $producto->precio,
                'imagen' => null,
                'cantidad' => 1,
            ],
        ];

        $response = $this->actingAs($user)
            ->withSession(['carrito' => $carrito])
            ->post(route('pedido.realizar'), [
                'nombre' => 'Empresa Test SAS',
                'email' => 'compras@empresa.test',
                'telefono' => '3010000000',
                'direccion' => 'Avenida 123 #10-20',
                'metodo_pago' => 'tarjeta',
                'requiere_factura_electronica' => '1',
                'tipo_documento' => 'nit',
                'numero_documento' => '900123456-7',
                'razon_social' => 'Empresa Test SAS',
                'correo_factura' => 'facturas@empresa.test',
            ]);

        $response->assertRedirect(route('web.index'));

        $this->assertDatabaseHas('pedidos', [
            'usuario_id' => $user->id,
            'requiere_factura_electronica' => 1,
            'tipo_documento' => 'nit',
            'numero_documento' => '900123456-7',
            'razon_social' => 'Empresa Test SAS',
            'correo_factura' => 'facturas@empresa.test',
        ]);
    }
}
