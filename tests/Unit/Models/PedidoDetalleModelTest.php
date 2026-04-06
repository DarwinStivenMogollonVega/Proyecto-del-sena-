<?php
namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\PedidoDetalle;

class PedidoDetalleModelTest extends TestCase
{
    public function test_fillable_and_relations()
    {
        $d = new PedidoDetalle();
        $this->assertContains('pedido_id', $d->getFillable());
        $this->assertContains('producto_id', $d->getFillable());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $d->pedido());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $d->producto());
    }
}
