<?php
namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Pedido;

class PedidoModelTest extends TestCase
{
    public function test_fillable_and_casts()
    {
        $pedido = new Pedido();
        $this->assertContains('usuario_id', $pedido->getFillable());
        $this->assertArrayHasKey('requiere_factura_electronica', $pedido->getCasts());
    }

    public function test_relations_return_relations()
    {
        $pedido = new Pedido();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $pedido->detalles());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $pedido->user());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class, $pedido->factura());
    }
}
