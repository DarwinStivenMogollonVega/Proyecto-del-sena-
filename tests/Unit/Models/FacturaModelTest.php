<?php
namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Factura;

class FacturaModelTest extends TestCase
{
    public function test_fillable_and_casts()
    {
        $f = new Factura();
        $this->assertContains('pedido_id', $f->getFillable());
        $this->assertArrayHasKey('total', $f->getCasts());
    }

    public function test_relations_return_relations()
    {
        $f = new Factura();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $f->pedido());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $f->user());
    }
}
