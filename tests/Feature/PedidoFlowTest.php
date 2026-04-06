<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Proveedor;
use App\Models\Catalogo as CatalogoModel;
use App\Models\Artista;
use App\Models\InventarioMovimiento;
use App\Models\ProductoResena;
use App\Models\AdminActivityLog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class PedidoFlowTest extends TestCase
{
    public function test_get_datos_entrega_pago_pages_and_post_actions()
    {
        // Ensure minimal DB setup from TestDbSetup is available
        if (! Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->increments('usuario_id');
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Unregister AnalyticsObserver side-effects by flushing model event listeners
        Producto::flushEventListeners();
        Pedido::flushEventListeners();
        PedidoDetalle::flushEventListeners();
        Proveedor::flushEventListeners();
        CatalogoModel::flushEventListeners();
        Artista::flushEventListeners();
        InventarioMovimiento::flushEventListeners();
        ProductoResena::flushEventListeners();
        AdminActivityLog::flushEventListeners();
        User::flushEventListeners();

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
        ]);

        // Ensure a minimal productos table and a product for the cart
        if (! Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre');
                $table->integer('cantidad')->default(0);
                $table->decimal('precio', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        // Ensure minimal pedidos, pedido_detalles and facturas tables so controller can persist
        if (! Schema::hasTable('pedidos')) {
            Schema::create('pedidos', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('usuario_id');
                $table->decimal('total', 10, 2)->default(0);
                $table->string('estado')->nullable();
                $table->string('nombre')->nullable();
                $table->string('email')->nullable();
                $table->string('telefono')->nullable();
                $table->text('direccion')->nullable();
                $table->string('metodo_pago')->nullable();
                $table->string('comprobante_pago')->nullable();
                $table->boolean('requiere_factura_electronica')->default(false);
                $table->string('tipo_documento')->nullable();
                $table->string('numero_documento')->nullable();
                $table->string('razon_social')->nullable();
                $table->string('correo_factura')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('pedido_detalles')) {
            Schema::create('pedido_detalles', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('pedido_id');
                $table->unsignedInteger('producto_id');
                $table->integer('cantidad');
                $table->decimal('precio', 10, 2);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('facturas')) {
            Schema::create('facturas', function (Blueprint $table) {
                $table->increments('factura_id');
                $table->unsignedInteger('pedido_id');
                $table->unsignedInteger('usuario_id');
                $table->string('numero_factura')->nullable();
                $table->timestamp('fecha_emision')->nullable();
                $table->string('estado_pedido')->nullable();
                $table->decimal('subtotal', 10, 2)->default(0);
                $table->decimal('impuestos', 10, 2)->default(0);
                $table->decimal('total', 10, 2)->default(0);
                $table->string('nombre_cliente')->nullable();
                $table->string('correo_cliente')->nullable();
                $table->string('telefono_cliente')->nullable();
                $table->text('direccion_cliente')->nullable();
                $table->string('identificacion_cliente')->nullable();
                $table->timestamps();
            });
        }

        DB::table('productos')->insertOrIgnore([
            'id' => 1,
            'nombre' => 'Test Producto',
            'cantidad' => 10,
            'precio' => 100.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Put a product in the session cart so checkout steps succeed
        session(['carrito' => [1 => ['cantidad' => 1, 'precio' => 100, 'descuento' => 0]]]);

        $cart = ['carrito' => [1 => ['cantidad' => 1, 'precio' => 100, 'descuento' => 0]]];

        \Illuminate\Database\Eloquent\Model::withoutEvents(function () use ($user, $cart) {
            $obStartLevel = ob_get_level();
            $this->withSession($cart)
                ->actingAs($user)
                ->get(route('pedido.datos'))
                ->assertStatus(200);

            $postDatos = [
                'nombre' => 'Test User',
                'email' => 't@example.com',
                'telefono' => '123456',
                'direccion' => 'Calle 1',
            ];

            $this->withSession($cart)
                ->actingAs($user)
                ->post(route('pedido.datos.guardar'), $postDatos)
                ->assertRedirect();

            $this->withSession(array_merge($cart, ['checkout.datos' => $postDatos]))
                ->actingAs($user)
                ->get(route('pedido.entrega'))
                ->assertStatus(200);

            $postEntrega = ['direccion_entrega' => 'Calle 2'];
            $this->withSession(array_merge($cart, ['checkout.datos' => $postDatos]))
                ->actingAs($user)
                ->post(route('pedido.entrega.guardar'), $postEntrega)
                ->assertRedirect();

            $this->withSession(array_merge($cart, ['checkout.datos' => $postDatos, 'checkout.entrega' => $postEntrega]))
                ->actingAs($user)
                ->get(route('pedido.pago'))
                ->assertStatus(200);

            $postPago = [
                'metodo_pago' => 'nequi',
                'nequi_celular' => '3001234567',
            ];

            $file = UploadedFile::fake()->image('comprobante.jpg');

            $this->withSession(array_merge($cart, ['checkout.datos' => $postDatos, 'checkout.entrega' => $postEntrega]))
                ->actingAs($user)
                ->post(route('pedido.pago.guardar'), array_merge($postPago, ['comprobante_pago' => $file]))
                ->assertRedirect();

            // Assert DB records were created
            $this->assertDatabaseCount('pedidos', 1);
            $this->assertDatabaseCount('pedido_detalles', 1);
            $this->assertDatabaseCount('facturas', 1);

            // Close only buffers opened during this test to avoid interfering with PHPUnit's buffers
            while (ob_get_level() > $obStartLevel) {
                @ob_end_clean();
            }
        });
    }
}
